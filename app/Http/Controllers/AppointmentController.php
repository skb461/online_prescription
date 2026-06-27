<?php

namespace App\Http\Controllers;

use App\Models\DoctorAppointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Helper to resolve the logged-in doctor profile.
     */
    private function getActiveDoctorId()
    {
        if (Auth::check()) {
            $doc = Doctor::where('user_id', Auth::id())->first();
            return $doc ? $doc->doctors_id : null;
        }
        return null;
    }

    /**
     * Display a listing of appointments for the active doctor.
     */
    public function index(Request $request)
    {
        $doctorId = $this->getActiveDoctorId();
        
        if (!$doctorId) {
            return redirect()->route('dashboard')->with('error', 'No active doctor profile linked to this user account.');
        }

        $query = DoctorAppointment::with('patient')->where('doctors_id', $doctorId);

        // Optional filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('appointment_status', $request->status);
        }

        // Fetch paginated appointments ordered by closest appointment date
        $appointments = $query->orderBy('appointment_date', 'asc')->paginate(15);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Update the status of an appointment.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:2,3', // 2=Confirmed, 3=Cancelled
        ]);

        $doctorId = $this->getActiveDoctorId();
        
        // Find the appointment belonging to the logged-in doctor
        $appointment = DoctorAppointment::where('appointment_id', $id)
            ->where('doctors_id', $doctorId)
            ->firstOrFail();

        $appointment->update([
            'appointment_status' => $request->status
        ]);

        $statusText = $request->status == 2 ? 'confirmed' : 'cancelled';
        return redirect()->route('appointments.index')->with('success', "Appointment successfully {$statusText}!");
    }

    public function create()
    {
        // Get all active patients to populate the selection dropdown
        $patients = Patient::where('patient_status', 1)->orderBy('patient_name', 'asc')->get();
        $doctors = Doctor::where('doctors_status', 1)->orderBy('doctors_name', 'asc')->get();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        // 1. Validate incoming request parameters
        $request->validate([
            'patient_id'       => 'required|exists:patients,patient_id',
            'doctors_id'       => 'required|exists:doctors,doctors_id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        // 2. Resolve active logged-in doctor
        $doctor = Doctor::where('user_id', Auth::id())->first();
        if (!$doctor) {
            return redirect()->back()->withInput()->withErrors(['error' => 'No active doctor profile found for this user account.']);
        }

        // 3. Combine separate Date and Time fields into a single MySQL DATETIME format
        $dateTimeString = $request->appointment_date . ' ' . $request->appointment_time;

        // 4. Create the appointment record
        DoctorAppointment::create([
            'patient_id'         => $request->patient_id,
            'doctors_id'         => $doctor->doctors_id,
            'appointment_date'   => $dateTimeString,
            'appointment_status' => 1, // 1 = Pending default state
        ]);

        return redirect()->route('appointments.index')->with('success', 'New appointment booked successfully!');
    }

    // public function report(Request $request)
    // {
    //     // 1. Resolve logged-in doctor profile
    //     $doctor = Doctor::where('user_id', Auth::id())->first();
    //     if (!$doctor) {
    //         return redirect()->route('dashboard')->with('error', 'No active doctor profile linked to this user account.');
    //     }

    //     // 2. Setup baseline date parameters (Default: Current month if empty)
    //     $startDate = $request->query('start_date', date('Y-m-01'));
    //     $endDate = $request->query('end_date', date('Y-m-t'));

    //     // 3. Build filtered base query
    //     $baseQuery = DoctorAppointment::where('doctors_id', $doctor->doctors_id)
    //         ->whereBetween(DB::raw('DATE(appointment_date)'), [$startDate, $endDate]);

    //     // 4. Calculate total KPIs across execution categories
    //     $totalAppointments = (clone $baseQuery)->count();
        
    //     $statusCounts = (clone $baseQuery)
    //         ->select('appointment_status', DB::raw('count(*) as total'))
    //         ->groupBy('appointment_status')
    //         ->pluck('total', 'appointment_status')
    //         ->toArray();

    //     $pendingCount   = $statusCounts[1] ?? 0; // 1 = Pending
    //     $confirmedCount = $statusCounts[2] ?? 0; // 2 = Confirmed
    //     $cancelledCount = $statusCounts[3] ?? 0; // 3 = Cancelled

    //     // 5. Fetch log rows array for detailed spreadsheet representation
    //     $reportData = $baseQuery->with('patient')
    //         ->orderBy('appointment_date', 'desc')
    //         ->get();

    //     return view('appointments.report', compact(
    //         'reportData',
    //         'startDate',
    //         'endDate',
    //         'totalAppointments',
    //         'pendingCount',
    //         'confirmedCount',
    //         'cancelledCount'
    //     ));
    // }



    // public function report(Request $request)
    // {
    //     // 1. Resolve logged-in doctor profile
    //     $doctor = Doctor::where('user_id', Auth::id())->first();
    //     if (!$doctor) {
    //         return redirect()->route('dashboard')->with('error', 'No active doctor profile linked to this user account.');
    //     }

    //     // ... keep your existing calculations query logic exactly the same ...

    //     // 5. Fetch log rows array for detailed spreadsheet representation
    //     $reportData = $baseQuery->with('patient')
    //         ->orderBy('appointment_date', 'desc')
    //         ->get();

    //     // FIXED: Added 'doctor' to the compact list below
    //     return view('appointments.report', compact(
    //         'doctor', // <-- ADD THIS VARIABLE HERE
    //         'reportData',
    //         'startDate',
    //         'endDate',
    //         'totalAppointments',
    //         'pendingCount',
    //         'confirmedCount',
    //         'cancelledCount'
    //     ));
    // }


    // /**
    //  * Generate an overview report of appointments for the authenticated doctor.
    //  */
    // public function report(Request $request)
    // {
    //     // 1. Resolve logged-in doctor profile
    //     $doctor = Doctor::where('user_id', Auth::id())->first();
    //     if (!$doctor) {
    //         return redirect()->route('dashboard')->with('error', 'No active doctor profile linked to this user account.');
    //     }

    //     // 2. Setup baseline date parameters (Default: Current month if empty)
    //     $startDate = $request->query('start_date', date('Y-m-01'));
    //     $endDate = $request->query('end_date', date('Y-m-t'));

    //     // 3. Build filtered base query
    //     $baseQuery = DoctorAppointment::where('doctors_id', $doctor->doctors_id)
    //         ->whereBetween(DB::raw('DATE(appointment_date)'), [$startDate, $endDate]);

    //     // 4. Calculate total KPIs across execution categories
    //     $totalAppointments = (clone $baseQuery)->count();
        
    //     $statusCounts = (clone $baseQuery)
    //         ->select('appointment_status', DB::raw('count(*) as total'))
    //         ->groupBy('appointment_status')
    //         ->pluck('total', 'appointment_status')
    //         ->toArray();

    //     $pendingCount   = $statusCounts[1] ?? 0; // 1 = Pending
    //     $confirmedCount = $statusCounts[2] ?? 0; // 2 = Confirmed
    //     $cancelledCount = $statusCounts[3] ?? 0; // 3 = Cancelled

    //     // 5. Fetch log rows array for detailed spreadsheet representation
    //     $reportData = $baseQuery->with('patient')
    //         ->orderBy('appointment_date', 'desc')
    //         ->get();

    //     // Pass all variables safely to the blade template
    //     return view('appointments.report', compact(
    //         'doctor',
    //         'reportData',
    //         'startDate',
    //         'endDate',
    //         'totalAppointments',
    //         'pendingCount',
    //         'confirmedCount',
    //         'cancelledCount'
    //     ));
    // }


    public function report(Request $request)
    {
        // 1. Fetch all active doctors for the search selection menu
        $doctors = Doctor::where('doctors_status', 1)->orderBy('doctors_name', 'asc')->get();

        $startDate = $request->query('start_date', date('Y-m-01'));
        $endDate = $request->query('end_date', date('Y-m-t'));

        // 2. Build filtered base query
        $baseQuery = DoctorAppointment::whereBetween(DB::raw('DATE(appointment_date)'), [$startDate, $endDate]);

        // 3. OPTIONAL FILTER: If a doctor selection is requested, target it directly
        if ($request->filled('doctors_id')) {
            $baseQuery->where('doctors_id', $request->doctors_id);
        }

        // 4. Calculate status counters based on selection
        $totalAppointments = (clone $baseQuery)->count();
        $statusCounts = (clone $baseQuery)->select('appointment_status', DB::raw('count(*) as total'))->groupBy('appointment_status')->pluck('total', 'appointment_status')->toArray();

        $pendingCount   = $statusCounts[1] ?? 0;
        $confirmedCount = $statusCounts[2] ?? 0;
        $cancelledCount = $statusCounts[3] ?? 0;

        // 5. Get data records along with matching patient and doctor profiles
        $reportData = $baseQuery->with(['patient', 'doctor'])->orderBy('appointment_date', 'desc')->get();

        return view('appointments.report', compact(
            'doctors', 'reportData', 'startDate', 'endDate', 
            'totalAppointments', 'pendingCount', 'confirmedCount', 'cancelledCount'
        ));
    }
}