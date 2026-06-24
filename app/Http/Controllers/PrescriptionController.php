<?php

// namespace App\Http\Controllers;

// use App\Models\Patient;
// use App\Models\Doctor;
// use App\Models\Prescription;
// use App\Models\PrescriptionLog;
// use App\Models\PrescriptionComplaint;
// use App\Models\PrescriptionExamination;
// use App\Models\PrescriptionDiagnosis;
// use App\Models\PrescriptionInvestigation;
// use App\Models\PrescriptionAdvice;
// use App\Models\PrescriptionMedicine;
// use App\Models\PrescriptionMedicineDoseDuration;
// use App\Models\Complaint;
// use App\Models\Examination;
// use App\Models\Diagnosis;
// use App\Models\Investigation;
// use App\Models\Advice;
// use App\Models\Medicine;
// use App\Models\MedicineUnit;
// use Illuminate\Http\Request;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Validator;

// class PrescriptionController extends Controller
// {
//     // =========================================================================
//     // PRIVATE: Resolve the active doctor
//     // =========================================================================
//     private function resolveDoctor(): ?Doctor
//     {
//         if (Auth::check()) {
//             $doc = Doctor::where('user_id', Auth::id())
//                          ->where('doctors_status', 1)
//                          ->first();
//             if ($doc) return $doc;
//         }
//         return Doctor::where('doctors_status', 1)->first();
//     }

//     // =========================================================================
//     // PRIVATE: Load all dropdown data for the create view
//     // =========================================================================
//     private function viewData(): array
//     {
//         return [
//             'doctor'         => $this->resolveDoctor(),
//             'patients'       => Patient::where('patient_status', 1)->orderBy('patient_name')->get(),
//             'medicines'      => Medicine::where('medicine_status', 1)->orderBy('medicine_name')->get(),
//             'complaints'     => Complaint::where('complaint_status', 1)->orderBy('complaint_name')->get(),
//             'examinations'   => Examination::where('examination_status', 1)->orderBy('examination_name')->get(),
//             'diagnoses'      => Diagnosis::where('diagnosis_status', 1)->orderBy('diagnosis_name')->get(),
//             'investigations' => Investigation::where('investigation_status', 1)->orderBy('investigation_name')->get(),
//             'advices'        => Advice::where('advice_status', 1)->orderBy('advice_name')->get(),
//             'units'          => MedicineUnit::where('unit_status', 1)->get(),
//         ];
//     }

//     // =========================================================================
//     // CREATE (GET) — show the prescription workspace
//     // =========================================================================
//     public function create()
//     {
//         $data = $this->viewData();

//         if (!$data['doctor']) {
//             return response(
//                 '<h2 style="font-family:sans-serif;color:red;padding:40px">
//                     No active doctor found.<br><br>
//                     Run: <code>php artisan tinker</code><br>
//                     Then: <code>\App\Models\Doctor::create([\'doctors_name\'=>\'Dr Name\',\'doctors_status\'=>1,\'doctors_type\'=>\'Permanent\']);</code>
//                  </h2>', 500
//             );
//         }

//         return view('prescriptions.create', $data);
//     }

//     // =========================================================================
//     // SESSION: Set active patient
//     // =========================================================================
//     public function setPatient(Request $request)
//     {
//         $request->validate([
//             'patient_name'   => 'required|string|max:255',
//             'patient_age'    => 'required|numeric|min:0|max:150',
//             'patient_gender' => 'required|string|max:10',
//             'patient_phone'  => 'nullable|string|max:20',
//         ]);

//         session(['rx_patient' => [
//             'name'   => $request->patient_name,
//             'age'    => $request->patient_age,
//             'gender' => $request->patient_gender,
//             'phone'  => $request->patient_phone ?? '',
//         ]]);

//         return redirect()->route('prescriptions.create');
//     }

//     // =========================================================================
//     // SESSION: Add complaint
//     // =========================================================================
//     public function addComplaint(Request $request)
//     {
//         $name = trim($request->custom_complaint_name ?: $request->complaint_name);
//         if (!$name) {
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'Please select or enter a complaint.')
//                 ->with('open_modal', 'modal-complaints');
//         }

