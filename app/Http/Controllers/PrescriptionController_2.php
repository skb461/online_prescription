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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    // =========================================================================
    // DOCTOR RESOLVER
    // FIX: never use abort() inside a method called from within a DB transaction.
    // abort() throws HttpException which bypasses the catch(\Throwable) block
    // and Laravel renders an HTML error page instead of returning JSON.
    // Now returns null and the caller decides what to do.
    // =========================================================================
    private function resolveDoctor(): ?Doctor
    {
        // Try by logged-in user_id (only works if doctors table has user_id column)
        if (Auth::check()) {
            $doc = Doctor::where('user_id', Auth::id())
                         ->where('doctors_status', 1)
                         ->first();
            if ($doc) return $doc;
        }

        // Fallback: first active doctor in the system
        return Doctor::where('doctors_status', 1)->first();
    }

    // =========================================================================
    // CREATE (GET) — load the prescription workspace
    // =========================================================================
    public function create()
    {
        $doctor = $this->resolveDoctor();

        // If no doctor exists yet, show a clear message instead of crashing
        if (!$doctor) {
            return response(
                '<h1 style="font-family:sans-serif;color:red;padding:40px">
                    No active doctor found in the database.<br><br>
                    Run this in your terminal:<br><br>
                    <code style="background:#eee;padding:10px;display:block">
                        php artisan tinker<br>
                        \App\Models\Doctor::create([\'doctors_name\' => \'Dr. Your Name\', \'doctors_status\' => 1, \'doctors_type\' => \'Permanent\']);
                    </code>
                 </h1>',
                500
            );
        }

        $patients       = Patient::where('patient_status', 1)->orderBy('patient_name')->get();
        $medicines      = Medicine::where('medicine_status', 1)->orderBy('medicine_name')->get();
        $complaints     = Complaint::where('complaint_status', 1)->orderBy('complaint_name')->get();
        $examinations   = Examination::where('examination_status', 1)->orderBy('examination_name')->get();
        $diagnoses      = Diagnosis::where('diagnosis_status', 1)->orderBy('diagnosis_name')->get();
        $investigations = Investigation::where('investigation_status', 1)->orderBy('investigation_name')->get();
        $advices        = Advice::where('advice_status', 1)->orderBy('advice_name')->get();
        $units          = MedicineUnit::where('unit_status', 1)->get();

        return view('prescriptions.create', compact(
            'doctor', 'patients', 'medicines', 'complaints',
            'examinations', 'diagnoses', 'investigations', 'advices', 'units'
        ));
    }

    // =========================================================================
    // STORE (POST) — save prescription to all 9 tables
    // =========================================================================
    public function store(Request $request): JsonResponse
    {
        // ── Step 1: Validate ─────────────────────────────────────────────────
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'patient'                     => 'required|array',
            'patient.name'                => 'required|string|max:255',
            'patient.age'                 => 'required|numeric|min:0|max:150',
            'patient.gender'              => 'required|string|max:10',
            'patient.phone'               => 'nullable|string|max:20',

            'complaints'                  => 'nullable|array',
            'complaints.*.name'           => 'required|string|max:255',
            'complaints.*.duration'       => 'nullable|string|max:100',

            'examinations'                => 'nullable|array',
            'examinations.*.name'         => 'required|string|max:255',
            'examinations.*.value'        => 'nullable|string|max:255',

            'diagnoses'                   => 'nullable|array',
            'diagnoses.*'                 => 'nullable|string|max:255',

            'investigations'              => 'nullable|array',
            'investigations.*.name'       => 'required|string|max:255',
            'investigations.*.result'     => 'nullable|string|max:255',

            'advices'                     => 'nullable|array',
            'advices.*'                   => 'nullable|string|max:255',

            'medicines'                   => 'nullable|array',
            'medicines.*.name'            => 'required|string|max:255',
            'medicines.*.dosage'          => 'required|string|max:50',
            'medicines.*.timing'          => 'required|string|max:100',
            'medicines.*.duration'        => 'required|string|max:100',
            'medicines.*.instruction'     => 'nullable|string|max:255',

            'next_meeting_date'           => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()->toArray(),
            ], 422);
        }

        // ── Step 2: Resolve doctor BEFORE the transaction ────────────────────
        // CRITICAL FIX: Never call resolveDoctor() inside the transaction closure.
        // If it fails, we return JSON cleanly here — not an HTML crash page.
        $doctor = $this->resolveDoctor();
        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'No active doctor found. Please add a doctor to the database first. Run: php artisan tinker → Doctor::create([\'doctors_name\'=>\'Dr Name\',\'doctors_status\'=>1,\'doctors_type\'=>\'Permanent\'])',
            ], 500);
        }

        // ── Step 3: Run everything inside one transaction ────────────────────
        // try {
            $prescription = DB::transaction(function () use ($request, $doctor) {

                $ptData = $request->input('patient');

                // ── 1. Patient ───────────────────────────────────────────────
                $patient = Patient::firstOrCreate(
                    [
                        'patient_name'         => $ptData['name'],
                        'patient_phone_number' => $ptData['phone'] ?? null,
                    ],
                    [
                        'patient_age'    => $ptData['age'],
                        'patient_gender' => $ptData['gender'],
                        'patient_status' => 1,
                    ]
                );

                // ── 2. Prescription ──────────────────────────────────────────
                $prescription = Prescription::create([
                    'prescription_for_patient_id'     => $patient->patient_id,
                    'prescription_assigned_doctor_id' => $doctor->doctors_id,
                    'prescription_date'               => now()->toDateString(),
                    'next_meeting_date'               => $request->input('next_meeting_date') ?: null,
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
                foreach ($request->input('complaints', []) as $item) {
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
                foreach ($request->input('examinations', []) as $item) {
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
                foreach ($request->input('diagnoses', []) as $name) {
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
                foreach ($request->input('investigations', []) as $item) {
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
                foreach ($request->input('advices', []) as $text) {
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
                foreach ($request->input('medicines', []) as $med) {
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

            Log::info('Prescription saved', ['id' => $prescription->prescription_id]);

            return response()->json([
                'success' => true,
                'message' => 'Prescription saved successfully.',
                'id'      => $prescription->prescription_id,
            ], 201);

        // } catch (\Throwable $e) {
        //     Log::error('Prescription save failed', [
        //         'error' => $e->getMessage(),
        //         'file'  => $e->getFile(),
        //         'line'  => $e->getLine(),
        //     ]);

        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage(),
        //         'file'    => basename($e->getFile()),
        //         'line'    => $e->getLine(),
        //         'trace'   => config('app.debug') ? collect(explode("\n", $e->getTraceAsString()))->take(10)->implode("\n") : null,
        //     ], 500);
        // }
    }

    // =========================================================================
    // DEBUG ENDPOINT — GET /prescriptions/debug-test
    // Checks every table exists and doctor is present.
    // REMOVE THIS IN PRODUCTION.
    // =========================================================================
    public function debugTest(): JsonResponse
    {
        $results = [];

        $tables = [
            'patients', 'doctors', 'prescriptions', 'prescription_logs',
            'complaints', 'prescription_complaints',
            'examinations', 'prescription_examinations',
            'diagnoses', 'prescription_diagnoses',
            'investigations', 'prescription_investigations',
            'advices', 'prescription_advices',
            'medicines', 'prescription_medicines',
            'prescription_medicine_dose_durations',
        ];

        foreach ($tables as $table) {
            try {
                $count = DB::table($table)->count();
                $results['tables'][$table] = "✅ exists ({$count} rows)";
            } catch (\Exception $e) {
                $results['tables'][$table] = "❌ ERROR: " . $e->getMessage();
            }
        }

        // Check doctor
        $doctor = $this->resolveDoctor();
        $results['doctor'] = $doctor
            ? "✅ Found: {$doctor->doctors_name} (ID: {$doctor->doctors_id})"
            : "❌ NO ACTIVE DOCTOR FOUND — run: Doctor::create(['doctors_name'=>'Dr Name','doctors_status'=>1,'doctors_type'=>'Permanent'])";

        // Check DB connection
        try {
            DB::connection()->getPdo();
            $results['db_connection'] = '✅ Connected to: ' . DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
            $results['db_connection'] = '❌ ' . $e->getMessage();
        }

        // Check auth
        $results['auth'] = Auth::check()
            ? '✅ Logged in as user ID: ' . Auth::id()
            : '⚠️  Not logged in (will use fallback doctor)';

        return response()->json($results, 200, [], JSON_PRETTY_PRINT);
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
            ->orderByDesc('prescription_date')
            ->paginate(25);

        return view('prescriptions.index', compact('prescriptions'));
    }
}