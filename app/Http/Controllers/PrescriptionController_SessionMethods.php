<?php
// ================================================================
// ADD THESE METHODS to your existing PrescriptionController.php
// These replace all the JS state management with server-side session
// ================================================================

// ── Set Patient ──────────────────────────────────────────────────
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

// ── Add Complaint ────────────────────────────────────────────────
public function addComplaint(Request $request)
{
    // Use radio selection or custom input — whichever is filled
    $name = $request->custom_complaint_name ?: $request->complaint_name;
    if (!$name) return redirect()->route('prescriptions.create')->with('error', 'Please select or type a complaint.');

    $complaints   = session('rx_complaints', []);
    $complaints[] = [
        'name'     => trim($name),
        'duration' => $request->complaint_duration ?: '3 days',
    ];
    session(['rx_complaints' => $complaints]);

    return redirect()->route('prescriptions.create')->with('open_modal', 'modal-complaints');
}

// ── Add Examination ───────────────────────────────────────────────
public function addExamination(Request $request)
{
    $name = $request->custom_examination_name ?: $request->examination_name;
    if (!$name) return redirect()->route('prescriptions.create')->with('error', 'Please select or type an examination.');

    $examinations   = session('rx_examinations', []);
    $examinations[] = [
        'name'  => trim($name),
        'value' => $request->examination_value ?: 'Normal',
    ];
    session(['rx_examinations' => $examinations]);

    return redirect()->route('prescriptions.create')->with('open_modal', 'modal-examination');
}

// ── Add Diagnosis ─────────────────────────────────────────────────
public function addDiagnosis(Request $request)
{
    // Checkboxes send an array; may also have a custom one
    $selected = $request->input('diagnosis_names', []);
    if ($request->filled('custom_diagnosis_name')) {
        $selected[] = trim($request->custom_diagnosis_name);
    }
    // Replace entire list (checkboxes re-send all checked items)
    session(['rx_diagnoses' => array_values(array_unique(array_filter($selected)))]);

    return redirect()->route('prescriptions.create')->with('open_modal', 'modal-diagnosis');
}

// ── Add Investigation ─────────────────────────────────────────────
public function addInvestigation(Request $request)
{
    $name = $request->custom_investigation_name ?: $request->investigation_name;
    if (!$name) return redirect()->route('prescriptions.create')->with('error', 'Please select or type an investigation.');

    $investigations   = session('rx_investigations', []);
    $investigations[] = [
        'name'   => trim($name),
        'result' => $request->investigation_result ?: 'Pending',
    ];
    session(['rx_investigations' => $investigations]);

    return redirect()->route('prescriptions.create')->with('open_modal', 'modal-investigation');
}

// ── Add Medicine ──────────────────────────────────────────────────
public function addMedicine(Request $request)
{
    $name = $request->custom_medicine_name ?: $request->medicine_name;
    if (!$name) return redirect()->route('prescriptions.create')->with('error', 'Please select or type a medicine.');

    // Build the dosage string from checkboxes + qty inputs
    $m = $request->has('dose_morning') ? ($request->dose_qty_morning ?: '0') : '0';
    $d = $request->has('dose_noon')    ? ($request->dose_qty_noon    ?: '0') : '0';
    $n = $request->has('dose_night')   ? ($request->dose_qty_night   ?: '0') : '0';
    $e = $request->has('dose_evening') ? ($request->dose_qty_evening ?: '0') : '0';

    $medicines   = session('rx_medicines', []);
    $medicines[] = [
        'name'        => trim($name),
        'dosage'      => "{$m} + {$d} + {$n} + {$e}",
        'timing'      => $request->medicine_timing ?? 'খাবারের পরে',
        'duration'    => $request->medicine_duration ?? 'চলবে',
        'instruction' => $request->medicine_instruction ?? '',
    ];
    session(['rx_medicines' => $medicines]);

    return redirect()->route('prescriptions.create')->with('open_modal', 'modal-medicine');
}

