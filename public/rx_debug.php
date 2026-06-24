<?php
/**
 * ================================================================
 * PLACE THIS FILE AT:  public/rx_debug.php
 * VISIT:               http://127.0.0.1:8000/rx_debug.php
 * DELETE AFTER FIXING.
 * ================================================================
 */
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header('Content-Type: text/html; charset=utf-8');

$action = $_GET['action'] ?? 'report';

// ── Helper ────────────────────────────────────────────────────────
function row($label, $value, $ok = null) {
    $color = $ok === true ? '#16a34a' : ($ok === false ? '#dc2626' : '#1e40af');
    echo "<tr><td style='padding:8px 12px;font-weight:bold;color:#374151;border-bottom:1px solid #e5e7eb'>{$label}</td>"
       . "<td style='padding:8px 12px;color:{$color};border-bottom:1px solid #e5e7eb'>" . nl2br(htmlspecialchars((string)$value)) . "</td></tr>";
}

echo '<!DOCTYPE html><html><head><meta charset="UTF-8">
<title>RxMaster Debug</title>
<style>body{font-family:system-ui,sans-serif;background:#f8fafc;padding:40px;color:#1e293b}
h2{color:#4f46e5;margin-top:32px;border-bottom:2px solid #e0e7ff;padding-bottom:8px}
table{width:100%;background:#fff;border-radius:12px;box-shadow:0 1px 8px rgba(0,0,0,.07);border-collapse:collapse;margin-bottom:24px}
a.btn{display:inline-block;background:#4f46e5;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:bold;margin:4px}
a.btn.red{background:#dc2626} a.btn.green{background:#16a34a}
.warn{background:#fef9c3;border:1px solid #fde68a;padding:12px 16px;border-radius:8px;color:#92400e;font-weight:bold;margin:16px 0}
</style></head><body>
<h1 style="color:#1e293b">🩺 RxMaster — Live Debug Panel</h1>
<p style="color:#64748b">Actions:
  <a class="btn" href="?action=report">📊 Full Report</a>
  <a class="btn green" href="?action=test_insert">🧪 Test Insert (dry-run)</a>
  <a class="btn red" href="?action=clear_session">🗑 Clear Session</a>
  <a class="btn" href="?action=seed_doctor">👨‍⚕️ Seed Doctor</a>
  <a class="btn" href="?action=seed_data">📦 Seed Sample Data</a>
</p>';

// ── CLEAR SESSION ─────────────────────────────────────────────────
if ($action === 'clear_session') {
    $keys = ['rx_patient','rx_complaints','rx_examinations','rx_diagnoses','rx_investigations','rx_advices','rx_medicines'];
    foreach ($keys as $k) session()->forget($k);
    echo '<div class="warn">✅ Session cleared. <a href="?action=report">Back to report</a></div>';
}

// ── SEED DOCTOR ───────────────────────────────────────────────────
if ($action === 'seed_doctor') {
    try {
        $doc = \App\Models\Doctor::firstOrCreate(
            ['doctors_name' => 'Dr. Debug Doctor'],
            ['doctors_status' => 1, 'doctors_type' => 'Permanent', 'doctors_designations' => 'MBBS', 'doctors_speciality' => 'General Medicine']
        );
        echo '<div class="warn">✅ Doctor ready: ' . $doc->doctors_name . ' (ID: ' . $doc->doctors_id . '). <a href="?action=report">Back</a></div>';
    } catch (\Exception $e) {
        echo '<div class="warn" style="background:#fee2e2">❌ ' . $e->getMessage() . '</div>';
    }
}

// ── SEED SAMPLE DATA ──────────────────────────────────────────────
if ($action === 'seed_data') {
    try {
        $complaints = ['Fever','Cough','Headache','Body Pain','Vomiting','Diarrhoea'];
        foreach ($complaints as $c) \App\Models\Complaint::firstOrCreate(['complaint_name'=>$c],['complaint_status'=>1]);

        $exams = ['Blood Pressure','Pulse','Temperature','Weight','Oxygen Level'];
        foreach ($exams as $e) \App\Models\Examination::firstOrCreate(['examination_name'=>$e],['examination_status'=>1]);

        $diags = ['Viral Fever','Common Cold','Gastritis','Hypertension','Diabetes','Gout'];
        foreach ($diags as $d) \App\Models\Diagnosis::firstOrCreate(['diagnosis_name'=>$d],['diagnosis_status'=>1]);

        $invs = ['CBC','Blood Sugar','Urine R/E','Serum Creatinine','Lipid Profile'];
        foreach ($invs as $i) \App\Models\Investigation::firstOrCreate(['investigation_name'=>$i],['investigation_status'=>1]);

        $advs = ['Take rest','Drink plenty of water','Avoid oily food','Light diet','Follow up after 7 days'];
        foreach ($advs as $a) \App\Models\Advice::firstOrCreate(['advice_name'=>$a],['advice_status'=>1]);

        $meds = [
            ['medicine_name'=>'Tab. Paracetamol 500mg','medicine_status'=>1,'medicine_type'=>'Tablet','medicine_power'=>'500mg'],
            ['medicine_name'=>'Tab. Napa Extra','medicine_status'=>1,'medicine_type'=>'Tablet','medicine_power'=>'500mg'],
            ['medicine_name'=>'Tab. Cetirizine 10mg','medicine_status'=>1,'medicine_type'=>'Tablet','medicine_power'=>'10mg'],
            ['medicine_name'=>'Syp. Ambrolite','medicine_status'=>1,'medicine_type'=>'Syrup','medicine_power'=>''],
            ['medicine_name'=>'Tab. Omeprazole 20mg','medicine_status'=>1,'medicine_type'=>'Tablet','medicine_power'=>'20mg'],
        ];
        foreach ($meds as $m) \App\Models\Medicine::firstOrCreate(['medicine_name'=>$m['medicine_name']], $m);

        echo '<div class="warn" style="background:#dcfce7;border-color:#86efac;color:#166534">✅ Sample data seeded successfully! <a href="?action=report">Back</a></div>';
    } catch (\Exception $e) {
        echo '<div class="warn" style="background:#fee2e2">❌ ' . $e->getMessage() . '</div>';
    }
}

// ── DRY-RUN INSERT TEST ───────────────────────────────────────────
if ($action === 'test_insert') {
    echo '<h2>🧪 Dry-Run Insert Test (nothing actually saved)</h2><table>';
    $pass = true;
    try {
        \Illuminate\Support\Facades\DB::transaction(function() use (&$pass) {
            $doctor = \App\Models\Doctor::where('doctors_status',1)->first();
            if (!$doctor) { row('Doctor','❌ NO DOCTOR FOUND — click "Seed Doctor" above', false); $pass=false; throw new \RuntimeException('no_doctor'); }
            row('Doctor', '✅ ' . $doctor->doctors_name . ' (ID:'.$doctor->doctors_id.')', true);

            $patient = \App\Models\Patient::firstOrCreate(
                ['patient_name'=>'__TEST__','patient_phone_number'=>null],
                ['patient_age'=>25,'patient_gender'=>'Male','patient_status'=>1]
            );
            row('Patient', '✅ ' . $patient->patient_name . ' (ID:'.$patient->patient_id.')', true);

            $rx = \App\Models\Prescription::create([
                'prescription_for_patient_id'     => $patient->patient_id,
                'prescription_assigned_doctor_id' => $doctor->doctors_id,
                'prescription_date'               => now()->toDateString(),
                'prescription_status'             => 1,
            ]);
            row('Prescription', '✅ Created (ID:'.$rx->prescription_id.')', true);

            \App\Models\PrescriptionLog::create([
                'prescription_id'         => $rx->prescription_id,
                'doctors_id'              => $doctor->doctors_id,
                'patient_id'              => $patient->patient_id,
                'prescription_date'       => now()->toDateString(),
                'prescription_log_status' => 1,
            ]);
            row('PrescriptionLog', '✅ Created', true);

            $comp = \App\Models\Complaint::firstOrCreate(['complaint_name'=>'__TEST_COMPLAINT__'],['complaint_status'=>1]);
            \App\Models\PrescriptionComplaint::create(['prescription_id'=>$rx->prescription_id,'complaint_id'=>$comp->complaint_id]);
            row('PrescriptionComplaint', '✅ Created', true);

            $med = \App\Models\Medicine::firstOrCreate(['medicine_name'=>'__TEST_MED__'],['medicine_status'=>1]);
            \App\Models\PrescriptionMedicine::create(['prescription_id'=>$rx->prescription_id,'medicine_id'=>$med->medicine_id,'medicine_meal_relation'=>'After food']);
            row('PrescriptionMedicine', '✅ Created', true);

            \App\Models\PrescriptionMedicineDoseDuration::create(['prescription_id'=>$rx->prescription_id,'medicine_dose'=>'1+0+1','medicine_duration'=>'5 days']);
            row('DoseDuration', '✅ Created', true);

            row('RESULT','✅ ALL INSERTS PASSED — rolling back (dry run)', true);
            throw new \RuntimeException('__ROLLBACK__');
        });
    } catch (\RuntimeException $e) {
        if ($e->getMessage() !== '__ROLLBACK__' && $e->getMessage() !== 'no_doctor') {
            row('ERROR', '❌ ' . $e->getMessage() . "\n" . $e->getFile() . ':' . $e->getLine(), false);
        }
    } catch (\Throwable $e) {
        row('EXCEPTION', '❌ ' . $e->getMessage() . "\n" . $e->getFile() . ':' . $e->getLine(), false);
    }
    echo '</table>';
    if ($pass) echo '<div class="warn" style="background:#dcfce7;border-color:#86efac;color:#166534">✅ Insert test passed! The DB is writable. The issue is in session data not reaching store().</div>';
}

// ── FULL REPORT ───────────────────────────────────────────────────
echo '<h2>1. Database Connection</h2><table>';
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    row('Connection', '✅ Connected to: ' . \Illuminate\Support\Facades\DB::connection()->getDatabaseName(), true);
} catch (\Exception $e) { row('Connection','❌ '.$e->getMessage(),false); }
echo '</table>';

echo '<h2>2. Tables</h2><table>';
$tables = ['patients','doctors','medicines','complaints','examinations','diagnoses','investigations','advices',
           'prescriptions','prescription_logs','prescription_complaints','prescription_examinations',
           'prescription_diagnoses','prescription_investigations','prescription_advices',
           'prescription_medicines','prescription_medicine_dose_durations'];
foreach ($tables as $t) {
    try { $n = \Illuminate\Support\Facades\DB::table($t)->count(); row($t, "✅ {$n} rows", true); }
    catch (\Exception $e) { row($t, '❌ MISSING: '.$e->getMessage(), false); }
}
echo '</table>';

echo '<h2>3. Doctor</h2><table>';
try {
    $doc = \App\Models\Doctor::where('doctors_status',1)->first();
    if ($doc) row('Active Doctor', '✅ '.$doc->doctors_name.' (ID:'.$doc->doctors_id.')', true);
    else row('Active Doctor', '❌ None found — click "Seed Doctor" above', false);
} catch (\Exception $e) { row('Doctor check','❌ '.$e->getMessage(),false); }
echo '</table>';

echo '<h2>4. Session Data (what will be saved)</h2><table>';
$sessionKeys = ['rx_patient','rx_complaints','rx_examinations','rx_diagnoses','rx_investigations','rx_advices','rx_medicines'];
foreach ($sessionKeys as $k) {
    $val = session($k, []);
    $count = is_array($val) ? count($val) : (empty($val) ? 0 : 1);
    $ok = $count > 0;
    row($k, $ok ? "✅ {$count} item(s): " . json_encode($val, JSON_UNESCAPED_UNICODE) : '⚠️  EMPTY — nothing to save', $ok);
}
echo '</table>';

echo '<h2>5. Model → Table Mapping</h2><table>';
$models = [
    'Patient'=>\App\Models\Patient::class,'Doctor'=>\App\Models\Doctor::class,
    'Prescription'=>\App\Models\Prescription::class,'PrescriptionLog'=>\App\Models\PrescriptionLog::class,
    'Complaint'=>\App\Models\Complaint::class,'PrescriptionComplaint'=>\App\Models\PrescriptionComplaint::class,
    'Examination'=>\App\Models\Examination::class,'PrescriptionExamination'=>\App\Models\PrescriptionExamination::class,
    'Diagnosis'=>\App\Models\Diagnosis::class,'PrescriptionDiagnosis'=>\App\Models\PrescriptionDiagnosis::class,
    'Investigation'=>\App\Models\Investigation::class,'PrescriptionInvestigation'=>\App\Models\PrescriptionInvestigation::class,
    'Advice'=>\App\Models\Advice::class,'PrescriptionAdvice'=>\App\Models\PrescriptionAdvice::class,
    'Medicine'=>\App\Models\Medicine::class,'PrescriptionMedicine'=>\App\Models\PrescriptionMedicine::class,
    'PrescriptionMedicineDoseDuration'=>\App\Models\PrescriptionMedicineDoseDuration::class,
];
foreach ($models as $name => $class) {
    try {
        $inst = new $class(); $tbl = $inst->getTable();
        $class::limit(1)->get();
        row($name, '✅ → '.$tbl, true);
    } catch (\Exception $e) { row($name, '❌ '.$e->getMessage(), false); }
}
echo '</table>';

echo '<h2>6. Routes</h2><table>';
foreach (\Illuminate\Support\Facades\Route::getRoutes() as $route) {
    if (str_contains($route->uri(), 'prescription')) {
        $methods = implode('|', $route->methods());
        row($methods.' /'.$route->uri(), $route->getActionName(), true);
    }
}
echo '</table>';

echo '</body></html>';