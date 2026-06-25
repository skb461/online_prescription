<?php

namespace App\Http\Controllers;

use App\Models\DoctorAppointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        return view('appointments.create', compact('patients'));
    }

    public function store(Request $request)
    {
        // 1. Validate incoming request parameters
        $request->validate([
            'patient_id'       => 'required|exists:patients,patient_id',
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
}