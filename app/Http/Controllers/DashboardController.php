<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the main administration metrics panel view layout.
     */
    public function index()
    {
        // 1. Gather high-level KPI card calculations
        $totalPatients = Patient::count();
        $totalPrescriptions = Prescription::count();
        
        // Count unique diagnostic terms entered today vs lifetime footprint metrics
        $prescriptionsToday = Prescription::whereDate('prescription_date', now()->toDateString())->count();
        $systemMedicines = Medicine::where('medicine_status', 1)->count();

        // 2. Query data structural charts or analytics lists: Recent Prescriptions Logs
        $recentPrescriptions = Prescription::with(['patient', 'doctor'])
            ->orderByDesc('prescription_id')
            ->take(5)
            ->get();

        // 3. Query distribution: Demographics distribution counts
        $genderDistribution = Patient::select('patient_gender', DB::raw('count(*) as total'))
            ->whereNotNull('patient_gender')
            ->groupBy('patient_gender')
            ->get();

        return view('dashboard', compact(
            'totalPatients',
            'totalPrescriptions',
            'prescriptionsToday',
            'systemMedicines',
            'recentPrescriptions',
            'genderDistribution'
        ));
    }
}