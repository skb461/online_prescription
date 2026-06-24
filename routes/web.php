<?php

// use App\Http\Controllers\PatientController;
// use App\Http\Controllers\PrescriptionController;
// use Illuminate\Support\Facades\Route;

// // Landing page
// Route::get('/', function () {
//     return redirect()->route('prescriptions.create');
// });

// // Patient routes
// Route::prefix('patients')->name('patients.')->group(function () {
//     Route::get('/', [PatientController::class, 'index'])->name('index');
//     Route::get('/create', [PatientController::class, 'create'])->name('create');
//     Route::post('/', [PatientController::class, 'store'])->name('store');
// });

// // Prescription routes
// Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
//     Route::get('/', [PrescriptionController::class, 'index'])->name('index');
//     Route::get('/create', [PrescriptionController::class, 'create'])->name('create');
//     Route::post('/store', [PrescriptionController::class, 'store'])->name('store');
//     Route::get('/{id}', [PrescriptionController::class, 'show'])->name('show');
// });



// // ================================================================
// // FILE: routes/web.php  — add these lines
// // ================================================================

// use App\Http\Controllers\PrescriptionController;
// use Illuminate\Support\Facades\Route;

// Route::prefix('prescriptions')->name('prescriptions.')->group(function () {

//     // ── STATIC routes MUST come before /{id} ──────────────────────────────
//     // Laravel matches routes top-to-bottom. If /{id} is defined first,
//     // it catches "debug-test", "create", etc. as the $id parameter.

//     Route::get('/',           [PrescriptionController::class, 'index'])->name('index');
//     Route::get('/create',     [PrescriptionController::class, 'create'])->name('create');
//     Route::post('/store',     [PrescriptionController::class, 'store'])->name('store');

//     // ⚠️  DEBUG ROUTE — remove in production
//     // Visit: http://127.0.0.1:8001/prescriptions/debug-test
//     Route::get('/debug-test', [PrescriptionController::class, 'debugTest'])->name('debugTest');

//     // ── DYNAMIC route MUST be LAST ─────────────────────────────────────────
//     Route::get('/{id}',       [PrescriptionController::class, 'show'])->name('show');
// });







// // ================================================================
// // FILE: routes/web.php  — add these lines
// // ================================================================

// use App\Http\Controllers\PrescriptionWizardController;

// Route::prefix('prescriptions')->name('prescriptions.')->group(function () {

//     // ── Existing list/show routes (keep these) ─────────────────────────────
//     Route::get('/',           [PrescriptionController::class, 'index'])->name('index');

//     // ── WIZARD (multi-step, no JS) ──────────────────────────────────────────
//     Route::prefix('wizard')->name('wizard.')->group(function () {

//         Route::get('/start',              [PrescriptionWizardController::class, 'start'])->name('start');

//         Route::get('/patient',            [PrescriptionWizardController::class, 'patientForm'])->name('patient');
//         Route::post('/patient',           [PrescriptionWizardController::class, 'patientSave']);

//         Route::get('/complaints',         [PrescriptionWizardController::class, 'complaintsForm'])->name('complaints');
//         Route::post('/complaints',        [PrescriptionWizardController::class, 'complaintsSave']);

//         Route::get('/examinations',       [PrescriptionWizardController::class, 'examinationsForm'])->name('examinations');
//         Route::post('/examinations',      [PrescriptionWizardController::class, 'examinationsSave']);

//         Route::get('/diagnoses',          [PrescriptionWizardController::class, 'diagnosesForm'])->name('diagnoses');
//         Route::post('/diagnoses',         [PrescriptionWizardController::class, 'diagnosesSave']);

//         Route::get('/investigations',     [PrescriptionWizardController::class, 'investigationsForm'])->name('investigations');
//         Route::post('/investigations',    [PrescriptionWizardController::class, 'investigationsSave']);

//         Route::get('/medicines',          [PrescriptionWizardController::class, 'medicinesForm'])->name('medicines');
//         Route::post('/medicines/add',     [PrescriptionWizardController::class, 'medicinesAdd'])->name('medicines.add');
//         Route::post('/medicines/remove/{index}', [PrescriptionWizardController::class, 'medicinesRemove'])->name('medicines.remove');
//         Route::post('/medicines/continue', [PrescriptionWizardController::class, 'medicinesContinue'])->name('medicines.continue');

//         Route::get('/advices',            [PrescriptionWizardController::class, 'advicesForm'])->name('advices');
//         Route::post('/advices',           [PrescriptionWizardController::class, 'advicesSave']);

//         Route::get('/review',             [PrescriptionWizardController::class, 'reviewForm'])->name('review');
//         Route::post('/review',            [PrescriptionWizardController::class, 'reviewSubmit']);

//         Route::get('/done/{id}',          [PrescriptionWizardController::class, 'done'])->name('done');
//     });

//     // ── DYNAMIC show route MUST be LAST (after all static/wizard routes) ───
//     Route::get('/{id}',       [PrescriptionController::class, 'show'])->name('show');
// });






use App\Http\Controllers\PrescriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;

// Application Main Dashboard Index Core Endpoint
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Patient List (Index)
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');

// Patient Creation
Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

Route::get('/api/proxy-medicines', function (Request $request) {
    $name = $request->query('name', '');

    // Server-to-server requests bypass CORS completely
    $response = Http::get("https://portal.proyashealthcare.com/load-medicine-list", [
        'name' => $name
    ]);

    return response()->json($response->json());
})->name('api.proxy-medicines');

Route::prefix('prescriptions')->name('prescriptions.')->group(function () {

    // ── Static / named routes FIRST (before /{id}) ─────────────────────────
    Route::get('/',              [PrescriptionController::class, 'index'])->name('index');
    Route::get('/create',        [PrescriptionController::class, 'create'])->name('create');
    Route::get('/print-preview', [PrescriptionController::class, 'printPreview'])->name('printPreview');

    // ── Save ────────────────────────────────────────────────────────────────
    Route::post('/store',        [PrescriptionController::class, 'store'])->name('store');

    // ── Session management routes (PHP form POSTs — replace all JS state) ───
    Route::post('/set-patient',       [PrescriptionController::class, 'setPatient'])->name('setPatient');
    Route::post('/add-complaint',     [PrescriptionController::class, 'addComplaint'])->name('addComplaint');
    Route::post('/add-examination',   [PrescriptionController::class, 'addExamination'])->name('addExamination');
    Route::post('/add-diagnosis',     [PrescriptionController::class, 'addDiagnosis'])->name('addDiagnosis');
    Route::post('/add-investigation', [PrescriptionController::class, 'addInvestigation'])->name('addInvestigation');
    Route::post('/add-medicine',      [PrescriptionController::class, 'addMedicine'])->name('addMedicine');
    Route::post('/add-advice',        [PrescriptionController::class, 'addAdvice'])->name('addAdvice');
    Route::post('/remove-item',       [PrescriptionController::class, 'removeItem'])->name('removeItem');
    Route::post('/clear-session',     [PrescriptionController::class, 'clearSession'])->name('clearSession');

    // ── Debug route (remove in production) ──────────────────────────────────
    Route::get('/debug-test',    [PrescriptionController::class, 'debugTest'])->name('debugTest');

    // ── Dynamic /{id} MUST be LAST ───────────────────────────────────────────
    Route::get('/{id}',          [PrescriptionController::class, 'show'])->name('show');
});