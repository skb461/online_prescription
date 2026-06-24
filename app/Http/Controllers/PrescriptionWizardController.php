<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Prescription;
use App\Models\PrescriptionLog;
use App\Models\PrescriptionComplaint;
use App\Models\PrescriptionExamination;
use App\Models\PrescriptionDiagnosis;
use App\Models\PrescriptionInvestigation;
use App\Models\PrescriptionAdvice;
use App\Models\PrescriptionMedicine;
use App\Models\PrescriptionMedicineDoseDuration;
use App\Models\Complaint;
use App\Models\Examination;
use App\Models\Diagnosis;
use App\Models\Investigation;
use App\Models\Advice;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * ================================================================
 * PRESCRIPTION WIZARD CONTROLLER — pure PHP, multi-step, no JS.
 * ================================================================
 * Each step is its own GET (show form) + POST (save & redirect).
 * All in-progress data lives in the session under the key 'rx_wizard'.
 * Nothing touches the database until the final "Review & Submit" step.
 *
 * Session shape:
 * [
 *   'patient_id'      => int|null,
 *   'patient'          => ['name','age','gender','phone'],
 *   'complaints'       => [['name'=>..,'duration'=>..], ...],
 *   'examinations'     => [['name'=>..,'value'=>..], ...],
 *   'diagnoses'        => ['Diagnosis A', 'Diagnosis B', ...],
 *   'investigations'   => [['name'=>..,'result'=>..], ...],
 *   'medicines'        => [['name'=>..,'dosage'=>..,'timing'=>..,'duration'=>..,'instruction'=>..], ...],
 *   'advices'          => ['Advice A', 'Advice B', ...],
 *   'next_meeting_date'=> 'YYYY-MM-DD'|null,
 * ]
 */
class PrescriptionWizardController extends Controller
{
    private const SESSION_KEY = 'rx_wizard';

    // =========================================================================
    // Helpers
    // =========================================================================

    private function resolveDoctor(): ?Doctor
    {
        if (Auth::check()) {
            $doc = Doctor::where('user_id', Auth::id())->where('doctors_status', 1)->first();
            if ($doc) return $doc;
        }
        return Doctor::where('doctors_status', 1)->first();
    }

    /** Get the current wizard state, seeding defaults if empty. */
    private function state(): array
    {
        return Session::get(self::SESSION_KEY, [
            'patient_id'        => null,
            'patient'            => ['name' => '', 'age' => '', 'gender' => '', 'phone' => ''],
            'complaints'         => [],
            'examinations'       => [],
            'diagnoses'          => [],
            'investigations'     => [],
            'medicines'          => [],
            'advices'            => [],
            'next_meeting_date'  => null,
        ]);
    }

    private function saveState(array $state): void
    {
        Session::put(self::SESSION_KEY, $state);
    }

