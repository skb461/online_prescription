{{--
    ╔══════════════════════════════════════════════════════════════╗
    ║  resources/views/prescriptions/create.blade.php              ║
    ║  Pure PHP/Blade — zero JS state management                   ║
    ║  All selections stored in Laravel Session via POST forms     ║
    ╚══════════════════════════════════════════════════════════════╝

    SESSION KEYS USED:
      rx_patient        – array {name, age, gender, phone}
      rx_complaints     – array of {name, duration}
      rx_examinations   – array of {name, value}
      rx_diagnoses      – array of strings
      rx_investigations – array of {name, result}
      rx_advices        – array of strings
      rx_medicines      – array of {name, dosage, timing, duration, instruction}
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RxMaster – Create Prescription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                margin: .4in;
            }

            body * {
                visibility: hidden;
            }

            #print-prescription-viewport,
            #print-prescription-viewport * {
                visibility: visible;
            }

            #print-prescription-viewport {
                position: absolute;
                left: 0;
                top: 0;
                width: 10in;
                background: white !important;
                color: #000 !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-800 min-h-screen flex">

    {{-- ══════════════ SIDEBAR ══════════════ --}}
    <aside class="w-64 bg-slate-900 text-slate-200 flex flex-col fixed inset-y-0 left-0 z-40 shadow-xl no-print">
        <div class="p-5 border-b border-slate-800 flex items-center space-x-2">
            <span class="text-2xl">🩺</span>
            <span class="text-xl font-black tracking-tight text-white">RxMaster Pro</span>
        </div>

        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <a href="{{ route('prescriptions.create') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 
                {{ request()->routeIs('prescriptions.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>📝</span>
                <span class="font-semibold text-sm">Create Prescription</span>
            </a>

            <a href="{{ route('prescriptions.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 
                {{ request()->routeIs('prescriptions.index') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>📋</span>
                <span class="font-semibold text-sm">Prescriptions Log</span>
            </a>

            <div class="pt-4 pb-2 border-t border-slate-800 my-2">
                <span class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Registry</span>
            </div>

            <a href="{{ route('patients.create') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 
                {{ request()->routeIs('patients.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>👤</span>
                <span class="font-semibold text-sm">Register Patient</span>
            </a>

            <a href="{{ route('patients.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 
                {{ request()->routeIs('patients.index') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>👥</span>
                <span class="font-semibold text-sm">View All Patients</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 text-[11px] font-medium text-slate-500 text-center tracking-wide">
            {{ $doctor->doctors_name ?? 'Logged in as Doctor' }}
        </div>
    </aside>

    {{-- ══════════════ MAIN ══════════════ --}}

    {{-- Convenience: read session arrays once --}}
    @php
        $rxPatient = session('rx_patient', []);
        $rxComplaints = session('rx_complaints', []);
        $rxExaminations = session('rx_examinations', []);
        $rxDiagnoses = session('rx_diagnoses', []);
        $rxInvestigations = session('rx_investigations', []);
        $rxAdvices = session('rx_advices', []);
        $rxMedicines = session('rx_medicines', []);

        // Which modal should open on load (set via redirect->with)
        $openModal = session('open_modal', '');
    @endphp

    {{-- ── Flash messages ── --}}
    @if (session('success'))
        <div
            class="fixed top-4 right-4 z-50 bg-emerald-600 text-white px-6 py-3 rounded-2xl shadow-xl font-bold text-sm no-print">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            class="fixed top-4 right-4 z-50 bg-rose-600 text-white px-6 py-3 rounded-2xl shadow-xl font-bold text-sm no-print">
            ❌ {{ session('error') }}
        </div>
    @endif

    <main class="flex-1 pl-64 min-w-0 no-print">
        <div class="p-8 max-w-[1600px] mx-auto">

            {{-- ── Patient Banner ── --}}
            <div
                class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-sm">
                <div class="flex items-center space-x-6">
                    <div class="h-12 w-12 bg-indigo-50 rounded-xl flex items-center justify-center text-xl">👤</div>
                    <div>
                        <label
                            class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Active
                            Consultation</label>
                        <span class="text-lg font-extrabold text-slate-900 tracking-tight">
                            {{ $rxPatient['name'] ?? '— Select Patient —' }}
                        </span>
                    </div>
                    @if (!empty($rxPatient['name']))
                        <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                            <span class="text-sm text-slate-600 font-semibold bg-slate-100 px-4 py-1 rounded-full">
                                {{ $rxPatient['age'] }} Yrs | {{ $rxPatient['gender'] }}
                            </span>
                        </div>
                    @endif
                    <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                        <span class="text-xs text-slate-400 font-mono">📅 {{ date('d M, Y') }}</span>
                    </div>
                </div>
                {{-- Opens patient modal --}}
                <a href="#modal-patient"
                    class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all">
                    Manage Patients ⚙️
                </a>
            </div>

            <div class="grid grid-cols-12 gap-8 items-start">

                {{-- ══════════════ LEFT PANEL ══════════════ --}}
                <div class="col-span-12 lg:col-span-4 space-y-4">

                    {{-- Module Buttons — each is a link to the modal anchor --}}
                    <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription
                            Modules</h3>

                        @php
                            $modules = [
                                [
                                    'modal' => 'modal-complaints',
                                    'icon' => '🤢',
                                    'color' => 'amber',
                                    'label' => 'Patient Complaints',
                                    'count' => count($rxComplaints),
                                ],
                                [
                                    'modal' => 'modal-examination',
                                    'icon' => '🩺',
                                    'color' => 'blue',
                                    'label' => 'On Examination',
                                    'count' => count($rxExaminations),
                                ],
                                [
                                    'modal' => 'modal-diagnosis',
                                    'icon' => '🎯',
                                    'color' => 'rose',
                                    'label' => 'Diagnosis / Impressions',
                                    'count' => count($rxDiagnoses),
                                ],
                                [
                                    'modal' => 'modal-investigation',
                                    'icon' => '🔬',
                                    'color' => 'purple',
                                    'label' => 'Investigations & Tests',
                                    'count' => count($rxInvestigations),
                                ],
                                [
                                    'modal' => 'modal-medicine',
                                    'icon' => '💊',
                                    'color' => 'indigo',
                                    'label' => 'Rₓ Medication Plan',
                                    'count' => count($rxMedicines),
                                ],
                                [
                                    'modal' => 'modal-advice',
                                    'icon' => '🍏',
                                    'color' => 'emerald',
                                    'label' => 'Advices & Diet Plans',
                                    'count' => count($rxAdvices),
                                ],
                            ];
                        @endphp

                        @foreach ($modules as $mod)
                            <a href="#{{ $mod['modal'] }}"
                                class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all group shadow-sm mb-2.5 block">
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="p-2 bg-{{ $mod['color'] }}-50 rounded-lg text-{{ $mod['color'] }}-600">{{ $mod['icon'] }}</span>
                                    <span>{{ $mod['label'] }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($mod['count'] > 0)
                                        <span
                                            class="text-[10px] bg-emerald-100 text-emerald-700 font-black px-2 py-0.5 rounded-full">{{ $mod['count'] }}</span>
                                    @endif
                                    <span
                                        class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold">⊕</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Clear session button --}}
                    <form method="POST" action="{{ route('prescriptions.clearSession') }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Clear all selections and start fresh?')"
                            class="w-full py-2 text-xs font-bold text-slate-400 hover:text-rose-600 border border-slate-200 hover:border-rose-300 rounded-xl transition-all">
                            🗑 Clear All & Start Over
                        </button>
                    </form>
                </div>

                {{-- ══════════════ RIGHT PANEL — Live Canvas ══════════════ --}}
                <div
                    class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[750px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                    </div>

                    <div>
                        {{-- Doctor Header --}}
                        <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                            <div>
                                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                                    {{ strtoupper($doctor->doctors_name) }}</h2>
                                <p class="text-[10px] uppercase font-bold tracking-widest text-slate-400 mt-0.5">
                                    {{ $doctor->doctors_designations ?? '' }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold">
                                    {{ $doctor->doctors_speciality ?? '' }}</p>
                                <p class="text-[10px] text-slate-300 font-medium">BMDC:
                                    {{ $doctor->doctor_bmdc_registration_number ?? '' }}</p>
                            </div>
                            <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                                <p class="font-bold text-slate-700">{{ $doctor->doctors_department ?? '' }}</p>
                                <p>{{ $doctor->doctors_address ?? '' }}</p>
                            </div>
                        </div>

                        {{-- Patient strip --}}
                        <div
                            class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                            <p><strong>Patient Name:</strong> <span
                                    class="text-slate-900 font-bold">{{ $rxPatient['name'] ?? '—' }}</span></p>
                            <p><strong>Demographics:</strong> <span
                                    class="text-slate-900 font-medium">{{ isset($rxPatient['age']) ? $rxPatient['age'] . ' Yrs | ' . $rxPatient['gender'] : '—' }}</span>
                            </p>
                        </div>

                        <div class="mb-6">
                            <span
                                class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                        </div>

                        {{-- Clinical columns --}}
                        <div class="grid grid-cols-12 gap-6 items-start">
                            <div class="col-span-4 space-y-5 border-r border-slate-100 pr-4 min-h-[400px]">

                                @if (count($rxComplaints) > 0)
                                    <div>
                                        <h4
                                            class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">
                                            Complaints</h4>
                                        @foreach ($rxComplaints as $c)
                                            <div
                                                class="font-bold text-slate-900 text-xs py-0.5 flex justify-between items-center group">
                                                <span>• {{ $c['name'] }} ({{ $c['duration'] }})</span>
                                                <form method="POST" action="{{ route('prescriptions.removeItem') }}"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="type" value="complaints">
                                                    <input type="hidden" name="name" value="{{ $c['name'] }}">
                                                    <button type="submit"
                                                        class="text-rose-400 hover:text-rose-600 opacity-0 group-hover:opacity-100 text-[10px] ml-1">✕</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if (count($rxDiagnoses) > 0)
                                    <div>
                                        <h4
                                            class="text-[10px] font-black uppercase tracking-wider text-rose-500 mb-1.5">
                                            Diagnosis</h4>
                                        @foreach ($rxDiagnoses as $d)
                                            <div
                                                class="text-slate-900 py-0.5 text-xs font-extrabold italic flex justify-between items-center group">
                                                <span>• Provisional Dx: <span
                                                        class="text-rose-600">{{ $d }}</span></span>
                                                <form method="POST" action="{{ route('prescriptions.removeItem') }}"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="type" value="diagnoses">
                                                    <input type="hidden" name="name" value="{{ $d }}">
                                                    <button type="submit"
                                                        class="text-rose-400 hover:text-rose-600 opacity-0 group-hover:opacity-100 text-[10px] ml-1">✕</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if (count($rxExaminations) > 0)
                                    <div>
                                        <h4
                                            class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">
                                            On Examination</h4>
                                        @foreach ($rxExaminations as $e)
                                            <div
                                                class="text-slate-800 py-0.5 text-xs font-bold flex justify-between items-center group">
                                                <span>• {{ $e['name'] }}: <span
                                                        class="text-indigo-600">{{ $e['value'] }}</span></span>
                                                <form method="POST" action="{{ route('prescriptions.removeItem') }}"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="type" value="examinations">
                                                    <input type="hidden" name="name"
                                                        value="{{ $e['name'] }}">
                                                    <button type="submit"
                                                        class="text-rose-400 hover:text-rose-600 opacity-0 group-hover:opacity-100 text-[10px] ml-1">✕</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if (count($rxInvestigations) > 0)
                                    <div>
                                        <h4
                                            class="text-[10px] font-black uppercase tracking-wider text-purple-400 mb-1.5">
                                            Investigations</h4>
                                        @foreach ($rxInvestigations as $i)
                                            <div
                                                class="text-slate-900 py-0.5 text-xs font-bold flex justify-between items-center group">
                                                <span>• {{ $i['name'] }} <span
                                                        class="text-purple-600 font-medium">[{{ $i['result'] }}]</span></span>
                                                <form method="POST" action="{{ route('prescriptions.removeItem') }}"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="type" value="investigations">
                                                    <input type="hidden" name="name"
                                                        value="{{ $i['name'] }}">
                                                    <button type="submit"
                                                        class="text-rose-400 hover:text-rose-600 opacity-0 group-hover:opacity-100 text-[10px] ml-1">✕</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="col-span-8 pl-2 space-y-6">
                                @if (count($rxMedicines) > 0)
                                    <ol class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm">
                                        @foreach ($rxMedicines as $idx => $med)
                                            <li class="mb-1 pl-1">
                                                <div
                                                    class="text-sm font-extrabold flex justify-between items-start group">
                                                    <span>{{ $med['name'] }}</span>
                                                    <form method="POST"
                                                        action="{{ route('prescriptions.removeItem') }}"
                                                        class="inline ml-2">
                                                        @csrf
                                                        <input type="hidden" name="type" value="medicines">
                                                        <input type="hidden" name="index"
                                                            value="{{ $idx }}">
                                                        <button type="submit"
                                                            class="text-rose-400 hover:text-rose-600 opacity-0 group-hover:opacity-100 text-[10px]">✕</button>
                                                    </form>
                                                </div>
                                                <div class="text-xs text-slate-500 font-medium mt-0.5">
                                                    <span class="text-slate-800 font-bold">{{ $med['dosage'] }}</span>
                                                    — <span
                                                        class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">{{ $med['timing'] }}</span>
                                                    — <span
                                                        class="text-indigo-600 font-extrabold">{{ $med['duration'] }}</span>
                                                    @if (!empty($med['instruction']))
                                                        <br><span
                                                            class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg mt-1 inline-block">{{ $med['instruction'] }}</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <p class="text-slate-300 italic text-xs pl-2 pt-2">No active medications
                                        compiled...</p>
                                @endif

                                @if (count($rxAdvices) > 0)
                                    <div class="border-t border-dashed border-slate-200 pt-4">
                                        <h4
                                            class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">
                                            Therapeutic Instructions</h4>
                                        <ul class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs">
                                            @foreach ($rxAdvices as $adv)
                                                <li class="flex justify-between items-center group">
                                                    <span>{{ $adv }}</span>
                                                    <form method="POST"
                                                        action="{{ route('prescriptions.removeItem') }}"
                                                        class="inline">
                                                        @csrf
                                                        <input type="hidden" name="type" value="advices">
                                                        <input type="hidden" name="name"
                                                            value="{{ $adv }}">
                                                        <button type="submit"
                                                            class="text-rose-400 hover:text-rose-600 opacity-0 group-hover:opacity-100 text-[10px] ml-2">✕</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-6">
                        <form method="POST" action="{{ route('prescriptions.store') }}" class="inline">
                            @csrf
                            <input type="hidden" name="source" value="session">
                            <button type="submit"
                                class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                                Save Record 💾
                            </button>
                        </form>
                        <a href="{{ route('prescriptions.printPreview') }}"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md">
                            Print + Finalize 🖨️
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- ══════════════════════════════════════════════════════════
     MODALS — CSS :target based, no JS needed
     Each modal is a full-screen overlay triggered by <a href="#modal-id">
══════════════════════════════════════════════════════════ --}}

    {{-- ── Patient Modal ── --}}
    <div id="modal-patient"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
     opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 max-h-[85vh]">

            {{-- Register new patient --}}
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-indigo-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4">
                    <span>✨</span><span>Register New Patient</span>
                </h3>
                <form method="POST" action="{{ route('prescriptions.setPatient') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full
                            Name</label>
                        <input type="text" name="patient_name" placeholder="e.g. Md Ariful Islam" required
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age</label>
                            <input type="number" name="patient_age" placeholder="25" required min="0"
                                max="150"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select name="patient_gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone</label>
                        <input type="text" name="patient_phone" placeholder="01700000000"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all">
                        Save &amp; Activate Profile
                    </button>
                </form>
            </div>

            {{-- Select existing patient --}}
            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-400 text-sm uppercase tracking-wider">Switch Patient Profile</h3>
                    <a href="#"
                        class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
                </div>
                <input type="text" placeholder="🔍 Search patient..." id="pt-search"
                    oninput="document.querySelectorAll('.pt-card').forEach(c=>c.style.display=c.dataset.name.includes(this.value.toLowerCase())?'':'none')"
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div class="flex-1 overflow-y-auto space-y-2 pr-1">
                    @forelse($patients as $pt)
                        <form method="POST" action="{{ route('prescriptions.setPatient') }}" class="pt-card"
                            data-name="{{ strtolower($pt->patient_name) }}">
                            @csrf
                            <input type="hidden" name="patient_name" value="{{ $pt->patient_name }}">
                            <input type="hidden" name="patient_age" value="{{ $pt->patient_age }}">
                            <input type="hidden" name="patient_gender" value="{{ $pt->patient_gender }}">
                            <input type="hidden" name="patient_phone" value="{{ $pt->patient_phone_number }}">
                            <button type="submit"
                                class="w-full text-left p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl hover:border-indigo-400 transition-all">
                                <h4 class="text-xs font-bold text-slate-900">{{ $pt->patient_name }}</h4>
                                <p class="text-[10px] text-slate-400 font-medium">
                                    Age: {{ $pt->patient_age }} • {{ $pt->patient_gender }}
                                    {{ $pt->patient_phone_number ? ' • ' . $pt->patient_phone_number : '' }}
                                </p>
                            </button>
                        </form>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-8">No patients registered yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ── Complaints Modal ── --}}
    <div id="modal-complaints"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
     opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span>🤢</span><span>Select Patient Complaints</span>
                </h3>
                <a href="#"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="Search complaints..."
                    oninput="document.querySelectorAll('.badge-complaint').forEach(b=>b.style.display=b.dataset.name.includes(this.value.toLowerCase())?'':'none')"
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium">
            </div>
            <form method="POST" action="{{ route('prescriptions.addComplaint') }}"
                class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                @csrf
                <div class="flex flex-wrap gap-2">
                    @foreach ($complaints as $c)
                        <label class="badge-complaint cursor-pointer select-none"
                            data-name="{{ strtolower($c->complaint_name) }}">
                            <input type="radio" name="complaint_name" value="{{ $c->complaint_name }}"
                                class="sr-only peer">
                            <span
                                class="block bg-slate-50 hover:bg-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-sm">
                                {{ $c->complaint_name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Duration</span>
                    <input type="text" name="complaint_duration" placeholder="e.g. 3 days" value="3 days"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none">
                    <div class="flex flex-wrap gap-1.5">
                        @foreach (['3 days', '5 days', '7 days', '10 days', '1 month', 'চলবে'] as $d)
                            <button type="button"
                                onclick="this.closest('form').querySelector('[name=complaint_duration]').value='{{ $d }}'"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm">{{ $d }}</button>
                        @endforeach
                    </div>
                </div>
                {{-- Custom complaint --}}
                <div class="flex gap-2 pt-2 border-t border-slate-100">
                    <input type="text" name="custom_complaint_name" placeholder="Add Custom Complaint..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm flex-1">
                    <span class="text-[10px] text-slate-400 self-center">(or select above)</span>
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                    <a href="#"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Examination Modal ── --}}
    <div id="modal-examination"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
     opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2"><span>🩺</span><span>On
                        Examination Diagnostics</span></h3>
                <a href="#"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
            </div>
            <form method="POST" action="{{ route('prescriptions.addExamination') }}"
                class="p-6 overflow-y-auto flex-1 space-y-5 bg-white">
                @csrf
                <div class="flex flex-wrap gap-2">
                    @foreach ($examinations as $ex)
                        <label class="cursor-pointer select-none">
                            <input type="radio" name="examination_name" value="{{ $ex->examination_name }}"
                                class="sr-only peer">
                            <span
                                class="block bg-slate-50 hover:bg-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white border border-slate-200/80 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-sm">
                                {{ $ex->examination_name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Value / Finding</span>
                    <input type="text" name="examination_value" placeholder="e.g. 120/70"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none">
                    <div class="flex flex-wrap gap-1.5">
                        @foreach (['120/70', '130/80', '98.6°F', '80 bpm', 'Normal', 'Elevated'] as $m)
                            <button type="button"
                                onclick="this.closest('form').querySelector('[name=examination_value]').value='{{ $m }}'"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm">{{ $m }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-2 pt-2 border-t border-slate-100">
                    <input type="text" name="custom_examination_name" placeholder="Custom Exam Name..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none font-medium shadow-sm flex-1">
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                    <a href="#"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Diagnosis Modal ── --}}
    <div id="modal-diagnosis"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
     opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span>🎯</span><span>Select Clinical Diagnosis</span>
                </h3>
                <a href="#"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
            </div>
            <form method="POST" action="{{ route('prescriptions.addDiagnosis') }}"
                class="p-6 overflow-y-auto flex-1 bg-white space-y-4">
                @csrf
                <div class="flex flex-wrap gap-2">
                    @foreach ($diagnoses as $diag)
                        <label class="cursor-pointer select-none">
                            <input type="checkbox" name="diagnosis_names[]" value="{{ $diag->diagnosis_name }}"
                                class="sr-only peer"
                                {{ in_array($diag->diagnosis_name, $rxDiagnoses) ? 'checked' : '' }}>
                            <span
                                class="block bg-slate-50 border border-slate-200/80 text-slate-700 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm">
                                {{ $diag->diagnosis_name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="flex gap-2 pt-2 border-t border-slate-100">
                    <input type="text" name="custom_diagnosis_name" placeholder="Type custom diagnosis..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none font-medium shadow-sm flex-1">
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                    <a href="#"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Diagnosis</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Investigation Modal ── --}}
    <div id="modal-investigation"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
     opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span>🔬</span><span>Investigations &amp; Lab Tests</span>
                </h3>
                <a href="#"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
            </div>
            <form method="POST" action="{{ route('prescriptions.addInvestigation') }}"
                class="p-6 overflow-y-auto flex-1 space-y-5 bg-white">
                @csrf
                <div class="flex flex-wrap gap-2">
                    @foreach ($investigations as $inv)
                        <label class="cursor-pointer select-none">
                            <input type="radio" name="investigation_name" value="{{ $inv->investigation_name }}"
                                class="sr-only peer">
                            <span
                                class="block bg-slate-50 hover:bg-purple-600 peer-checked:bg-purple-600 peer-checked:text-white border border-slate-200/80 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-sm">
                                {{ $inv->investigation_name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Result / Value</span>
                    <input type="text" name="investigation_result" placeholder="e.g. High / 7.2 mg/dL"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none">
                </div>
                <div class="flex gap-2 pt-2 border-t border-slate-100">
                    <input type="text" name="custom_investigation_name" placeholder="Add custom test..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none font-medium shadow-sm flex-1">
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                    <a href="#"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</a>
                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Test</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Medicine Modal ── --}}
    {{-- <div id="modal-medicine"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
     opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2"><span>💊</span><span>Rₓ
                        Medication Scheduler</span></h3>
                <a href="#"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
            </div>
            <form method="POST" action="{{ route('prescriptions.addMedicine') }}"
                class="flex-1 overflow-y-auto grid grid-cols-12">
                @csrf
                
                <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 bg-slate-50/60 overflow-y-auto flex flex-col gap-3">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Medicine Catalog</h4>
                    <input type="text" placeholder="🔍 Search medicine..."
                        oninput="document.querySelectorAll('.med-radio-label').forEach(l=>l.style.display=l.dataset.name.includes(this.value.toLowerCase())?'':'none')"
                        class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none font-medium shadow-sm focus:border-indigo-400">
                    <div class="flex flex-col space-y-1.5 overflow-y-auto flex-1">
                        @foreach ($medicines as $med)
                            <label class="med-radio-label cursor-pointer"
                                data-name="{{ strtolower($med->medicine_name) }}">
                                <input type="radio" name="medicine_name" value="{{ $med->medicine_name }}"
                                    class="sr-only peer">
                                <span
                                    class="flex items-center space-x-2 text-xs text-indigo-600 font-semibold py-2.5 px-3 bg-white peer-checked:bg-indigo-600 peer-checked:text-white rounded-xl border border-slate-100 shadow-sm transition-all">
                                    <span>🗂️</span>
                                    <span>{{ $med->medicine_name }}</span>
                                    @if ($med->medicine_power)
                                        <span class="text-[10px] ml-auto opacity-60">{{ $med->medicine_power }}</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <div class="border-t border-slate-200/80 pt-3">
                        <input type="text" name="custom_medicine_name" placeholder="Custom medicine name..."
                            class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none w-full">
                    </div>
                </div>

                
                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-5 bg-white">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Dose
                            Schedule</label>
                        <div class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60">
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_morning" value="1" checked
                                    class="mb-1.5">সকাল
                            </label>
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_noon" value="1" checked class="mb-1.5">দুপুর
                            </label>
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_night" value="1" checked class="mb-1.5">রাত
                            </label>
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_evening" value="1" class="mb-1.5">বিকাল
                            </label>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            <input type="text" name="dose_qty_morning" value="0"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                            <input type="text" name="dose_qty_noon" value="0"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                            <input type="text" name="dose_qty_night" value="1"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                            <input type="text" name="dose_qty_evening" value="0"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                Relation</label>
                            <select name="medicine_timing"
                                class="w-full border p-3 text-xs font-bold rounded-xl bg-slate-50">
                                <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                            <input type="text" name="medicine_duration" value="চলবে"
                                class="w-full border p-3 text-xs font-bold rounded-xl bg-slate-50">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Instructions</label>
                        <input type="text" name="medicine_instruction" placeholder="e.g. জ্বর থাকলে"
                            class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none shadow-sm">
                    </div>
                    <button type="submit"
                        class="w-full bg-slate-900 text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md">
                        Add to Plan ➕
                    </button>
                </div>
            </form>
        </div>
    </div> --}}

    {{-- ── Medicine Modal ── --}}
    <div id="modal-medicine"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
      opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2"><span>💊</span><span>Rₓ
                        Medication Scheduler</span></h3>
                <a href="#"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
            </div>
            <form method="POST" action="{{ route('prescriptions.addMedicine') }}"
                class="flex-1 overflow-y-auto grid grid-cols-12">
                @csrf
                {{-- Left: catalog --}}
                {{-- <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 bg-slate-50/60 overflow-y-auto flex flex-col gap-3">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Medicine Catalog</h4>

                    <input type="text" placeholder="🔍 Search medicine..."
                        oninput="
                            let container = document.getElementById('api-med-list');
                            if (!this.value.trim()) return;
                            fetch(`https://portal.proyashealthcare.com/load-medicine-list?name=${encodeURIComponent(this.value)}`)
                                .then(res => res.json())
                                .then(data => {
                                    container.innerHTML = '';
                                    data.forEach(med => {
                                        let name = med.medicine_name || med.name || med;
                                        let power = med.medicine_power || '';
                                        container.insertAdjacentHTML('beforeend', `
                                            <label class='med-radio-label cursor-pointer'>
                                                <input type='radio' name='medicine_name' value='${name}' class='sr-only peer'>
                                                <span class='flex items-center space-x-2 text-xs text-indigo-600 font-semibold py-2.5 px-3 bg-white peer-checked:bg-indigo-600 peer-checked:text-white rounded-xl border border-slate-100 shadow-sm transition-all'>
                                                    <span>🗂️</span>
                                                    <span>${name}</span>
                                                    ${power ? `<span class='text-[10px] ml-auto opacity-60'>${power}</span>` : ''}
                                                </span>
                                            </label>
                                        `);
                                    });
                                }).catch(err => console.error(err));
                        "
                        class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none font-medium shadow-sm focus:border-indigo-400">

                    <div id="api-med-list" class="flex flex-col space-y-1.5 overflow-y-auto flex-1">
                        @foreach ($medicines as $med)
                            <label class="med-radio-label cursor-pointer"
                                data-name="{{ strtolower($med->medicine_name) }}">
                                <input type="radio" name="medicine_name" value="{{ $med->medicine_name }}"
                                    class="sr-only peer">
                                <span
                                    class="flex items-center space-x-2 text-xs text-indigo-600 font-semibold py-2.5 px-3 bg-white peer-checked:bg-indigo-600 peer-checked:text-white rounded-xl border border-slate-100 shadow-sm transition-all">
                                    <span>🗂️</span>
                                    <span>{{ $med->medicine_name }}</span>
                                    @if ($med->medicine_power)
                                        <span class="text-[10px] ml-auto opacity-60">{{ $med->medicine_power }}</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <div class="border-t border-slate-200/80 pt-3">
                        <input type="text" name="custom_medicine_name" placeholder="Custom medicine name..."
                            class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none w-full">
                    </div>
                </div> --}}
                <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 bg-slate-50/60 overflow-y-auto flex flex-col gap-3">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Medicine Catalog</h4>

                    <!-- Search Input and Button Group -->
                    <div class="flex gap-2">
                        <input type="text" placeholder="🔍 Search medicine..." id="live-med-search"
                            oninput="handleMedicineSearch(this.value)"
                            class="flex-1 border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none font-medium shadow-sm focus:border-indigo-400">

                        <button type="button"
                            onclick="handleMedicineSearch(document.getElementById('live-med-search').value)"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-sm cursor-pointer whitespace-nowrap">
                            Search
                        </button>
                    </div>

                    <!-- Live container for template records / API response objects -->
                    <div id="api-med-list" class="flex flex-col space-y-1.5 overflow-y-auto flex-1">
                        {{-- @foreach ($medicines as $med)
                            <label class="med-radio-label cursor-pointer"
                                data-name="{{ strtolower($med->medicine_name) }}">
                                <input type="radio" name="medicine_name" value="{{ $med->medicine_name }}"
                                    class="sr-only peer">
                                <span
                                    class="flex items-center space-x-2 text-xs text-indigo-600 font-semibold py-2.5 px-3 bg-white peer-checked:bg-indigo-600 peer-checked:text-white rounded-xl border border-slate-100 shadow-sm transition-all">
                                    <span>🗂️</span>
                                    <span>{{ $med->medicine_name }}</span>
                                    @if ($med->medicine_power)
                                        <span class="text-[10px] ml-auto opacity-60">{{ $med->medicine_power }}</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach --}}
                        {{-- @dd($medicines); --}}
                    </div>

                    <div class="border-t border-slate-200/80 pt-3">
                        <input type="text" name="custom_medicine_name" placeholder="Custom medicine name..."
                            class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none w-full">
                    </div>
                </div>

                <!-- API Search Script -->
                <script>
                    let medSearchTimeout;
                    let originalMedListHTML = null;

                    function handleMedicineSearch(query) {
                        let container = document.getElementById('api-med-list');

                        // Save the original Blade-rendered list on first search
                        if (originalMedListHTML === null) {
                            originalMedListHTML = container.innerHTML;
                        }

                        query = query.trim();

                        // If input is cleared, restore the original database list
                        if (!query) {
                            container.innerHTML = originalMedListHTML;
                            return;
                        }

                        // Clear previous timeout (Debouncing: waits 400ms after you stop typing before hitting the API)
                        clearTimeout(medSearchTimeout);

                        medSearchTimeout = setTimeout(() => {
                            // Show loading state
                            container.innerHTML =
                                '<div class="text-center py-6 text-xs text-slate-400 font-bold animate-pulse">Searching API...</div>';

                            fetch(`/api/proxy-medicines?name=${encodeURIComponent(query)}`)
                                .then(res => {
                                    if (!res.ok) throw new Error('Network response was not ok');
                                    return res.json();
                                })
                                .then(data => {
                                    container.innerHTML = '';

                                    // Handle case where API might wrap data in an object (e.g., { data: [...] })
                                    let results = Array.isArray(data) ? data : (data.data || []);

                                    if (results.length === 0) {
                                        container.innerHTML =
                                            '<div class="text-center py-6 text-xs text-slate-400 font-bold">No medicines found.</div>';
                                        return;
                                    }

                                    // Render results
                                    results.forEach(med => {
                                        // Attempt to gracefully pull out the name regardless of API structure
                                        let name = med.medicine_name || med.name || med.brand_name || (
                                            typeof med === 'string' ? med : 'Unknown Medicine');
                                        let power = med.medicine_power || med.power || '';

                                        container.insertAdjacentHTML('beforeend', `
                            <label class='med-radio-label cursor-pointer'>
                                <input type='radio' name='medicine_name' value='${name}' class='sr-only peer'>
                                <span class='flex items-center space-x-2 text-xs text-indigo-600 font-semibold py-2.5 px-3 bg-white peer-checked:bg-indigo-600 peer-checked:text-white rounded-xl border border-slate-100 shadow-sm transition-all'>
                                    <span>🗂️</span>
                                    <span>${name}</span>
                                    ${power ? `<span class='text-[10px] ml-auto opacity-60'>${power}</span>` : ''}
                                </span>
                            </label>
                        `);
                                    });
                                })
                                .catch(err => {
                                    console.error('Medicine API Error:', err);
                                    container.innerHTML =
                                        `<div class="text-center py-6 text-xs text-rose-500 font-bold">Failed to load results.<br><span class="opacity-70 font-normal">Check console or network tab.</span></div>`;
                                });
                        }, 400);
                    }
                </script>

                {{-- Right: dose scheduler --}}
                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-5 bg-white">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Dose
                            Schedule</label>
                        <div class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60">
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_morning" value="1" checked
                                    class="mb-1.5">সকাল
                            </label>
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_noon" value="1" checked class="mb-1.5">দুপুর
                            </label>
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_night" value="1" checked class="mb-1.5">রাত
                            </label>
                            <label
                                class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer">
                                <input type="checkbox" name="dose_evening" value="1" class="mb-1.5">বিকাল
                            </label>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            <input type="text" name="dose_qty_morning" value="0"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                            <input type="text" name="dose_qty_noon" value="0"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                            <input type="text" name="dose_qty_night" value="1"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                            <input type="text" name="dose_qty_evening" value="0"
                                class="border text-center p-3 rounded-xl text-xs bg-slate-50">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                Relation</label>
                            <select name="medicine_timing"
                                class="w-full border p-3 text-xs font-bold rounded-xl bg-slate-50">
                                <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                            <input type="text" name="medicine_duration" value="চলবে"
                                class="w-full border p-3 text-xs font-bold rounded-xl bg-slate-50">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Instructions</label>
                        <input type="text" name="medicine_instruction" placeholder="e.g. জ্বর থাকলে"
                            class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none shadow-sm">
                    </div>
                    <button type="submit"
                        class="w-full bg-slate-900 text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md">
                        Add to Plan ➕
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Advice Modal ── --}}
    <div id="modal-advice"
        class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4
     opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-opacity">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span>🍏</span><span>Dietary &amp; Care Advices</span>
                </h3>
                <a href="#"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold">✕</a>
            </div>
            <form method="POST" action="{{ route('prescriptions.addAdvice') }}"
                class="p-6 overflow-y-auto flex-1 space-y-4 bg-white">
                @csrf
                <div class="flex flex-wrap gap-2.5">
                    @foreach ($advices as $adv)
                        <label class="cursor-pointer select-none">
                            <input type="checkbox" name="advice_names[]" value="{{ $adv->advice_name }}"
                                class="sr-only peer" {{ in_array($adv->advice_name, $rxAdvices) ? 'checked' : '' }}>
                            <span
                                class="block bg-slate-50 border border-slate-200/80 text-slate-700 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm">
                                {{ $adv->advice_name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="flex gap-2 pt-2 border-t border-slate-100">
                    <input type="text" name="custom_advice" placeholder="Type custom advice..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none font-medium shadow-sm flex-1">
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                    <a href="#"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Advice</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════ PRINT VIEW ══════════════ --}}
    {{-- Only rendered when route('prescriptions.printPreview') redirects here with ?print=1 --}}
    @if (request('print') == 1)
        <div class="min-h-screen w-full bg-white flex flex-col items-center justify-start p-10 relative">
            <div
                class="w-full max-w-[11in] flex justify-between items-center bg-slate-900 text-white p-4 rounded-2xl shadow-xl mb-8 no-print">
                <div class="flex items-center space-x-3">
                    <span class="text-xl">📄</span>
                    <h3 class="text-sm font-black">Prescription Print Preview</h3>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('prescriptions.create') }}"
                        class="px-4 py-2 border border-slate-700 text-xs font-bold rounded-xl text-slate-300 hover:text-white hover:bg-slate-800">
                        ← Return to Editor
                    </a>
                    <button onclick="window.print()"
                        class="px-5 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md">
                        Execute Print 🖨️
                    </button>
                </div>
            </div>

            <div id="print-prescription-viewport"
                class="w-[11in] h-[8in] bg-white border border-slate-300 p-[0.5in] flex flex-col justify-between relative text-black leading-normal">
                <div>
                    <div class="flex justify-between items-start border-b-4 border-slate-900 pb-4 mb-4">
                        <div>
                            <h2 class="text-2xl font-black tracking-tight">{{ strtoupper($doctor->doctors_name) }}
                            </h2>
                            <p class="text-[11px] font-bold text-slate-700 font-mono">
                                {{ $doctor->doctors_designations ?? '' }}</p>
                            <p class="text-[10px] font-bold text-slate-500">{{ $doctor->doctors_speciality ?? '' }}
                            </p>
                            <p class="text-[10px] text-slate-400 font-mono">{{ $doctor->doctors_department ?? '' }}
                            </p>
                        </div>
                        <div class="text-right text-[11px] font-medium leading-relaxed">
                            <p class="font-extrabold text-sm text-slate-950">{{ $doctor->doctors_address ?? '' }}</p>
                            <p class="text-slate-400 font-mono text-[10px]">{{ $doctor->doctors_phone_number ?? '' }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="border-2 border-slate-900 bg-slate-900 text-white px-4 py-2 rounded-lg grid grid-cols-4 gap-4 text-xs font-bold tracking-wide mb-6">
                        <p>Name: <span class="font-normal underline ml-1">{{ $rxPatient['name'] ?? '—' }}</span></p>
                        <p>Age: <span class="font-normal ml-1">{{ $rxPatient['age'] ?? '—' }} yrs</span></p>
                        <p>Sex: <span class="font-normal ml-1">{{ $rxPatient['gender'] ?? '—' }}</span></p>
                        <p class="text-right">Date: <span
                                class="font-mono font-normal ml-1">{{ date('Y-m-d') }}</span></p>
                    </div>

                    <div class="grid grid-cols-12 gap-6 items-start">
                        <div class="col-span-4 space-y-5 border-r-2 border-slate-900 pr-4 min-h-[4.5in]">
                            @if (count($rxComplaints) > 0)
                                <div>
                                    <h4 class="text-xs font-black uppercase text-slate-500 mb-1 font-mono">C/C:</h4>
                                    @foreach ($rxComplaints as $c)
                                        <div class="text-xs font-bold py-0.5">• {{ $c['name'] }}
                                            ({{ $c['duration'] }})
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if (count($rxDiagnoses) > 0)
                                <div>
                                    <h4 class="text-xs font-black uppercase text-slate-500 mb-1 font-mono">Provisional
                                        Dx:</h4>
                                    @foreach ($rxDiagnoses as $d)
                                        <div class="text-xs font-black italic py-0.5">• {{ $d }}</div>
                                    @endforeach
                                </div>
                            @endif
                            @if (count($rxExaminations) > 0)
                                <div>
                                    <h4 class="text-xs font-black uppercase text-slate-500 mb-1 font-mono">O/E:</h4>
                                    @foreach ($rxExaminations as $e)
                                        <div class="text-xs font-bold py-0.5">• {{ $e['name'] }}:
                                            {{ $e['value'] }}</div>
                                    @endforeach
                                </div>
                            @endif
                            @if (count($rxInvestigations) > 0)
                                <div>
                                    <h4 class="text-xs font-black uppercase text-slate-500 mb-1 font-mono">
                                        Investigations:</h4>
                                    @foreach ($rxInvestigations as $i)
                                        <div class="text-xs font-bold py-0.5">• {{ $i['name'] }}
                                            [{{ $i['result'] }}]</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="col-span-8 pl-4 space-y-6">
                            <div>
                                <span
                                    class="text-4xl font-serif font-black text-slate-950 block mb-4 select-none">Rₓ</span>
                                <ol
                                    class="list-decimal pl-5 font-bold space-y-4 text-slate-950 text-sm leading-normal">
                                    @foreach ($rxMedicines as $med)
                                        <li class="pl-2 mb-2">
                                            <div class="text-sm font-black">{{ $med['name'] }}</div>
                                            <div class="text-xs text-slate-800 font-semibold mt-0.5">
                                                &nbsp;&nbsp;&nbsp;&nbsp;{{ $med['dosage'] }}
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;—
                                                {{ $med['timing'] }} — {{ $med['duration'] }}
                                                @if (!empty($med['instruction']))
                                                    <br>&nbsp;&nbsp;&nbsp;&nbsp;<span
                                                        class="text-xs font-bold italic text-slate-700">{{ $med['instruction'] }}</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                            @if (count($rxAdvices) > 0)
                                <div class="border-t-2 border-dashed border-slate-300 pt-4">
                                    <h4 class="text-xs font-black uppercase text-slate-500 mb-2 font-mono">Adv:</h4>
                                    <ul class="list-disc pl-5 text-slate-800 font-bold space-y-1 text-xs">
                                        @foreach ($rxAdvices as $adv)
                                            <li>{{ $adv }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div
                    class="border-t-2 border-slate-900 pt-4 flex justify-between items-end text-[10px] font-mono tracking-wide text-slate-500">
                    <div>AUTH-{{ time() }}</div>
                    <div
                        class="border-t border-slate-400 pt-4 w-44 text-center font-sans font-bold text-slate-700 text-xs">
                        Medical Practitioner Stamp
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- tiny inline JS — ONLY for the patient search in the modal (not state management) --}}
    <script>
        // Auto-open modal if redirected back to one (e.g. after adding a medicine)
        @if ($openModal)
            window.location.hash = '{{ $openModal }}';
        @endif
    </script>

</body>

</html>