//         $list   = session('rx_complaints', []);
//         $list[] = [
//             'name'     => $name,
//             'duration' => $request->complaint_duration ?: '3 days',
//         ];
//         session(['rx_complaints' => $list]);

//         return redirect()->route('prescriptions.create')
//             ->with('open_modal', 'modal-complaints');
//     }

//     // =========================================================================
//     // SESSION: Add examination
//     // =========================================================================
//     public function addExamination(Request $request)
//     {
//         $name = trim($request->custom_examination_name ?: $request->examination_name);
//         if (!$name) {
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'Please select or enter an examination.')
//                 ->with('open_modal', 'modal-examination');
//         }

//         $list   = session('rx_examinations', []);
//         $list[] = [
//             'name'  => $name,
//             'value' => $request->examination_value ?: 'Normal',
//         ];
//         session(['rx_examinations' => $list]);

//         return redirect()->route('prescriptions.create')
//             ->with('open_modal', 'modal-examination');
//     }

//     // =========================================================================
//     // SESSION: Add diagnosis (checkboxes — replaces whole list)
//     // =========================================================================
//     public function addDiagnosis(Request $request)
//     {
//         $selected = $request->input('diagnosis_names', []);
//         if ($request->filled('custom_diagnosis_name')) {
//             $selected[] = trim($request->custom_diagnosis_name);
//         }
//         session(['rx_diagnoses' => array_values(array_unique(array_filter($selected)))]);

//         return redirect()->route('prescriptions.create')
//             ->with('open_modal', 'modal-diagnosis');
//     }

//     // =========================================================================
//     // SESSION: Add investigation
//     // =========================================================================
//     public function addInvestigation(Request $request)
//     {
//         $name = trim($request->custom_investigation_name ?: $request->investigation_name);
//         if (!$name) {
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'Please select or enter an investigation.')
//                 ->with('open_modal', 'modal-investigation');
//         }

//         $list   = session('rx_investigations', []);
//         $list[] = [
//             'name'   => $name,
//             'result' => $request->investigation_result ?: 'Pending',
//         ];
//         session(['rx_investigations' => $list]);

//         return redirect()->route('prescriptions.create')
//             ->with('open_modal', 'modal-investigation');
//     }

//     // =========================================================================
//     // SESSION: Add medicine
//     // =========================================================================
//     public function addMedicine(Request $request)
//     {
//         $name = trim($request->custom_medicine_name ?: $request->medicine_name);
//         if (!$name) {
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'Please select or enter a medicine.')
//                 ->with('open_modal', 'modal-medicine');
//         }

//         $m = $request->has('dose_morning') ? ($request->dose_qty_morning ?: '0') : '0';
//         $d = $request->has('dose_noon')    ? ($request->dose_qty_noon    ?: '0') : '0';
//         $n = $request->has('dose_night')   ? ($request->dose_qty_night   ?: '0') : '0';
//         $e = $request->has('dose_evening') ? ($request->dose_qty_evening ?: '0') : '0';

//         $list   = session('rx_medicines', []);
//         $list[] = [
//             'name'        => $name,
//             'dosage'      => "{$m} + {$d} + {$n} + {$e}",
//             'timing'      => $request->medicine_timing ?? 'খাবারের পরে',
//             'duration'    => $request->medicine_duration ?? 'চলবে',
//             'instruction' => $request->medicine_instruction ?? '',
//         ];
//         session(['rx_medicines' => $list]);

//         return redirect()->route('prescriptions.create')
//             ->with('open_modal', 'modal-medicine');
//     }

//     // =========================================================================
//     // SESSION: Add advice (checkboxes — replaces whole list)
//     // =========================================================================
//     public function addAdvice(Request $request)
//     {
//         $selected = $request->input('advice_names', []);
//         if ($request->filled('custom_advice')) {
//             $selected[] = trim($request->custom_advice);
//         }
//         session(['rx_advices' => array_values(array_unique(array_filter($selected)))]);

//         return redirect()->route('prescriptions.create')
//             ->with('open_modal', 'modal-advice');
//     }

//     // =========================================================================
//     // SESSION: Remove a single item from any list
//     // =========================================================================
//     public function removeItem(Request $request)
//     {
//         $type  = $request->input('type');
//         $name  = $request->input('name');
//         $index = $request->input('index');

