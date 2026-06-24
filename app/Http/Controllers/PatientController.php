<?php

// namespace App\Http\Controllers;

// use App\Models\Patient;
// use Illuminate\Http\Request;

// class PatientController extends Controller
// {
//     /**
//      * Display a listing of patients.
//      */
//     public function index()
//     {
//         $patients = Patient::orderBy('created_at', 'desc')->get();
//         return view('patients.index', compact('patients'));
//     }

//     /**
//      * Show the form for creating a new patient.
//      */
//     public function create()
//     {
//         return view('patients.create');
//     }

//     /**
//      * Store a newly created patient in storage.
//      */
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'age' => 'required|integer|min:0|max:150',
//             'gender' => 'required|in:Male,Female,Other',
//             'phone' => 'nullable|string|max:20',
//             'blood_group' => 'nullable|string|max:5',
//         ]);

//         Patient::create($validated);

//         return redirect()->route('patients.index')->with('success', 'Patient registered successfully!');
//     }
// }






namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created patient in the database.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'patient_name'          => 'required|string|max:255',
            'patient_age'           => 'nullable|integer|min:0|max:150',
            'patient_gender'        => 'nullable|in:Male,Female,Other',
            'patient_phone_number'  => 'nullable|string|max:20',
            'patient_division'      => 'nullable|string|max:255',
            'patient_district'      => 'nullable|string|max:255',
            'patient_union_village' => 'nullable|string|max:255',
        ]);

        // 2. Set default status to 1 (Active) if not provided
        $validated['patient_status'] = 1;

        // 3. Create the record
        Patient::create($validated);

        // 4. Redirect with a success notification
        return redirect()->route('patients.create')->with('success', 'Patient registered successfully!');
    }
    public function index(Request $request)
    {
        // Start a query on the Patient model
        $query = Patient::query();

        // Optional: Simple search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('patient_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('patient_phone_number', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Fetch patients ordered by most recently updated/created, with 10 items per page
        $patients = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('patients.index', compact('patients'));
    }
}