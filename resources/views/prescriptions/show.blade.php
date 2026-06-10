<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription_#{{ $prescription->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #fff !important;
                color: #000 !important;
            }

            .print-border {
                border-color: #000 !important;
            }
        }
    </style>
</head>

<body class="bg-slate-100 p-4 md:p-12 text-slate-800">

    <div
        class="max-w-3xl mx-auto no-print mb-6 flex justify-between items-center bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <a href="{{ route('prescriptions.index') }}"
            class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
            ← Back to Archive
        </a>
        <button onclick="window.print()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all shadow-sm">
            🖨️ Print Document / Export PDF
        </button>
    </div>

    <div
        class="max-w-3xl mx-auto bg-white p-12 rounded-xl border border-slate-200 shadow-md min-h-[10in] flex flex-col justify-between print-border">
        <div>
            <div class="flex justify-between items-start border-b-2 border-slate-900 pb-6 mb-6 print-border">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">DR. JOHN DOE, MD</h1>
                    <p class="text-xs uppercase font-bold tracking-wider text-indigo-600">Cardiology & Internal Medicine
                    </p>
                    <p class="text-xs text-slate-400">BMDC Registration Licence: #98765A</p>
                </div>
                <div class="text-right text-xs text-slate-500 leading-relaxed">
                    <p class="font-bold text-slate-800">Metro Health Complex</p>
                    <p>Clinical Wing Alpha, Tower B</p>
                    <p>Dhaka, Bangladesh</p>
                    <p>Tel Contact: +88019000000</p>
                </div>
            </div>

            <div
                class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs grid grid-cols-4 gap-4 mb-8 print-border">
                <div>
                    <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Patient
                        Name</span>
                    <strong class="text-slate-900 text-sm">{{ $prescription->patient->name }}</strong>
                </div>
                <div>
                    <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Age /
                        Sex</span>
                    <span class="text-slate-800 font-medium">{{ $prescription->patient->age }} Years /
                        {{ $prescription->patient->gender }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Vitals
                        Map</span>
                    <span class="text-slate-800 font-medium">BP: {{ $prescription->blood_pressure ?? 'N/A' }} | Wt:
                        {{ $prescription->weight ?? 'N/A' }}kg</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Date
                        Issued</span>
                    <span class="text-slate-800 font-medium">{{ $prescription->created_at->format('Y-m-d') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-4 border-r border-slate-100 pr-4 print-border space-y-6">
                    <div>
                        <h4 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Chief Complaints</h4>
                        <p class="text-xs text-slate-800 whitespace-pre-line leading-relaxed">
                            {{ $prescription->chief_complaints }}</p>
                    </div>
                    @if ($prescription->medical_history)
                        <div>
                            <h4 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">History/Allergies
                            </h4>
                            <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                                {{ $prescription->medical_history }}</p>
                        </div>
                    @endif
                </div>

                <div class="col-span-8 pl-4">
                    <span class="text-4xl font-serif font-black text-slate-900 block mb-4 select-none">Rₓ</span>

                    <ol class="space-y-4 text-sm list-decimal pl-5 text-slate-900 font-semibold">
                        @foreach ($prescription->items as $item)
                            <li class="pl-2">
                                <div class="text-sm font-bold text-slate-900">{{ $item->medicine_name }}</div>
                                <div class="text-xs text-slate-500 font-normal mt-0.5">
                                    {{ $item->dosage }} — <span
                                        class="italic text-slate-400">{{ $item->timing }}</span> for <span
                                        class="text-slate-700 font-medium">{{ $item->duration }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ol>

                    @if ($prescription->advice)
                        <div class="mt-8 border-t border-dashed pt-4 print-border">
                            <h4 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Doctor's Advice &
                                Care Plans</h4>
                            <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                                {{ $prescription->advice }}</p>
                        </div>
                    @endif

                    @if ($prescription->next_follow_up)
                        <div class="mt-6 text-xs text-slate-500">
                            <strong>📅 Return Clinic Date:</strong>
                            {{ \Carbon\Carbon::parse($prescription->next_follow_up)->format('F d, Y') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div
            class="border-t border-slate-100 pt-6 mt-12 flex justify-between items-end print-border text-[10px] text-slate-400 font-mono tracking-wide">
            <div>System Verification Token ID:
                AUTH-PR-{{ $prescription->id }}-{{ $prescription->created_at->timestamp }}</div>
            <div
                class="text-right border-t border-slate-300 pt-4 w-40 text-center font-sans font-bold text-slate-600 print-border">
                Authorized Signature</div>
        </div>
    </div>

</body>

</html>