//         $allowed = ['complaints','examinations','diagnoses','investigations','medicines','advices'];
//         if (!in_array($type, $allowed)) {
//             return redirect()->route('prescriptions.create');
//         }

//         $key  = 'rx_' . $type;
//         $data = session($key, []);

//         if ($type === 'medicines' && $index !== null) {
//             unset($data[(int)$index]);
//             $data = array_values($data);
//         } elseif (in_array($type, ['diagnoses', 'advices'])) {
//             $data = array_values(array_filter($data, fn($i) => $i !== $name));
//         } else {
//             $data = array_values(array_filter($data, fn($i) => ($i['name'] ?? '') !== $name));
//         }

//         session([$key => $data]);
//         return redirect()->route('prescriptions.create');
//     }

//     // =========================================================================
//     // SESSION: Clear everything and start over
//     // =========================================================================
//     public function clearSession()
//     {
//         session()->forget([
//             'rx_patient', 'rx_complaints', 'rx_examinations',
//             'rx_diagnoses', 'rx_investigations', 'rx_advices', 'rx_medicines',
//         ]);
//         return redirect()->route('prescriptions.create');
//     }

//     // =========================================================================
//     // PRINT PREVIEW (GET)
//     // =========================================================================
//     public function printPreview()
//     {
//         $data = $this->viewData();
//         if (!$data['doctor']) {
//             return redirect()->route('prescriptions.create');
//         }
//         return view('prescriptions.create', array_merge($data, ['printMode' => true]));
//     }

//     // =========================================================================
//     // STORE (POST) — saves session data to all 9 DB tables
//     // =========================================================================
//     public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
//     {
//         // Pull everything from session
//         $rxPatient        = session('rx_patient', []);
//         $rxComplaints     = session('rx_complaints', []);
//         $rxExaminations   = session('rx_examinations', []);
//         $rxDiagnoses      = session('rx_diagnoses', []);
//         $rxInvestigations = session('rx_investigations', []);
//         $rxAdvices        = session('rx_advices', []);
//         $rxMedicines      = session('rx_medicines', []);

//         // Validate patient
//         if (empty($rxPatient['name'])) {
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'Please select a patient before saving.');
//         }
//         if (empty($rxMedicines) && empty($rxComplaints)) {
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'Add at least one complaint or medicine before saving.');
//         }

//         // Resolve doctor before the transaction
//         $doctor = $this->resolveDoctor();
//         if (!$doctor) {
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'No active doctor found. Please seed the doctors table.');
//         }

//         try {
//             $prescription = DB::transaction(function () use (
//                 $rxPatient, $rxComplaints, $rxExaminations, $rxDiagnoses,
//                 $rxInvestigations, $rxAdvices, $rxMedicines, $doctor
//             ) {
//                 // ── 1. Patient ───────────────────────────────────────────────
//                 $patient = Patient::firstOrCreate(
//                     [
//                         'patient_name'         => $rxPatient['name'],
//                         'patient_phone_number' => $rxPatient['phone'] ?: null,
//                     ],
//                     [
//                         'patient_age'    => $rxPatient['age'],
//                         'patient_gender' => $rxPatient['gender'],
//                         'patient_status' => 1,
//                     ]
//                 );

//                 // ── 2. Prescription ──────────────────────────────────────────
//                 $prescription = Prescription::create([
//                     'prescription_for_patient_id'     => $patient->patient_id,
//                     'prescription_assigned_doctor_id' => $doctor->doctors_id,
//                     'prescription_date'               => now()->toDateString(),
//                     'next_meeting_date'               => null,
//                     'prescription_status'             => 1,
//                 ]);

//                 // ── 3. Log ───────────────────────────────────────────────────
//                 $previousId = Prescription::where('prescription_for_patient_id', $patient->patient_id)
//                     ->where('prescription_id', '!=', $prescription->prescription_id)
//                     ->orderByDesc('prescription_id')
//                     ->value('prescription_id');

//                 PrescriptionLog::create([
//                     'prescription_id'          => $prescription->prescription_id,
//                     'doctors_id'               => $doctor->doctors_id,
//                     'patient_id'               => $patient->patient_id,
//                     'prescription_date'        => now()->toDateString(),
//                     'previous_prescription_id' => $previousId,
//                     'prescription_log_status'  => 1,
//                 ]);

