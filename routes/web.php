<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AppointmentController; // <-- Ensure this is imported

/*
|--------------------------------------------------------------------------
| Web Routes Framework - RxMaster Pro
|--------------------------------------------------------------------------
*/

// ══════════════ GUEST AUTHENTICATION ROUTES ══════════════
Route::middleware('guest')->group(function () {
    Route::get('/login', [DoctorAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [DoctorAuthController::class, 'login'])->name('login.store');
    
    Route::get('/register', [DoctorAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [DoctorAuthController::class, 'register'])->name('register.store');
});


// ══════════════ SECURE PRACTITIONER ROUTES ══════════════
Route::middleware('auth')->group(function () {

    // ── Session Terminate ──
    Route::post('/logout', [DoctorAuthController::class, 'logout'])->name('logout');

    // ── Application Core Dashboard ──
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // ── Master Patient Registry ──
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/',        [PatientController::class, 'index'])->name('index');
        Route::get('/create',  [PatientController::class, 'create'])->name('create');
        Route::post('/',       [PatientController::class, 'store'])->name('store');
    });

    // ── Doctor Appointments Hub ──
    // Route::prefix('appointments')->name('appointments.')->group(function () {
    //     Route::get('/',            [AppointmentController::class, 'index'])->name('index');
    //     Route::post('/{id}/status', [AppointmentController::class, 'updateStatus'])->name('updateStatus');
    // });
    // Inside Route::middleware('auth')->group(...)

    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
        Route::get('/create', [AppointmentController::class, 'create'])->name('create'); // <-- Add form route
        Route::post('/', [AppointmentController::class, 'store'])->name('store');       // <-- Add save route
        Route::post('/{id}/status', [AppointmentController::class, 'updateStatus'])->name('updateStatus');

        Route::get('/report', [AppointmentController::class, 'report'])->name('report');
    });

    // ── Medication API Service Proxy ──
    Route::get('/api/proxy-medicines', function (Request $request) {
        $name = $request->query('name', '');
        $response = Http::get("https://portal.proyashealthcare.com/load-medicine-list", [
            'name' => $name
        ]);
        return response()->json($response->json());
    })->name('api.proxy-medicines');

    // ── Prescription Workspace Engine ──
    Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
        Route::get('/',              [PrescriptionController::class, 'index'])->name('index');
        Route::get('/create',        [PrescriptionController::class, 'create'])->name('create');
        Route::get('/print-preview', [PrescriptionController::class, 'printPreview'])->name('printPreview');
        Route::post('/store',        [PrescriptionController::class, 'store'])->name('store');

        Route::post('/set-patient',       [PrescriptionController::class, 'setPatient'])->name('setPatient');
        Route::post('/add-complaint',     [PrescriptionController::class, 'addComplaint'])->name('addComplaint');
        Route::post('/add-examination',   [PrescriptionController::class, 'addExamination'])->name('addExamination');
        Route::post('/add-diagnosis',     [PrescriptionController::class, 'addDiagnosis'])->name('addDiagnosis');
        Route::post('/add-investigation', [PrescriptionController::class, 'addInvestigation'])->name('addInvestigation');
        Route::post('/add-medicine',      [PrescriptionController::class, 'addMedicine'])->name('addMedicine');
        Route::post('/add-advice',        [PrescriptionController::class, 'addAdvice'])->name('addAdvice');
        Route::post('/remove-item',       [PrescriptionController::class, 'removeItem'])->name('removeItem');
        Route::post('/clear-session',     [PrescriptionController::class, 'clearSession'])->name('clearSession');

        Route::get('/debug-test',    [PrescriptionController::class, 'debugTest'])->name('debugTest');
        Route::get('/{id}',          [PrescriptionController::class, 'show'])->name('show');
    });
});