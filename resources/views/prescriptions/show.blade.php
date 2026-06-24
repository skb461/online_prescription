@extends('layouts.app')

@section('content')

    @php
        $rx = $prescription;
        $patient = $rx->patient;
        $doctor = $rx->doctor;

        // ── Safe date helpers ───────────────────────────────────────────
        $rxDate = $rx->prescription_date ? \Carbon\Carbon::parse($rx->prescription_date)->format('d M, Y') : '—';
        $nextDate = $rx->next_meeting_date
            ? \Carbon\Carbon::parse($rx->next_meeting_date)->format('d M, Y')
            : 'Not Scheduled';

        // ── First complaint name (for display) ──────────────────────────
        $firstComplaint = $rx->complaints->first()?->complaint?->complaint_name ?? '—';
    @endphp

    {{-- ══════════════ TOOLBAR (no-print) ══════════════ --}}
    <div class="no-print p-6 max-w-[1100px] mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('prescriptions.index') }}"
                    class="text-xs font-bold text-slate-500 hover:text-indigo-600 bg-white border border-slate-200 px-4 py-2 rounded-xl transition-all">
                    ← Back to List
                </a>
                <div>
                    <h1 class="text-lg font-black text-slate-900">
                        Prescription
                        <span
                            class="font-mono text-indigo-600">RX-{{ str_pad($rx->prescription_id, 6, '0', STR_PAD_LEFT) }}</span>
                    </h1>
                    <p class="text-xs text-slate-400">{{ $patient->patient_name ?? '—' }} · {{ $rxDate }}</p>
                </div>
            </div>
            <button onclick="window.print()"
                class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black px-6 py-2.5 rounded-xl text-sm shadow-md transition-all active:scale-95">
                🖨️ Print Prescription
            </button>
        </div>
    </div>

    {{-- ══════════════ PRINT PRESCRIPTION ══════════════ --}}
    <div id="print-area"
        class="bg-white max-w-[1100px] mx-auto border border-slate-200 rounded-3xl shadow-sm overflow-hidden print:border-0 print:shadow-none print:rounded-none print:max-w-full">

        {{-- Top colour bar --}}
        <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 print:hidden"></div>

        <div class="p-10">

            {{-- ── Doctor Header ── --}}
            <div class="flex justify-between items-start border-b-2 border-slate-900 pb-5 mb-6">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                        {{ strtoupper($doctor->doctors_name ?? 'UNKNOWN DOCTOR') }}
                    </h2>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-0.5">
                        {{ $doctor->doctors_designations ?? '' }}
                    </p>
                    <p class="text-xs text-slate-400 font-semibold">
                        {{ $doctor->doctors_speciality ?? '' }}
                    </p>
                    @if ($doctor && $doctor->doctor_bmdc_registration_number)
                        <p class="text-[10px] text-slate-300 font-mono mt-0.5">
                            BMDC Reg: {{ $doctor->doctor_bmdc_registration_number }}
                        </p>
                    @endif
                </div>
                <div class="text-right text-xs text-slate-400 leading-relaxed">
                    <p class="font-bold text-slate-700 text-sm">{{ $doctor->doctors_department ?? '' }}</p>
                    <p>{{ $doctor->doctors_address ?? '' }}</p>
                    <p class="font-mono">{{ $doctor->doctors_phone_number ?? '' }}</p>
                </div>
            </div>

            {{-- ── Patient Strip ── --}}
            <div
                class="bg-slate-900 text-white px-5 py-3 rounded-xl grid grid-cols-2 md:grid-cols-4 gap-4 text-xs font-bold tracking-wide mb-8">
                <div>
                    <span class="text-slate-400 font-medium block text-[10px] uppercase mb-0.5">Patient</span>
                    {{ $patient->patient_name ?? '—' }}
                </div>
                <div>
                    <span class="text-slate-400 font-medium block text-[10px] uppercase mb-0.5">Age / Sex</span>
                    {{ $patient->patient_age ?? '—' }} Yrs / {{ $patient->patient_gender ?? '—' }}
                </div>
                <div>
                    <span class="text-slate-400 font-medium block text-[10px] uppercase mb-0.5">Date Issued</span>
                    {{ $rxDate }}
                </div>
                <div>
                    <span class="text-slate-400 font-medium block text-[10px] uppercase mb-0.5">Next Visit</span>
                    {{ $nextDate }}
                </div>
            </div>

            {{-- ── IDs Row (no-print) ── --}}
            <div class="no-print flex gap-3 mb-6 flex-wrap">
                <span
                    class="font-mono text-xs bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg border border-indigo-100 font-black">
                    RX-{{ str_pad($rx->prescription_id, 6, '0', STR_PAD_LEFT) }}
                </span>
                <span class="font-mono text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg font-bold">
                    PT-{{ str_pad($patient->patient_id ?? 0, 5, '0', STR_PAD_LEFT) }}
                </span>
                <span
                    class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg border border-emerald-100 font-bold">
                    {{ $rx->prescription_status == 1 ? '✅ Active' : '⚪ Inactive' }}
                </span>
            </div>

            {{-- ── Rₓ symbol ── --}}
            <div class="mb-6">
                <span class="text-5xl font-serif font-black text-indigo-700 select-none">Rₓ</span>
            </div>

            {{-- ── Clinical Content Grid ── --}}
            <div class="grid grid-cols-12 gap-8 items-start">

                {{-- LEFT: Complaints, Dx, O/E, Investigations ── --}}
                <div class="col-span-12 md:col-span-4 space-y-6 border-r-2 border-slate-100 pr-6 min-h-[400px]">

                    {{-- Complaints --}}
                    @if ($rx->complaints->count() > 0)
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2 font-mono">C/C:
                            </h4>
                            @foreach ($rx->complaints as $item)
                                <div class="text-xs font-bold text-slate-800 py-0.5">
                                    • {{ $item->complaint->complaint_name ?? '—' }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Diagnosis --}}
                    @if ($rx->diagnoses->count() > 0)
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-rose-500 mb-2 font-mono">
                                Provisional Dx:</h4>
                            @foreach ($rx->diagnoses as $item)
                                <div class="text-xs font-extrabold italic text-slate-900 py-0.5">
                                    • <span class="text-rose-600">{{ $item->diagnosis->diagnosis_name ?? '—' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- On Examination --}}
                    @if ($rx->examinations->count() > 0)
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2 font-mono">O/E:
                            </h4>
                            @foreach ($rx->examinations as $item)
                                <div class="text-xs font-bold text-slate-800 py-0.5">
                                    • {{ $item->examination->examination_name ?? '—' }}:
                                    <span class="text-indigo-600">{{ $item->examination_value ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Investigations --}}
                    @if ($rx->investigations->count() > 0)
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-purple-500 mb-2 font-mono">
                                Investigations:</h4>
                            @foreach ($rx->investigations as $item)
                                <div class="text-xs font-bold text-slate-800 py-0.5">
                                    • {{ $item->investigation->investigation_name ?? '—' }}
                                    @if ($item->investigation_value)
                                        <span class="text-purple-600 font-medium">[{{ $item->investigation_value }}]</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (
                        $rx->complaints->count() === 0 &&
                            $rx->diagnoses->count() === 0 &&
                            $rx->examinations->count() === 0 &&
                            $rx->investigations->count() === 0)
                        <p class="text-xs text-slate-300 italic">No clinical notes recorded.</p>
                    @endif
                </div>

                {{-- RIGHT: Medicines + Advice ── --}}
                <div class="col-span-12 md:col-span-8 pl-2 space-y-8">

                    {{-- Medicines --}}
                    @if ($rx->medicines->count() > 0)
                        <div>
                            <ol class="list-decimal pl-5 space-y-5 text-slate-900">
                                @foreach ($rx->medicines as $idx => $item)
                                    @php
                                        $medName = $item->medicine->medicine_name ?? '—';
                                        // Find the dose duration for this prescription
                                        // (dose durations are per prescription, we show them in order)
                                        $dose = $rx->doseDurations->get($idx);
                                    @endphp
                                    <li class="pl-1">
                                        <div class="text-sm font-extrabold text-slate-900">{{ $medName }}</div>
                                        <div class="text-xs text-slate-500 font-medium mt-1 space-y-0.5">
                                            @if ($dose)
                                                <span
                                                    class="text-slate-800 font-bold bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                                    {{ $dose->medicine_dose ?? '' }}
                                                </span>
                                                @if ($dose->medicine_duration)
                                                    — <span
                                                        class="text-indigo-600 font-extrabold">{{ $dose->medicine_duration }}</span>
                                                @endif
                                            @endif
                                            @if ($item->medicine_meal_relation)
                                                — <span
                                                    class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded text-[11px]">
                                                    {{ $item->medicine_meal_relation }}
                                                </span>
                                            @endif
                                            @if ($item->medicine_instructions)
                                                <br>
                                                <span
                                                    class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 inline-block mt-1">
                                                    {{ $item->medicine_instructions }}
                                                </span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @else
                        <p class="text-xs text-slate-300 italic pl-2">No medicines prescribed.</p>
                    @endif

                    {{-- Advice --}}
                    @if ($rx->advices->count() > 0)
                        <div class="border-t-2 border-dashed border-slate-200 pt-5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2 font-mono">Adv:
                            </h4>
                            <ul class="list-disc pl-5 space-y-1.5">
                                @foreach ($rx->advices as $item)
                                    <li class="text-xs font-bold text-slate-700">
                                        {{ $item->advice->advice_name ?? '—' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>

            {{-- ── Footer ── --}}
            <div class="border-t-2 border-slate-900 mt-10 pt-5 flex justify-between items-end">
                <div class="text-[10px] font-mono text-slate-400 tracking-wide">
                    AUTH-{{ $rx->prescription_id }}-{{ date('Ymd') }}
                </div>
                <div class="text-center">
                    <div class="border-t border-slate-400 pt-3 w-44 text-xs font-bold text-slate-600">
                        Doctor's Signature &amp; Stamp
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════ PRINT STYLES ══════════════ --}}
    <style>
        @media print {
            @page {
                margin: 0.4in;
                size: A4;
            }

            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            .print\:hidden {
                display: none !important;
            }
        }
    </style>

@endsection