//                 // ── 4. Complaints ────────────────────────────────────────────
//                 foreach ($rxComplaints as $item) {
//                     if (empty($item['name'])) continue;
//                     $rec = Complaint::firstOrCreate(
//                         ['complaint_name' => $item['name']],
//                         ['complaint_assigned_doctor_id' => $doctor->doctors_id, 'complaint_status' => 1]
//                     );
//                     PrescriptionComplaint::create([
//                         'prescription_id' => $prescription->prescription_id,
//                         'complaint_id'    => $rec->complaint_id,
//                     ]);
//                 }

//                 // ── 5. Examinations ──────────────────────────────────────────
//                 foreach ($rxExaminations as $item) {
//                     if (empty($item['name'])) continue;
//                     $rec = Examination::firstOrCreate(
//                         ['examination_name' => $item['name']],
//                         ['examination_assigned_doctor_id' => $doctor->doctors_id, 'examination_status' => 1]
//                     );
//                     PrescriptionExamination::create([
//                         'prescription_id'   => $prescription->prescription_id,
//                         'examination_id'    => $rec->examination_id,
//                         'examination_value' => $item['value'] ?? null,
//                     ]);
//                 }

//                 // ── 6. Diagnoses ─────────────────────────────────────────────
//                 foreach ($rxDiagnoses as $name) {
//                     if (empty($name)) continue;
//                     $rec = Diagnosis::firstOrCreate(
//                         ['diagnosis_name' => $name],
//                         ['diagnosis_assigned_doctor_id' => $doctor->doctors_id, 'diagnosis_status' => 1]
//                     );
//                     PrescriptionDiagnosis::create([
//                         'prescription_id' => $prescription->prescription_id,
//                         'diagnosis_id'    => $rec->diagnosis_id,
//                     ]);
//                 }

//                 // ── 7. Investigations ────────────────────────────────────────
//                 foreach ($rxInvestigations as $item) {
//                     if (empty($item['name'])) continue;
//                     $rec = Investigation::firstOrCreate(
//                         ['investigation_name' => $item['name']],
//                         ['investigation_assigned_doctor_id' => $doctor->doctors_id, 'investigation_status' => 1]
//                     );
//                     PrescriptionInvestigation::create([
//                         'prescription_id'     => $prescription->prescription_id,
//                         'investigation_id'    => $rec->investigation_id,
//                         'investigation_value' => $item['result'] ?? null,
//                     ]);
//                 }

//                 // ── 8. Advices ───────────────────────────────────────────────
//                 foreach ($rxAdvices as $text) {
//                     if (empty($text)) continue;
//                     $rec = Advice::firstOrCreate(
//                         ['advice_name' => $text],
//                         ['advice_assigned_doctor_id' => $doctor->doctors_id, 'advice_status' => 1]
//                     );
//                     PrescriptionAdvice::create([
//                         'prescription_id' => $prescription->prescription_id,
//                         'advice_id'       => $rec->advice_id,
//                     ]);
//                 }

//                 // ── 9. Medicines + Dose Duration ─────────────────────────────
//                 foreach ($rxMedicines as $med) {
//                     if (empty($med['name'])) continue;
//                     $medRec = Medicine::firstOrCreate(
//                         ['medicine_name' => $med['name']],
//                         ['medicine_status' => 1]
//                     );
//                     PrescriptionMedicine::create([
//                         'prescription_id'        => $prescription->prescription_id,
//                         'medicine_id'            => $medRec->medicine_id,
//                         'medicine_meal_relation' => $med['timing'] ?? null,
//                         'medicine_instructions'  => $med['instruction'] ?? null,
//                     ]);
//                     PrescriptionMedicineDoseDuration::create([
//                         'prescription_id'   => $prescription->prescription_id,
//                         'medicine_dose'     => $med['dosage'] ?? null,
//                         'medicine_unit_id'  => null,
//                         'medicine_duration' => $med['duration'] ?? null,
//                     ]);
//                 }

//                 return $prescription;
//             });