    private function resetState(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    // =========================================================================
    // STEP 0 — Start a brand-new prescription (clears any in-progress wizard)
    // GET /prescriptions/wizard/start
    // =========================================================================
    public function start(): RedirectResponse
    {
        $this->resetState();
        return redirect()->route('prescriptions.wizard.patient');
    }

    // =========================================================================
    // STEP 1 — Patient: select existing or register new
    // GET  /prescriptions/wizard/patient
    // POST /prescriptions/wizard/patient
    // =========================================================================
    public function patientForm()
    {
        $doctor   = $this->resolveDoctor();
        $patients = Patient::where('patient_status', 1)->orderBy('patient_name')->get();
        $state    = $this->state();

        return view('prescriptions.wizard.step1_patient', compact('doctor', 'patients', 'state'));
    }

    public function patientSave(Request $request): RedirectResponse
    {
        $mode = $request->input('mode'); // 'existing' or 'new'
        $state = $this->state();

        if ($mode === 'existing') {
            $request->validate(['patient_id' => 'required|exists:patients,patient_id']);
            $patient = Patient::findOrFail($request->input('patient_id'));

            $state['patient_id'] = $patient->patient_id;
            $state['patient'] = [
                'name'   => $patient->patient_name,
                'age'    => $patient->patient_age,
                'gender' => $patient->patient_gender,
                'phone'  => $patient->patient_phone_number,
            ];
        } else {
            $request->validate([
                'patient_name'   => 'required|string|max:255',
                'patient_age'    => 'required|numeric|min:0|max:150',
                'patient_gender' => 'required|string|max:10',
                'patient_phone'  => 'nullable|string|max:20',
            ]);

            $state['patient_id'] = null; // will be firstOrCreate'd at final submit
            $state['patient'] = [
                'name'   => $request->input('patient_name'),
                'age'    => $request->input('patient_age'),
                'gender' => $request->input('patient_gender'),
                'phone'  => $request->input('patient_phone'),
            ];
        }

        $this->saveState($state);
        return redirect()->route('prescriptions.wizard.complaints');
    }

    // =========================================================================
    // STEP 2 — Complaints
    // =========================================================================
    public function complaintsForm()
    {
        $this->guardPatientSelected();

        $doctor     = $this->resolveDoctor();
        $complaints = Complaint::where('complaint_status', 1)->orderBy('complaint_name')->get();
        $state      = $this->state();

        return view('prescriptions.wizard.step2_complaints', compact('doctor', 'complaints', 'state'));
    }

    public function complaintsSave(Request $request): RedirectResponse
    {
        $state = $this->state();

        $names     = $request->input('complaint_name', []);      // array, one per selected checkbox
        $durations = $request->input('complaint_duration', []);  // matching array
        $customName     = trim((string) $request->input('custom_complaint_name'));
        $customDuration = trim((string) $request->input('custom_complaint_duration'));

        $items = [];
        foreach ($names as $i => $name) {
            if (trim($name) === '') continue;
            $items[] = [
                'name'     => trim($name),
                'duration' => trim($durations[$i] ?? '') ?: '—',
            ];
        }
        if ($customName !== '') {
            $items[] = ['name' => $customName, 'duration' => $customDuration ?: '—'];
        }

        $state['complaints'] = $items;
        $this->saveState($state);

        return redirect()->route('prescriptions.wizard.examinations');
    }

    // =========================================================================
    // STEP 3 — Examinations
    // =========================================================================
    public function examinationsForm()
    {
        $this->guardPatientSelected();

        $doctor       = $this->resolveDoctor();
        $examinations = Examination::where('examination_status', 1)->orderBy('examination_name')->get();
        $state        = $this->state();

        return view('prescriptions.wizard.step3_examinations', compact('doctor', 'examinations', 'state'));
    }

    public function examinationsSave(Request $request): RedirectResponse
    {
        $state = $this->state();

        $names  = $request->input('examination_name', []);
        $values = $request->input('examination_value', []);
        $customName  = trim((string) $request->input('custom_examination_name'));
        $customValue = trim((string) $request->input('custom_examination_value'));

        $items = [];
        foreach ($names as $i => $name) {
            if (trim($name) === '') continue;
            $items[] = [
                'name'  => trim($name),
                'value' => trim($values[$i] ?? '') ?: '—',
            ];
        }
        if ($customName !== '') {
            $items[] = ['name' => $customName, 'value' => $customValue ?: '—'];
        }

        $state['examinations'] = $items;
        $this->saveState($state);

        return redirect()->route('prescriptions.wizard.diagnoses');
    }

    // =========================================================================
    // STEP 4 — Diagnoses
    // =========================================================================
    public function diagnosesForm()
    {
        $this->guardPatientSelected();

        $doctor    = $this->resolveDoctor();
        $diagnoses = Diagnosis::where('diagnosis_status', 1)->orderBy('diagnosis_name')->get();
        $state     = $this->state();

        return view('prescriptions.wizard.step4_diagnoses', compact('doctor', 'diagnoses', 'state'));
    }

    public function diagnosesSave(Request $request): RedirectResponse
    {
        $state = $this->state();

        $selected   = $request->input('diagnosis_name', []); // checkboxes
        $customName = trim((string) $request->input('custom_diagnosis_name'));

        $items = array_values(array_filter(array_map('trim', $selected), fn($v) => $v !== ''));
        if ($customName !== '') {
            $items[] = $customName;
        }

        $state['diagnoses'] = $items;
        $this->saveState($state);

        return redirect()->route('prescriptions.wizard.investigations');
    }

    // =========================================================================
    // STEP 5 — Investigations
    // =========================================================================
    public function investigationsForm()
    {
        $this->guardPatientSelected();

        $doctor         = $this->resolveDoctor();
        $investigations = Investigation::where('investigation_status', 1)->orderBy('investigation_name')->get();
        $state          = $this->state();

        return view('prescriptions.wizard.step5_investigations', compact('doctor', 'investigations', 'state'));
    }

    public function investigationsSave(Request $request): RedirectResponse
    {
        $state = $this->state();

        $names   = $request->input('investigation_name', []);
        $results = $request->input('investigation_result', []);
        $customName   = trim((string) $request->input('custom_investigation_name'));
        $customResult = trim((string) $request->input('custom_investigation_result'));

        $items = [];
        foreach ($names as $i => $name) {
            if (trim($name) === '') continue;
            $items[] = [
                'name'   => trim($name),
                'result' => trim($results[$i] ?? '') ?: '—',
            ];
        }
        if ($customName !== '') {
            $items[] = ['name' => $customName, 'result' => $customResult ?: '—'];
        }

        $state['investigations'] = $items;
        $this->saveState($state);

        return redirect()->route('prescriptions.wizard.medicines');
    }

    // =========================================================================
    // STEP 6 — Medicines (add one at a time, list grows across submits)
    // =========================================================================
    public function medicinesForm()
    {
        $this->guardPatientSelected();

        $doctor   = $this->resolveDoctor();
        $medicines = Medicine::where('medicine_status', 1)->orderBy('medicine_name')->get();
        $units     = MedicineUnit::where('unit_status', 1)->get();
        $state     = $this->state();

        return view('prescriptions.wizard.step6_medicines', compact('doctor', 'medicines', 'units', 'state'));
    }

    /** Adds ONE medicine row to the list and re-shows the same step (so multiple can be added). */
    public function medicinesAdd(Request $request): RedirectResponse
    {
        $request->validate([
            'medicine_name'     => 'required|string|max:255',
            'dose_morning'      => 'nullable|string|max:10',
            'dose_noon'         => 'nullable|string|max:10',
            'dose_night'        => 'nullable|string|max:10',
            'dose_evening'      => 'nullable|string|max:10',
            'medicine_timing'   => 'required|string|max:100',
            'medicine_duration' => 'required|string|max:100',
            'medicine_instruction' => 'nullable|string|max:255',
        ]);

        $state = $this->state();

        $m = $request->input('dose_morning', '0') ?: '0';
        $n = $request->input('dose_noon', '0') ?: '0';
        $night = $request->input('dose_night', '0') ?: '0';
        $e = $request->input('dose_evening', '0') ?: '0';

        $state['medicines'][] = [
            'name'        => $request->input('medicine_name'),
            'dosage'      => "{$m} + {$n} + {$night} + {$e}",
            'timing'      => $request->input('medicine_timing'),
            'duration'    => $request->input('medicine_duration'),
            'instruction' => $request->input('medicine_instruction'),
        ];

        $this->saveState($state);

        return redirect()->route('prescriptions.wizard.medicines')
            ->with('status', 'Medicine added. Add another or continue to Advice.');
    }

    /** Removes one medicine by index. */
    public function medicinesRemove(int $index): RedirectResponse
    {
        $state = $this->state();
        if (isset($state['medicines'][$index])) {
            array_splice($state['medicines'], $index, 1);
        }
        $this->saveState($state);

        return redirect()->route('prescriptions.wizard.medicines');
    }

    /** "Continue" button on the medicines step — no new medicine, just advance. */
    public function medicinesContinue(): RedirectResponse
    {
        return redirect()->route('prescriptions.wizard.advices');
    }

    // =========================================================================
    // STEP 7 — Advices
    // =========================================================================
    public function advicesForm()
    {
        $this->guardPatientSelected();

        $doctor  = $this->resolveDoctor();
        $advices = Advice::where('advice_status', 1)->orderBy('advice_name')->get();
        $state   = $this->state();

        return view('prescriptions.wizard.step7_advices', compact('doctor', 'advices', 'state'));
    }

    public function advicesSave(Request $request): RedirectResponse
    {
        $state = $this->state();

        $selected   = $request->input('advice_name', []);
        $customName = trim((string) $request->input('custom_advice_name'));

        $items = array_values(array_filter(array_map('trim', $selected), fn($v) => $v !== ''));
        if ($customName !== '') {
            $items[] = $customName;
        }

        $state['advices'] = $items;
        $state['next_meeting_date'] = $request->input('next_meeting_date') ?: null;

        $this->saveState($state);

        return redirect()->route('prescriptions.wizard.review');
    }

    // =========================================================================
    // STEP 8 — Review & Submit
    // =========================================================================
    public function reviewForm()
    {
        $this->guardPatientSelected();

        $doctor = $this->resolveDoctor();
        $state  = $this->state();

        return view('prescriptions.wizard.step8_review', compact('doctor', 'state'));
    }

    /** Final submit — writes everything to all 9 tables in one transaction. */
    public function reviewSubmit(Request $request): RedirectResponse
    {
        $state  = $this->state();
        $doctor = $this->resolveDoctor();

        if (!$doctor) {
            return back()->withErrors(['doctor' => 'No active doctor found. Please seed the doctors table.']);
        }
        if (empty($state['patient']['name'])) {
            return redirect()->route('prescriptions.wizard.patient')
                ->withErrors(['patient' => 'Please select or register a patient first.']);
        }

        try {
            $prescriptionId = DB::transaction(function () use ($state, $doctor) {

                // ── 1. Patient (reuse if selected, else firstOrCreate) ───────
                if (!empty($state['patient_id'])) {
                    $patient = Patient::findOrFail($state['patient_id']);
                } else {
                    $patient = Patient::firstOrCreate(
                        [
                            'patient_name'         => $state['patient']['name'],
                            'patient_phone_number' => $state['patient']['phone'] ?: null,
                        ],
                        [
                            'patient_age'    => $state['patient']['age'],
                            'patient_gender' => $state['patient']['gender'],
                            'patient_status' => 1,
                        ]
                    );
                }

                // ── 2. Prescription ──────────────────────────────────────────
                $prescription = Prescription::create([
                    'prescription_for_patient_id'     => $patient->patient_id,
                    'prescription_assigned_doctor_id' => $doctor->doctors_id,
                    'prescription_date'               => now()->toDateString(),
                    'next_meeting_date'               => $state['next_meeting_date'] ?: null,
                    'prescription_status'             => 1,
                ]);

                // ── 3. Prescription Log ──────────────────────────────────────
                $previousId = Prescription::where('prescription_for_patient_id', $patient->patient_id)
                    ->where('prescription_id', '!=', $prescription->prescription_id)
                    ->orderByDesc('prescription_id')
                    ->value('prescription_id');

                PrescriptionLog::create([
                    'prescription_id'          => $prescription->prescription_id,
                    'doctors_id'               => $doctor->doctors_id,
                    'patient_id'               => $patient->patient_id,
                    'prescription_date'        => now()->toDateString(),
                    'previous_prescription_id' => $previousId,
                    'prescription_log_status'  => 1,
                ]);

                // ── 4. Complaints ────────────────────────────────────────────
                foreach ($state['complaints'] as $item) {
                    if (empty($item['name'])) continue;
                    $rec = Complaint::firstOrCreate(
                        ['complaint_name' => $item['name']],
                        ['complaint_assigned_doctor_id' => $doctor->doctors_id, 'complaint_status' => 1]
                    );
                    PrescriptionComplaint::create([
                        'prescription_id' => $prescription->prescription_id,
                        'complaint_id'    => $rec->complaint_id,
                    ]);
                }

                // ── 5. Examinations ──────────────────────────────────────────
                foreach ($state['examinations'] as $item) {
                    if (empty($item['name'])) continue;
                    $rec = Examination::firstOrCreate(
                        ['examination_name' => $item['name']],
                        ['examination_assigned_doctor_id' => $doctor->doctors_id, 'examination_status' => 1]
                    );
                    PrescriptionExamination::create([
                        'prescription_id'   => $prescription->prescription_id,
                        'examination_id'    => $rec->examination_id,
                        'examination_value' => $item['value'] ?? null,
                    ]);
                }

                // ── 6. Diagnoses ─────────────────────────────────────────────
                foreach ($state['diagnoses'] as $name) {
                    if (empty($name)) continue;
                    $rec = Diagnosis::firstOrCreate(
                        ['diagnosis_name' => $name],
                        ['diagnosis_assigned_doctor_id' => $doctor->doctors_id, 'diagnosis_status' => 1]
                    );
                    PrescriptionDiagnosis::create([
                        'prescription_id' => $prescription->prescription_id,
                        'diagnosis_id'    => $rec->diagnosis_id,
                    ]);
                }

                // ── 7. Investigations ────────────────────────────────────────
                foreach ($state['investigations'] as $item) {
                    if (empty($item['name'])) continue;
                    $rec = Investigation::firstOrCreate(
                        ['investigation_name' => $item['name']],
                        ['investigation_assigned_doctor_id' => $doctor->doctors_id, 'investigation_status' => 1]
                    );
                    PrescriptionInvestigation::create([
                        'prescription_id'     => $prescription->prescription_id,
                        'investigation_id'    => $rec->investigation_id,
                        'investigation_value' => $item['result'] ?? null,
                    ]);
                }

                // ── 8. Advices ───────────────────────────────────────────────
                foreach ($state['advices'] as $text) {
                    if (empty($text)) continue;
                    $rec = Advice::firstOrCreate(
                        ['advice_name' => $text],
                        ['advice_assigned_doctor_id' => $doctor->doctors_id, 'advice_status' => 1]
                    );
                    PrescriptionAdvice::create([
                        'prescription_id' => $prescription->prescription_id,
                        'advice_id'       => $rec->advice_id,
                    ]);
                }

                // ── 9. Medicines + Dose Duration ─────────────────────────────
                foreach ($state['medicines'] as $med) {
                    if (empty($med['name'])) continue;
                    $medRec = Medicine::firstOrCreate(
                        ['medicine_name' => $med['name']],
                        ['medicine_status' => 1]
                    );
                    PrescriptionMedicine::create([
                        'prescription_id'        => $prescription->prescription_id,
                        'medicine_id'            => $medRec->medicine_id,
                        'medicine_meal_relation' => $med['timing'] ?? null,
                        'medicine_instructions'  => $med['instruction'] ?? null,
                    ]);
                    PrescriptionMedicineDoseDuration::create([
                        'prescription_id'   => $prescription->prescription_id,
                        'medicine_dose'     => $med['dosage'] ?? null,
                        'medicine_unit_id'  => null,
                        'medicine_duration' => $med['duration'] ?? null,
                    ]);
                }

                return $prescription->prescription_id;
            });

            $this->resetState();

            return redirect()
                ->route('prescriptions.wizard.done', ['id' => $prescriptionId]);

        } catch (\Throwable $e) {
            return back()->withErrors(['save' => $e->getMessage()]);
        }
    }

    // =========================================================================
    // STEP 9 — Done / confirmation + print link
    // =========================================================================
    public function done(int $id)
    {
        $prescription = Prescription::with([
            'patient', 'doctor',
            'complaints.complaint',
            'examinations.examination',
            'diagnoses.diagnosis',
            'investigations.investigation',
            'advices.advice',
            'medicines.medicine',
            'doseDurations',
        ])->findOrFail($id);

        return view('prescriptions.wizard.step9_done', compact('prescription'));
    }

    // =========================================================================
    // Navigation guard — redirect to step 1 if no patient chosen yet
    // =========================================================================
    private function guardPatientSelected(): void
    {
        $state = $this->state();
        if (empty($state['patient']['name'])) {
            abort(redirect()->route('prescriptions.wizard.patient')
                ->withErrors(['patient' => 'Please select or register a patient first.']));
        }
    }
}