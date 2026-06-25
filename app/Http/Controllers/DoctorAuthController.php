<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DoctorAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.doctor-register');
    }

    public function showLogin()
    {
        return view('auth.doctor-login');
    }

    public function login(Request $request)
    {
        // 1. Validate incoming user input credentials
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. Attempt login authentication matching the users table record
        // Remember checkbox evaluates to true if checked
        if (Auth::attempt($credentials, $request->has('remember'))) {
            
            // Regenerate session ID to prevent session fixation attacks
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')
                ->with('success', 'Welcome back, Doctor!');
        }

        // 3. If authentication fails, return with explicit error messages
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out safely.');
    }

    public function register(Request $request)
    {
        // 1. Validate incoming criteria for all 3 tables
        $request->validate([
            // User Table Credentials
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
            
            // Doctor Table Profile Data
            'doctors_name'          => 'required|string|max:255',
            'doctors_designations'  => 'nullable|string|max:255',
            'doctors_phone_number'  => 'nullable|string|max:20',
            'doctors_gender'        => 'nullable|in:Male,Female,Other',
            'doctors_address'       => 'nullable|string',
            'doctors_nationality'   => 'nullable|string|max:255',
            'doctors_nid'           => 'nullable|string|max:30',
            'doctors_type'          => 'required|in:Permanent,Guest',
            'doctors_department'    => 'nullable|string|max:255',
            'doctors_speciality'    => 'nullable|string|max:255',
            'bmdc_number'           => 'nullable|string|max:50|unique:doctors,doctor_bmdc_registration_number',

            // Schedules Table Configuration
            'visiting_time'         => 'nullable|string',
            'visiting_days'         => 'required|array', // Received as array, saved as comma-separated string
            'fees_new'              => 'required|numeric|min:0',
            'fees_old'              => 'required|numeric|min:0',
        ]);

        try {
            // 2. Perform safe multi-table entry inside a single isolation Transaction
            DB::transaction(function () use ($request) {
                
                // Create auth user credentials login instance
                $user = User::create([
                    'name'     => $request->doctors_name,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // Create profile entity linking back to user_id
                $doctor = Doctor::create([
                    'user_id'                         => $user->id,
                    'doctors_name'                    => $request->doctors_name,
                    'doctors_designations'            => $request->doctors_designations,
                    'doctors_phone_number'            => $request->doctors_phone_number,
                    'doctors_gender'                  => $request->doctors_gender,
                    'doctors_address'                 => $request->doctors_address,
                    'doctors_nationality'             => $request->doctors_nationality,
                    'doctors_nid'                     => $request->doctors_nid,
                    'doctors_type'                    => $request->doctors_type,
                    'doctors_department'              => $request->doctors_department,
                    'doctors_speciality'              => $request->doctors_speciality,
                    'doctor_bmdc_registration_number' => $request->bmdc_number,
                    'doctors_status'                  => 1, // Active by default
                ]);

                // Create standard scheduling metrics mapping back to the doctor_id
                DoctorSchedule::create([
                    'doctors_id'                => $doctor->doctors_id,
                    'doctors_visiting_time'     => $request->visiting_time,
                    'doctors_visiting_days'     => implode(',', $request->visiting_days), // e.g. "Sat,Sun,Mon"
                    'doctors_visiting_fees_new' => $request->fees_new,
                    'doctors_visiting_fees_old' => $request->fees_old,
                    'doctors_schedule_status'   => 1,
                ]);

                // Log the newly registered practitioner into the session directly
                Auth::login($user);
            });

            return redirect()->route('dashboard')->with('success', 'Doctor Account & Scheduling generated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Registration transaction failed: ' . $e->getMessage()]);
        }
    }
}