//             // Clear session after successful save
//             session()->forget([
//                 'rx_patient','rx_complaints','rx_examinations','rx_diagnoses',
//                 'rx_investigations','rx_advices','rx_medicines',
//             ]);

//             Log::info('Prescription saved', ['id' => $prescription->prescription_id]);

//             return redirect()->route('prescriptions.create')
//                 ->with('success', 'Prescription #' . $prescription->prescription_id . ' saved successfully!');

//         } catch (\Throwable $e) {
//             Log::error('Prescription save failed', [
//                 'error' => $e->getMessage(),
//                 'file'  => $e->getFile(),
//                 'line'  => $e->getLine(),
//             ]);
//             return redirect()->route('prescriptions.create')
//                 ->with('error', 'Save failed: ' . $e->getMessage());
//         }
//     }

//     // =========================================================================
//     // SHOW
//     // =========================================================================
//     public function show(string $id)
//     {
//         $prescription = Prescription::with([
//             'patient', 'doctor',
//             'complaints.complaint',
//             'examinations.examination',
//             'diagnoses.diagnosis',
//             'investigations.investigation',
//             'advices.advice',
//             'medicines.medicine',
//             'doseDurations',
//         ])->findOrFail($id);

//         return view('prescriptions.show', compact('prescription'));
//     }

//     // =========================================================================
//     // INDEX
//     // =========================================================================
//     public function index()
//     {
//         $prescriptions = Prescription::with(['patient', 'doctor'])
//             ->orderByDesc('prescription_date')
//             ->paginate(25);

//         return view('prescriptions.index', compact('prescriptions'));
//     }

//     // =========================================================================
//     // DEBUG — GET /prescriptions/debug-test  (REMOVE IN PRODUCTION)
//     // =========================================================================
//     public function debugTest(): JsonResponse
//     {
//         $results = [];

//         $tables = [
//             'patients','doctors','prescriptions','prescription_logs',
//             'complaints','prescription_complaints',
//             'examinations','prescription_examinations',
//             'diagnoses','prescription_diagnoses',
//             'investigations','prescription_investigations',
//             'advices','prescription_advices',
//             'medicines','prescription_medicines',
//             'prescription_medicine_dose_durations',
//         ];

//         foreach ($tables as $table) {
//             try {
//                 $count = DB::table($table)->count();
//                 $results['tables'][$table] = "✅ exists ({$count} rows)";
//             } catch (\Exception $e) {
//                 $results['tables'][$table] = "❌ MISSING: " . $e->getMessage();
//             }
//         }

//         $doctor = $this->resolveDoctor();
//         $results['doctor'] = $doctor
//             ? "✅ {$doctor->doctors_name} (ID: {$doctor->doctors_id})"
//             : "❌ No active doctor — run: Doctor::create(['doctors_name'=>'Dr Name','doctors_status'=>1,'doctors_type'=>'Permanent'])";

//         try {
//             DB::connection()->getPdo();
//             $results['db'] = '✅ Connected to: ' . DB::connection()->getDatabaseName();
//         } catch (\Exception $e) {
//             $results['db'] = '❌ ' . $e->getMessage();
//         }

//         $results['session'] = session()->all();

