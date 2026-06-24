{{--
    Step 9 — Confirmation page after successful save.
    Includes a print-friendly prescription layout below the success banner.
    Printing uses the browser's native window.print() via a plain <a> with
    no JS event handlers needed (the browser's print dialog is triggered by
    a standard print stylesheet + the OS print shortcut, OR a single inline
    `onclick="window.print()"` if you want a button — see note below).
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prescription #{{ $prescription->prescription_id }} – Saved</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                margin: .4in;
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
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-800 min-h-screen">

    <div class="max-w-3xl mx-auto py-10 px-4">

        {{-- Success banner --}}
        <div class="no-print bg-emerald-50 border border-emerald-200 rounded-2xl p-6 mb-6 text-center">
            <div class="text-3xl mb-2">✅</div>
            <h1 class="text-lg font-black text-emerald-800">Prescription #{{ $prescription->prescription_id }} Saved
                Successfully</h1>
            <p class="text-xs text-emerald-600 font-semibold mt-1">All data has been written to the database.</p>

            <div class="flex justify-center gap-3 mt-5">
                <a href="{{ route('prescriptions.wizard.start') }}"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-wider rounded-xl shadow-md">
                    + New Prescription
                </a>
                {{--
                Printing strictly requires a browser action (Ctrl+P / Cmd+P) since
                there is no server-side way to open the OS print dialog.
                This is the one unavoidable exception — without ANY inline JS logic
                of our own, we rely on the browser's native print feature, triggered
                here by a plain link using the print: URL scheme isn't standard, so
                a minimal `onclick="window.print()"` is used ONLY for convenience.
                You can remove this button entirely and use Ctrl+P / Cmd+P instead.
            --}}
                <a href="#" onclick="window.print(); return false;"
                    class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-black uppercase tracking-wider rounded-xl shadow-md">
                    🖨️ Print (or press Ctrl/Cmd+P)
                </a>
            </div>
        </div>

        {{-- Printable prescription --}}
        <div id="print-area" class="bg-white border border-slate-200 rounded-2xl p-10">

            <div class="flex justify-between items-start border-b-2 border-slate-900 pb-4 mb-6">
                <div>
                    <h2 class="text-xl font-black tracking-tight">{{ strtoupper($prescription->doctor->doctors_name) }}
                    </h2>
                    <p class="text-[11px] font-bold text-slate-600">{{ $prescription->doctor->doctors_designations }}
                    </p>
                    <p class="text-[10px] font-bold text-slate-400">{{ $prescription->doctor->doctors_speciality }}</p>
                    <p class="text-[10px] text-slate-400">BMDC Reg:
                        {{ $prescription->doctor->doctor_bmdc_registration_number }}</p>
                </div>
                <div class="text-right text-[11px] text-slate-500 font-medium">
                    <p class="font-bold">{{ $prescription->doctor->doctors_department }}</p>
                    <p>{{ $prescription->doctor->doctors_address }}</p>
                </div>
            </div>

            <div class="bg-slate-900 text-white px-4 py-2.5 rounded-lg grid grid-cols-4 gap-4 text-xs font-bold mb-6">
                <p>Name: <span class="font-normal">{{ $prescription->patient->patient_name }}</span></p>
                <p>Age: <span class="font-normal">{{ $prescription->patient->patient_age }}</span></p>
                <p>Sex: <span class="font-normal">{{ $prescription->patient->patient_gender }}</span></p>
                <p class="text-right">Date: <span
                        class="font-normal">{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d M, Y') }}</span>
                </p>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-4 space-y-5 border-r border-slate-200 pr-4">
                    @if ($prescription->complaints->isNotEmpty())
                        <div>
                            <h4 class="text-[10px] font-black uppercase text-slate-400 mb-1">C/C</h4>
                            @foreach ($prescription->complaints as $pc)
                                <p class="text-xs font-bold">• {{ $pc->complaint->complaint_name ?? '—' }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if ($prescription->diagnoses->isNotEmpty())
                        <div>
                            <h4 class="text-[10px] font-black uppercase text-rose-500 mb-1">Diagnosis</h4>
                            @foreach ($prescription->diagnoses as $pd)
                                <p class="text-xs font-extrabold italic text-rose-700">•
                                    {{ $pd->diagnosis->diagnosis_name ?? '—' }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if ($prescription->examinations->isNotEmpty())
                        <div>
                            <h4 class="text-[10px] font-black uppercase text-slate-400 mb-1">O/E</h4>
                            @foreach ($prescription->examinations as $pe)
                                <p class="text-xs font-bold">• {{ $pe->examination->examination_name ?? '—' }}:
                                    {{ $pe->examination_value }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if ($prescription->investigations->isNotEmpty())
                        <div>
                            <h4 class="text-[10px] font-black uppercase text-purple-400 mb-1">Investigations</h4>
                            @foreach ($prescription->investigations as $pi)
                                <p class="text-xs font-bold">• {{ $pi->investigation->investigation_name ?? '—' }}
                                    [{{ $pi->investigation_value }}]</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-span-8 pl-2 space-y-5">
                    <div>
                        <span class="text-3xl font-serif font-black text-slate-900 block mb-3">Rx</span>
                        @if ($prescription->medicines->isNotEmpty())
                            <ol class="list-decimal pl-5 space-y-3 text-sm font-bold">
                                @foreach ($prescription->medicines as $i => $pm)
                                    @php $dose = $prescription->doseDurations[$i] ?? null; @endphp
                                    <li>
                                        {{ $pm->medicine->medicine_name ?? '—' }}
                                        <div class="text-xs font-semibold text-slate-600 mt-0.5">
                                            {{ $dose->medicine_dose ?? '' }} — {{ $pm->medicine_meal_relation }} —
                                            <span
                                                class="text-indigo-600 font-extrabold">{{ $dose->medicine_duration ?? '' }}</span>
                                            @if ($pm->medicine_instructions)
                                                <br><span
                                                    class="text-amber-700 italic font-bold">{{ $pm->medicine_instructions }}</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-slate-300 italic text-xs">No medicines prescribed</p>
                        @endif
                    </div>

                    @if ($prescription->advices->isNotEmpty())
                        <div class="border-t border-dashed border-slate-200 pt-4">
                            <h4 class="text-[10px] font-black uppercase text-slate-400 mb-2">Advice</h4>
                            <ul class="list-disc pl-5 text-xs font-bold space-y-1">
                                @foreach ($prescription->advices as $pa)
                                    <li>{{ $pa->advice->advice_name ?? '—' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($prescription->next_meeting_date)
                        <p class="text-xs font-bold text-indigo-600">📅 Next follow-up:
                            {{ \Carbon\Carbon::parse($prescription->next_meeting_date)->format('d M, Y') }}</p>
                    @endif
                </div>
            </div>

            <div
                class="border-t-2 border-slate-900 pt-4 mt-8 flex justify-between items-end text-[10px] font-mono text-slate-400">
                <span>RX-{{ $prescription->prescription_id }}</span>
                <span class="border-t border-slate-300 pt-4 w-44 text-center font-sans font-bold text-slate-600">Medical
                    Practitioner Stamp</span>
            </div>
        </div>
    </div>
</body>

</html>
