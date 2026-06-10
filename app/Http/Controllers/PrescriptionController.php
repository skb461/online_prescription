<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of generated prescriptions.
     */
    public function index()
    {
        // Eager load patient and doctor profiles to maximize query optimization
        $prescriptions = Prescription::with(['patient', 'doctor'])->orderBy('created_at', 'desc')->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the application form dashboard to create a prescription.
     */
    public function create()
    {
        $patients = Patient::orderBy('name', 'asc')->get();
        return view('prescriptions.create', compact('patients'));
    }

    /**
     * Store a newly created prescription and its inline medicines securely.
     */
    public function store(Request $request)
    {
        // Validation rules enforcing array checks on running dynamic rows
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'chief_complaints' => 'required|string',
            'blood_pressure' => 'nullable|string|max:50',
            'weight' => 'nullable|string|max:20',
            'medical_history' => 'nullable|string',
            'advice' => 'nullable|string',
            'next_follow_up' => 'nullable|date|after_or_equal:today',
            
            // Nested validation rules for custom added medicines rows
            'medicines' => 'required|array|min:1',
            'medicines.*.name' => 'required|string|max:255',
            'medicines.*.dosage' => 'required|string|max:100',
            'medicines.*.timing' => 'required|string|max:100',
            'medicines.*.duration' => 'required|string|max:100',
        ]);

        // Wrap operations within a DB Transaction to guarantee structural database safety
        DB::transaction(function () use ($validated) {
            $prescription = Prescription::create([
                'user_id' => Auth::id() ?? 1, // Falls back to seed ID 1 if auth system isn't live yet
                'patient_id' => $validated['patient_id'],
                'chief_complaints' => $validated['chief_complaints'],
                'blood_pressure' => $validated['blood_pressure'],
                'weight' => $validated['weight'],
                'medical_history' => $validated['medical_history'],
                'advice' => $validated['advice'],
                'next_follow_up' => $validated['next_follow_up'],
            ]);

            // Map database collection values array sequentially onto child components
            foreach ($validated['medicines'] as $medicine) {
                $prescription->items()->create([
                    'medicine_name' => $medicine['name'],
                    'dosage' => $medicine['dosage'],
                    'timing' => $medicine['timing'],
                    'duration' => $medicine['duration'],
                ]);
            }
        });

        return redirect()->route('prescriptions.create')->with('success', 'Prescription compiled and saved successfully!');
    }

    /**
     * Display a specific finalized prescription format layout view.
     */
    public function show($id)
    {
        $prescription = Prescription::with(['patient', 'doctor', 'items'])->findOrFail($id);
        return view('prescriptions.show', compact('prescription'));
    }
}