//         return response()->json($results, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//     }
// }







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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{
    // =========================================================================
    // PRIVATE: Resolve the active doctor
    // =========================================================================
    private function resolveDoctor(): ?Doctor
    {
        if (Auth::check()) {
            $doc = Doctor::where('user_id', Auth::id())
                         ->where('doctors_status', 1)
                         ->first();
            if ($doc) return $doc;
        }
        return Doctor::where('doctors_status', 1)->first();
    }

    // =========================================================================
    // PRIVATE: Load all dropdown data for the create view
    // =========================================================================
    private function viewData(): array
    {
        return [
            'doctor'         => $this->resolveDoctor(),
            'patients'       => Patient::where('patient_status', 1)->orderBy('patient_name')->get(),
            'medicines'      => Medicine::where('medicine_status', 1)->orderBy('medicine_name')->get(),
            'complaints'     => Complaint::where('complaint_status', 1)->orderBy('complaint_name')->get(),
            'examinations'   => Examination::where('examination_status', 1)->orderBy('examination_name')->get(),
            'diagnoses'      => Diagnosis::where('diagnosis_status', 1)->orderBy('diagnosis_name')->get(),
            'investigations' => Investigation::where('investigation_status', 1)->orderBy('investigation_name')->get(),
            'advices'        => Advice::where('advice_status', 1)->orderBy('advice_name')->get(),
            'units'          => MedicineUnit::where('unit_status', 1)->get(),
        ];
    }

    // =========================================================================
    // CREATE (GET) — show the prescription workspace
    // =========================================================================
    public function create()
    {
        $data = $this->viewData();

        if (!$data['doctor']) {
            return response(
                '<h2 style="font-family:sans-serif;color:red;padding:40px">
                    No active doctor found.<br><br>
                    Run: <code>php artisan tinker</code><br>
                    Then: <code>\App\Models\Doctor::create([\'doctors_name\'=>\'Dr Name\',\'doctors_status\'=>1,\'doctors_type\'=>\'Permanent\']);</code>
                 </h2>', 500
            );
        }

        return view('prescriptions.create', $data);
    }

    // =========================================================================
    // SESSION: Set active patient
    // =========================================================================
    public function setPatient(Request $request)
    {
        $request->validate([
            'patient_name'   => 'required|string|max:255',
            'patient_age'    => 'required|numeric|min:0|max:150',
            'patient_gender' => 'required|string|max:10',
            'patient_phone'  => 'nullable|string|max:20',
        ]);

        session(['rx_patient' => [
            'name'   => $request->patient_name,
            'age'    => $request->patient_age,
            'gender' => $request->patient_gender,
            'phone'  => $request->patient_phone ?? '',
        ]]);

        return redirect()->route('prescriptions.create');
    }

    // =========================================================================
    // SESSION: Add complaint
    // =========================================================================
    public function addComplaint(Request $request)
    {
        $name = trim($request->custom_complaint_name ?: $request->complaint_name);
        if (!$name) {
            return redirect()->route('prescriptions.create')
                ->with('error', 'Please select or enter a complaint.')
                ->with('open_modal', 'modal-complaints');
        }

        $list   = session('rx_complaints', []);
        $list[] = [
            'name'     => $name,
            'duration' => $request->complaint_duration ?: '3 days',
        ];
        session(['rx_complaints' => $list]);

        return redirect()->route('prescriptions.create')
            ->with('open_modal', 'modal-complaints');
    }

    // =========================================================================
    // SESSION: Add examination
    // =========================================================================
    public function addExamination(Request $request)
    {
        $name = trim($request->custom_examination_name ?: $request->examination_name);
        if (!$name) {
            return redirect()->route('prescriptions.create')
                ->with('error', 'Please select or enter an examination.')
                ->with('open_modal', 'modal-examination');
        }

        $list   = session('rx_examinations', []);
        $list[] = [
            'name'  => $name,
            'value' => $request->examination_value ?: 'Normal',
        ];
        session(['rx_examinations' => $list]);

        return redirect()->route('prescriptions.create')
            ->with('open_modal', 'modal-examination');
    }

    // =========================================================================
    // SESSION: Add diagnosis (checkboxes — replaces whole list)
    // =========================================================================
    public function addDiagnosis(Request $request)
    {
        $selected = $request->input('diagnosis_names', []);
        if ($request->filled('custom_diagnosis_name')) {
            $selected[] = trim($request->custom_diagnosis_name);
        }
        session(['rx_diagnoses' => array_values(array_unique(array_filter($selected)))]);

        return redirect()->route('prescriptions.create')
            ->with('open_modal', 'modal-diagnosis');
    }

    // =========================================================================
    // SESSION: Add investigation
    // =========================================================================
    public function addInvestigation(Request $request)
    {
        $name = trim($request->custom_investigation_name ?: $request->investigation_name);
        if (!$name) {
            return redirect()->route('prescriptions.create')
                ->with('error', 'Please select or enter an investigation.')
                ->with('open_modal', 'modal-investigation');
        }

        $list   = session('rx_investigations', []);
        $list[] = [
            'name'   => $name,
            'result' => $request->investigation_result ?: 'Pending',
        ];
        session(['rx_investigations' => $list]);

        return redirect()->route('prescriptions.create')
            ->with('open_modal', 'modal-investigation');
    }

    // =========================================================================
    // SESSION: Add medicine
    // =========================================================================
    public function addMedicine(Request $request)
    {
        $name = trim($request->custom_medicine_name ?: $request->medicine_name);
        if (!$name) {
            return redirect()->route('prescriptions.create')
                ->with('error', 'Please select or enter a medicine.')
                ->with('open_modal', 'modal-medicine');
        }

        $m = $request->has('dose_morning') ? ($request->dose_qty_morning ?: '0') : '0';
        $d = $request->has('dose_noon')    ? ($request->dose_qty_noon    ?: '0') : '0';
        $n = $request->has('dose_night')   ? ($request->dose_qty_night   ?: '0') : '0';
        $e = $request->has('dose_evening') ? ($request->dose_qty_evening ?: '0') : '0';

        $list   = session('rx_medicines', []);
        $list[] = [
            'name'        => $name,
            'dosage'      => "{$m} + {$d} + {$n} + {$e}",
            'timing'      => $request->medicine_timing ?? 'খাবারের পরে',
            'duration'    => $request->medicine_duration ?? 'চলবে',
            'instruction' => $request->medicine_instruction ?? '',
        ];
        session(['rx_medicines' => $list]);

        return redirect()->route('prescriptions.create')
            ->with('open_modal', 'modal-medicine');
    }

    // =========================================================================
    // SESSION: Add advice (checkboxes — replaces whole list)
    // =========================================================================
    public function addAdvice(Request $request)
    {
        $selected = $request->input('advice_names', []);
        if ($request->filled('custom_advice')) {
            $selected[] = trim($request->custom_advice);
        }
        session(['rx_advices' => array_values(array_unique(array_filter($selected)))]);

        return redirect()->route('prescriptions.create')
            ->with('open_modal', 'modal-advice');
    }

    // =========================================================================
    // SESSION: Remove a single item from any list
    // =========================================================================
    public function removeItem(Request $request)
    {
        $type  = $request->input('type');
        $name  = $request->input('name');
        $index = $request->input('index');

        $allowed = ['complaints','examinations','diagnoses','investigations','medicines','advices'];
        if (!in_array($type, $allowed)) {
            return redirect()->route('prescriptions.create');
        }

        $key  = 'rx_' . $type;
        $data = session($key, []);

        if ($type === 'medicines' && $index !== null) {
            unset($data[(int)$index]);
            $data = array_values($data);
        } elseif (in_array($type, ['diagnoses', 'advices'])) {
            $data = array_values(array_filter($data, fn($i) => $i !== $name));
        } else {
            $data = array_values(array_filter($data, fn($i) => ($i['name'] ?? '') !== $name));
        }

        session([$key => $data]);
        return redirect()->route('prescriptions.create');
    }

    // =========================================================================
    // SESSION: Clear everything and start over
    // =========================================================================
    public function clearSession()
    {
        session()->forget([
            'rx_patient', 'rx_complaints', 'rx_examinations',
            'rx_diagnoses', 'rx_investigations', 'rx_advices', 'rx_medicines',
        ]);
        return redirect()->route('prescriptions.create');
    }

    // =========================================================================
    // PRINT PREVIEW (GET)
    // =========================================================================
    public function printPreview()
    {
        $data = $this->viewData();
        if (!$data['doctor']) {
            return redirect()->route('prescriptions.create');
        }
        return view('prescriptions.create', array_merge($data, ['printMode' => true]));
    }

    // =========================================================================
    // STORE (POST) — saves session data to all 9 DB tables
    // =========================================================================
    public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        // Pull everything from session
        $rxPatient        = session('rx_patient', []);
        $rxComplaints     = session('rx_complaints', []);
        $rxExaminations   = session('rx_examinations', []);
        $rxDiagnoses      = session('rx_diagnoses', []);
        $rxInvestigations = session('rx_investigations', []);
        $rxAdvices        = session('rx_advices', []);
        $rxMedicines      = session('rx_medicines', []);

        // Validate patient
        if (empty($rxPatient['name'])) {
            return redirect()->route('prescriptions.create')
                ->with('error', 'Please select a patient before saving.');
        }
        if (empty($rxMedicines) && empty($rxComplaints)) {
            return redirect()->route('prescriptions.create')
                ->with('error', 'Add at least one complaint or medicine before saving.');
        }

        // Resolve doctor before the transaction
        $doctor = $this->resolveDoctor();
        if (!$doctor) {
            return redirect()->route('prescriptions.create')
                ->with('error', 'No active doctor found. Please seed the doctors table.');
        }

        try {
            $prescription = DB::transaction(function () use (
                $rxPatient, $rxComplaints, $rxExaminations, $rxDiagnoses,
                $rxInvestigations, $rxAdvices, $rxMedicines, $doctor
            ) {
                // ── 1. Patient ───────────────────────────────────────────────
                $patient = Patient::firstOrCreate(
                    [
                        'patient_name'         => $rxPatient['name'],
                        'patient_phone_number' => $rxPatient['phone'] ?: null,
                    ],
                    [
                        'patient_age'    => $rxPatient['age'],
                        'patient_gender' => $rxPatient['gender'],
                        'patient_status' => 1,
                    ]
                );

                // ── 2. Prescription ──────────────────────────────────────────
                $prescription = Prescription::create([
                    'prescription_for_patient_id'     => $patient->patient_id,
                    'prescription_assigned_doctor_id' => $doctor->doctors_id,
                    'prescription_date'               => now()->toDateString(),
                    'next_meeting_date'               => null,
                    'prescription_status'             => 1,
                ]);

                // ── 3. Log ───────────────────────────────────────────────────
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
                foreach ($rxComplaints as $item) {
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
                foreach ($rxExaminations as $item) {
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
                foreach ($rxDiagnoses as $name) {
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
                foreach ($rxInvestigations as $item) {
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
                foreach ($rxAdvices as $text) {
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
                foreach ($rxMedicines as $med) {
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

                return $prescription;
            });

            // Clear session after successful save
            session()->forget([
                'rx_patient','rx_complaints','rx_examinations','rx_diagnoses',
                'rx_investigations','rx_advices','rx_medicines',
            ]);

            Log::info('Prescription saved', ['id' => $prescription->prescription_id]);

            return redirect()->route('prescriptions.create')
                ->with('success', 'Prescription #' . $prescription->prescription_id . ' saved successfully!');

        } catch (\Throwable $e) {
            Log::error('Prescription save failed', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);
            return redirect()->route('prescriptions.create')
                ->with('error', 'Save failed: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // SHOW
    // =========================================================================
    public function show(string $id)
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

        return view('prescriptions.show', compact('prescription'));
    }

    // =========================================================================
    // INDEX
    // =========================================================================
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'doctor'])
            ->orderByDesc('prescription_id')
            ->paginate(25);

        return view('prescriptions.index', compact('prescriptions'));
    }

    // =========================================================================
    // DEBUG — GET /prescriptions/debug-test  (REMOVE IN PRODUCTION)
    // =========================================================================
    public function debugTest(): JsonResponse
    {
        $results = [];

        $tables = [
            'patients','doctors','prescriptions','prescription_logs',
            'complaints','prescription_complaints',
            'examinations','prescription_examinations',
            'diagnoses','prescription_diagnoses',
            'investigations','prescription_investigations',
            'advices','prescription_advices',
            'medicines','prescription_medicines',
            'prescription_medicine_dose_durations',
        ];

        foreach ($tables as $table) {
            try {
                $count = DB::table($table)->count();
                $results['tables'][$table] = "✅ exists ({$count} rows)";
            } catch (\Exception $e) {
                $results['tables'][$table] = "❌ MISSING: " . $e->getMessage();
            }
        }

        $doctor = $this->resolveDoctor();
        $results['doctor'] = $doctor
            ? "✅ {$doctor->doctors_name} (ID: {$doctor->doctors_id})"
            : "❌ No active doctor — run: Doctor::create(['doctors_name'=>'Dr Name','doctors_status'=>1,'doctors_type'=>'Permanent'])";

        try {
            DB::connection()->getPdo();
            $results['db'] = '✅ Connected to: ' . DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
            $results['db'] = '❌ ' . $e->getMessage();
        }

        $results['session'] = session()->all();

        return response()->json($results, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}