// ── Add Advice ────────────────────────────────────────────────────
public function addAdvice(Request $request)
{
    $selected = $request->input('advice_names', []);
    if ($request->filled('custom_advice')) {
        $selected[] = trim($request->custom_advice);
    }
    // Replace entire list
    session(['rx_advices' => array_values(array_unique(array_filter($selected)))]);

    return redirect()->route('prescriptions.create')->with('open_modal', 'modal-advice');
}

// ── Remove Individual Item ────────────────────────────────────────
public function removeItem(Request $request)
{
    $type  = $request->input('type');   // complaints|examinations|diagnoses|investigations|medicines|advices
    $name  = $request->input('name');   // used for all except medicines
    $index = $request->input('index');  // used for medicines

    $allowed = ['complaints','examinations','diagnoses','investigations','medicines','advices'];
    if (!in_array($type, $allowed)) return redirect()->route('prescriptions.create');

    $key  = 'rx_' . $type;
    $data = session($key, []);

    if ($type === 'medicines' && $index !== null) {
        // Remove by array index
        unset($data[(int)$index]);
        $data = array_values($data);
    } elseif ($type === 'diagnoses' || $type === 'advices') {
        // Simple string arrays
        $data = array_values(array_filter($data, fn($i) => $i !== $name));
    } else {
        // Arrays of {name, ...} objects
        $data = array_values(array_filter($data, fn($i) => ($i['name'] ?? '') !== $name));
    }

    session([$key => $data]);
    return redirect()->route('prescriptions.create');
}

// ── Clear Session ─────────────────────────────────────────────────
public function clearSession()
{
    session()->forget(['rx_patient','rx_complaints','rx_examinations','rx_diagnoses','rx_investigations','rx_advices','rx_medicines']);
    return redirect()->route('prescriptions.create');
}

// ── Print Preview ─────────────────────────────────────────────────
public function printPreview()
{
    // Reuses the create view — renders the print section when ?print=1
    $doctor         = $this->resolveDoctor();
    $patients       = \App\Models\Patient::where('patient_status', 1)->orderBy('patient_name')->get();
    $medicines      = \App\Models\Medicine::where('medicine_status', 1)->orderBy('medicine_name')->get();
    $complaints     = \App\Models\Complaint::where('complaint_status', 1)->orderBy('complaint_name')->get();
    $examinations   = \App\Models\Examination::where('examination_status', 1)->orderBy('examination_name')->get();
    $diagnoses      = \App\Models\Diagnosis::where('diagnosis_status', 1)->orderBy('diagnosis_name')->get();
    $investigations = \App\Models\Investigation::where('investigation_status', 1)->orderBy('investigation_name')->get();
    $advices        = \App\Models\Advice::where('advice_status', 1)->orderBy('advice_name')->get();
    $units          = \App\Models\MedicineUnit::where('unit_status', 1)->get();

    return view('prescriptions.create', compact(
        'doctor','patients','medicines','complaints',
        'examinations','diagnoses','investigations','advices','units'
    ))->with('print', 1);
    // NOTE: The blade checks request('print') OR you can use a dedicated print.blade.php view
}

// ── Store (modified to read from session when source=session) ─────
// UPDATE your existing store() method's top section:
//
// if ($request->input('source') === 'session') {
//     // Pull data from session instead of JSON body
//     $rxPatient        = session('rx_patient', []);
//     $rxComplaints     = session('rx_complaints', []);
//     $rxExaminations   = session('rx_examinations', []);
//     $rxDiagnoses      = session('rx_diagnoses', []);
//     $rxInvestigations = session('rx_investigations', []);
//     $rxAdvices        = session('rx_advices', []);
//     $rxMedicines      = session('rx_medicines', []);
//
//     // Merge into request for the existing validation + save logic
//     $request->merge([
//         'patient'        => $rxPatient,
//         'complaints'     => $rxComplaints,
//         'examinations'   => $rxExaminations,
//         'diagnoses'      => $rxDiagnoses,
//         'investigations' => $rxInvestigations,
//         'advices'        => $rxAdvices,
//         'medicines'      => $rxMedicines,
//     ]);
// }