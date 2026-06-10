{{-- @extends('layouts.app')

@block('content')
    <header class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Prescription Workspace</h1>
        <p class="text-sm text-slate-500">Live operational panel split layout interface mapping active treatment structures.
        </p>
    </header>

    <form action="{{ route('prescriptions.store') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        @csrf

        <div class="xl:col-span-7 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">

            <div>
                <h2 class="text-base font-bold border-b pb-2 mb-4 text-indigo-600 flex items-center space-x-2">
                    <span>①</span> <span>Patient Context Setup</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Select
                            Patient Profile</label>
                        <select name="patient_id" id="patient-select"
                            class="w-full border border-slate-300 rounded-xl p-2.5 bg-slate-50 focus:ring-2 focus:ring-indigo-500 text-sm outline-none"
                            required>
                            <option value="">-- Select Patient --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" data-age="{{ $patient->age }}"
                                    data-gender="{{ $patient->gender }}" data-blood="{{ $patient->blood_group }}">
                                    {{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Blood
                            Pressure</label>
                        <input type="text" name="blood_pressure" id="bp-input" placeholder="120/80 mmHg"
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Weight
                            Value</label>
                        <input type="text" name="weight" id="weight-input" placeholder="70 kg"
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-base font-bold border-b pb-2 mb-4 text-indigo-600 flex items-center space-x-2">
                    <span>②</span> <span>Symptomatology & Diagnostics</span>
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Chief
                            Complaints</label>
                        <textarea name="chief_complaints" id="complaints-input" rows="2"
                            placeholder="Fever x3 days, acute dry throat irritation..."
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                            required></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Historical
                            Medical/Allergy Timeline Context</label>
                        <textarea name="medical_history" rows="2"
                            placeholder="Asthmatic profile history, penicillin sensitivity reactions..."
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h2 class="text-base font-bold text-indigo-600 flex items-center space-x-2">
                        <span>③</span> <span>Medication Prescription (Rₓ Formulation)</span>
                    </h2>
                    <button type="button" id="add-medicine-btn"
                        class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs px-3 py-2 border border-indigo-200 rounded-xl font-bold transition-colors">
                        + Append Item Line
                    </button>
                </div>

                <div id="medicines-container" class="space-y-3">
                    <div
                        class="medicine-row grid grid-cols-12 gap-2 bg-slate-50 p-4 rounded-xl border border-slate-200 relative">
                        <div class="col-span-4">
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Brand/Generic
                                Name</label>
                            <input type="text" name="medicines[0][name]" placeholder="Paracetamol 500mg"
                                class="med-name w-full border border-slate-300 rounded-lg p-1.5 text-xs outline-none focus:bg-white"
                                required>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Dosage
                                Frequency</label>
                            <input type="text" name="medicines[0][dosage]" placeholder="1+0+1"
                                class="med-dose w-full border border-slate-300 rounded-lg p-1.5 text-xs outline-none focus:bg-white"
                                required>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Meal
                                Administration</label>
                            <select name="medicines[0][timing]"
                                class="med-timing w-full border border-slate-300 rounded-lg p-1.5 text-xs bg-white outline-none"
                                required>
                                <option value="After Food">After Food</option>
                                <option value="Before Food">Before Food</option>
                                <option value="With Food">With Food</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Duration</label>
                            <input type="text" name="medicines[0][duration]" placeholder="5 Days"
                                class="med-dur w-full border border-slate-300 rounded-lg p-1.5 text-xs outline-none focus:bg-white"
                                required>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-base font-bold border-b pb-2 mb-4 text-indigo-600 flex items-center space-x-2">
                    <span>④</span> <span>Doctor Advice & Follow-up Matrix</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Therapeutic
                            Lifestyle Advice</label>
                        <textarea name="advice" rows="2" placeholder="Strict bedrest patterns, minimize direct salt intake..."
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Next Clinic
                            Follow-up Recall Date</label>
                        <input type="date" name="next_follow_up"
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-colors text-sm tracking-wide uppercase">
                Compile & Finalize Live Prescription Document
            </button>
        </div>

        <div
            class="xl:col-span-5 bg-white p-8 rounded-2xl shadow-sm border border-slate-200 sticky top-6 h-[calc(100vh-10rem)] overflow-y-auto flex flex-col justify-between">
            <div id="prescription-blueprint">
                <div class="flex justify-between items-start border-b border-slate-900 pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 leading-tight">DR. JOHN DOE, MD</h2>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Cardiology Specialist</p>
                        <p class="text-[9px] text-slate-400">Registry BMDC No: 98765A</p>
                    </div>
                    <div class="text-right text-[10px] text-slate-500 leading-normal">
                        <p class="font-bold">Metro Health Complex</p>
                        <p>Clinical Wing Alpha, Tower B</p>
                        <p>Hotline: +88019000000</p>
                    </div>
                </div>

                <div
                    class="bg-slate-50 p-2.5 rounded-lg border border-slate-200 text-[11px] grid grid-cols-2 gap-y-1.5 text-slate-600 mb-6">
                    <p><strong>Patient:</strong> <span id="view-pt-name" class="text-slate-900 font-medium">No Profile
                            Selected</span></p>
                    <p><strong>Date:</strong> <span class="text-slate-900">{{ date('Y-m-d') }}</span></p>
                    <p><strong>Age/Sex:</strong> <span id="view-pt-meta" class="text-slate-900">—</span></p>
                    <p><strong>BP/Weight:</strong> <span id="view-pt-vitals" class="text-slate-900">—</span></p>
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-4 border-r border-slate-100 pr-2">
                        <h4 class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-2">Complaints</h4>
                        <p id="view-complaints" class="text-xs text-slate-400 italic">No symptoms documented yet...</p>
                    </div>
                    <div class="col-span-8 pl-2">
                        <span class="text-3xl font-serif font-black text-indigo-900 block mb-2">Rₓ</span>
                        <ol id="view-medicines-list"
                            class="space-y-3 text-xs list-decimal pl-4 font-medium text-slate-900">
                            <li class="text-slate-400 italic list-none pl-0">No active medication items added.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4 text-center text-[9px] text-slate-400 tracking-wide font-mono">
                SECURE CLOUD DOCUMENTATION PROTOCOL IDENTIFIER SYSTEM LOG.
            </div>
        </div>
    </form>
@endblock

@block('scripts')
    <script>
        let index = 1;
        const container = document.getElementById('medicines-container');

        // Dynamic Row Creation Engine
        document.getElementById('add-medicine-btn').addEventListener('click', () => {
            const row = `
            <div class="medicine-row grid grid-cols-12 gap-2 bg-slate-50 p-4 rounded-xl border border-slate-200 relative mt-2">
                <div class="col-span-4">
                    <input type="text" name="medicines[${index}][name]" placeholder="Medicine Name" class="med-name w-full border border-slate-300 rounded-lg p-1.5 text-xs outline-none focus:bg-white" required>
                </div>
                <div class="col-span-3">
                    <input type="text" name="medicines[${index}][dosage]" placeholder="1+0+1" class="med-dose w-full border border-slate-300 rounded-lg p-1.5 text-xs outline-none focus:bg-white" required>
                </div>
                <div class="col-span-3">
                    <select name="medicines[${index}][timing]" class="med-timing w-full border border-slate-300 rounded-lg p-1.5 text-xs bg-white outline-none" required>
                        <option value="After Food">After Food</option>
                        <option value="Before Food">Before Food</option>
                        <option value="With Food">With Food</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <input type="text" name="medicines[${index}][duration]" placeholder="7 Days" class="med-dur w-full border border-slate-300 rounded-lg p-1.5 text-xs outline-none focus:bg-white" required>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', row);
            index++;
            bindLivePreviewListeners();
        });

        // Client-side Interface Mirror Event Synchronization System
        function updateLivePreview() {
            const select = document.getElementById('patient-select');
            const selectedOption = select.options[select.selectedIndex];

            document.getElementById('view-pt-name').innerText = selectedOption.value ? selectedOption.text :
                'No Profile Selected';
            document.getElementById('view-pt-meta').innerText = selectedOption.value ?
                `${selectedOption.dataset.age}Y / ${selectedOption.dataset.gender}` : '—';

            const bp = document.getElementById('bp-input').value || '—';
            const weight = document.getElementById('weight-input').value || '—';
            document.getElementById('view-pt-vitals').innerText = `${bp} / ${weight}kg`;

            document.getElementById('view-complaints').innerText = document.getElementById('complaints-input').value ||
                'No symptoms documented yet...';

            const listContainer = document.getElementById('view-medicines-list');
            listContainer.innerHTML = '';

            const rows = document.querySelectorAll('.medicine-row');
            let validItems = 0;

            rows.forEach(row => {
                const name = row.querySelector('.med-name').value;
                const dose = row.querySelector('.med-dose').value;
                const timing = row.querySelector('.med-timing').value;
                const dur = row.querySelector('.med-dur').value;

                if (name) {
                    validItems++;
                    const li = document.createElement('li');
                    li.innerHTML = `
                    <div class="font-bold text-slate-900 text-xs">${name}</div>
                    <div class="text-[11px] text-slate-500 font-normal mt-0.5">${dose} — <span class="italic text-slate-400">${timing}</span> (${dur})</div>
                `;
                    listContainer.appendChild(li);
                }
            });

            if (validItems === 0) {
                listContainer.innerHTML =
                    '<li class="text-slate-400 italic list-none pl-0">No active medication items added.</li>';
            }
        }

        function bindLivePreviewListeners() {
            document.querySelectorAll('input, textarea, select').forEach(element => {
                element.removeEventListener('input', updateLivePreview);
                element.addEventListener('input', updateLivePreview);
            });
        }

        document.getElementById('patient-select').addEventListener('change', updateLivePreview);
        bindLivePreviewListeners();
    </script>
@endblock --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen text-slate-800 -m-8 p-6">
        <div class="bg-white border border-slate-200 rounded-xl p-4 mb-6 flex justify-between items-center shadow-sm">
            <div class="flex items-center space-x-6">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Active Target
                        Patient</label>
                    <span class="text-base font-bold text-slate-900" id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l pl-6">
                    <span class="text-xs text-slate-500 font-medium">22 Years | Male</span>
                </div>
                <div class="border-l pl-6">
                    <span class="text-xs text-slate-400 font-mono">Date: {{ date('d-m-Y') }}</span>
                </div>
            </div>
            <div>
                <select name="patient_id"
                    class="border border-slate-300 bg-slate-50 text-xs rounded-lg p-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                    @foreach ($patients ?? [] as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6 items-start">

            <div class="col-span-3 space-y-2">
                <button type="button" onclick="openModal('complaints-modal')"
                    class="w-full flex justify-between items-center bg-white border border-slate-200 hover:border-indigo-500 p-3.5 rounded-xl font-medium text-sm text-left transition-all shadow-sm">
                    <span>Patient Complaints</span>
                    <span class="text-indigo-600 font-bold text-lg">⊕</span>
                </button>
                <button type="button" onclick="openModal('examination-modal')"
                    class="w-full flex justify-between items-center bg-white border border-slate-200 hover:border-indigo-500 p-3.5 rounded-xl font-medium text-sm text-left transition-all shadow-sm">
                    <span>On Examination</span>
                    <span class="text-indigo-600 font-bold text-lg">⊕</span>
                </button>
                <button type="button" onclick="openModal('medicine-modal')"
                    class="w-full flex justify-between items-center bg-white border border-slate-200 hover:border-indigo-500 p-3.5 rounded-xl font-medium text-sm text-left transition-all shadow-sm">
                    <span class="font-bold text-indigo-900">Rₓ Medication Plan</span>
                    <span class="text-indigo-600 font-bold text-lg">⊕</span>
                </button>
                <button type="button" onclick="openModal('advice-modal')"
                    class="w-full flex justify-between items-center bg-white border border-slate-200 hover:border-indigo-500 p-3.5 rounded-xl font-medium text-sm text-left transition-all shadow-sm">
                    <span>Advices & Care Plans</span>
                    <span class="text-indigo-600 font-bold text-lg">⊕</span>
                </button>
            </div>

            <div
                class="col-span-9 bg-white border border-slate-200 rounded-2xl p-8 min-h-[650px] shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center space-x-2 border-b pb-4 mb-6">
                        <span class="text-3xl font-serif font-black text-slate-900">Rₓ</span>
                    </div>

                    <div class="space-y-6 text-sm">
                        <div id="live-section-complaints" class="hidden">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Patient Complaints
                            </h4>
                            <div id="render-complaints-target" class="text-slate-800 space-y-1 pl-2"></div>
                        </div>

                        <div id="live-section-examination" class="hidden">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Clinical Observations
                                / Examination</h4>
                            <div id="render-examination-target" class="text-slate-800 space-y-1 pl-2"></div>
                        </div>

                        <div id="live-section-medication" class="hidden">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Prescribed Regimen
                            </h4>
                            <ol id="render-medication-target" class="list-decimal pl-5 font-bold space-y-3 text-slate-900">
                            </ol>
                        </div>

                        <div id="live-section-advice" class="hidden">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Doctor Advices</h4>
                            <ul id="render-advice-target" class="list-disc pl-5 text-slate-700 space-y-1"></ul>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 flex justify-end space-x-3 mt-12">
                    <button type="button"
                        class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors uppercase tracking-wider">Update
                        Data</button>
                    <button type="button"
                        class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors uppercase tracking-wider">Update
                        + Print Document</button>
                </div>
            </div>

        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-2xl shadow-xl flex flex-col max-h-[85vh] overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="p-4 border-b flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-900 text-base">Patient Complaints</h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
            </div>
            <div class="p-4 border-b">
                <input type="text" placeholder="Search conditions..."
                    class="w-full border border-slate-200 rounded-xl p-2.5 text-sm bg-slate-50 outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1">
                <div class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag('{{ $tag }}')"
                            class="bg-white hover:bg-indigo-50 border border-slate-200 text-slate-700 text-xs px-3 py-2 rounded-lg transition-all font-medium hover:border-indigo-300 shadow-sm">{{ $tag }}</button>
                    @endforeach
                </div>

                <div id="complaint-duration-builder" class="hidden bg-slate-50 p-4 border rounded-xl space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-indigo-900 uppercase tracking-wide">Configure Duration
                            parameters: <span id="active-complaint-label" class="underline"></span></span>
                    </div>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border p-2 text-xs rounded-lg bg-white" placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '5d', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-indigo-600 text-white hover:bg-indigo-700 text-[10px] font-bold px-2.5 py-1.5 rounded-md transition-all shadow-sm">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4 border-t bg-slate-50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-xs tracking-wide uppercase">Close</button>
                <button type="button" onclick="saveComplaintsPipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg text-xs tracking-wide uppercase shadow">Done</button>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl flex flex-col max-h-[85vh] overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-900 text-base">On Examination Parameters</h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6">
                <div class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag('{{ $exam }}')"
                            class="bg-white hover:bg-indigo-50 border border-slate-200 text-slate-700 text-xs px-3 py-2 rounded-lg font-medium transition-all shadow-sm">{{ $exam }}</button>
                    @endforeach
                </div>

                <div id="exam-value-builder" class="hidden bg-slate-50 p-4 border rounded-xl space-y-3">
                    <span class="text-xs font-bold text-indigo-900 uppercase">Input metrics logic: <span
                            id="active-exam-label" class="underline"></span></span>
                    <input type="text" id="exam-value-input" class="w-full border p-2 text-xs rounded-lg bg-white"
                        placeholder="e.g. 102 F">
                    <div class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-indigo-600 text-white hover:bg-indigo-700 text-[10px] font-bold px-2.5 py-1.5 rounded-md shadow-sm">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4 border-t bg-slate-50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('examination-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-xs uppercase">Close</button>
                <button type="button" onclick="saveExaminationPipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg text-xs uppercase shadow">Done</button>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-5xl rounded-2xl shadow-xl flex flex-col h-[85vh] overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-900 text-base">Add Medication Plan (Rx Layout Engine)</h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div class="col-span-5 border-r p-4 overflow-y-auto bg-slate-50 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Common Custom Catalog Formulary
                    </h4>
                    <div class="flex flex-col space-y-1">
                        @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)', 'Ecosprin (Tablet, 75 mg)']; @endphp
                        @foreach ($drugs as $drug)
                            <button type="button" onclick="stageMedicineItem('{{ $drug }}')"
                                class="text-left text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium py-1 border-b border-slate-200/60 transition-all">•
                                {{ $drug }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-7 p-6 overflow-y-auto space-y-6 bg-white">
                    <div id="med-scheduler-panel" class="hidden space-y-4">
                        <h3 class="text-base font-bold text-slate-900 border-b pb-1.5" id="scheduled-med-title">Tab. Napa
                        </h3>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide">Dosage Frequency
                                Configuration Intervals</label>
                            <div class="flex items-center space-x-4 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                <label class="inline-flex items-center text-xs font-medium"><input type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mr-1"> সকাল (Morning)</label>
                                <label class="inline-flex items-center text-xs font-medium"><input type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mr-1"> দুপুর (Noon)</label>
                                <label class="inline-flex items-center text-xs font-medium"><input type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mr-1"> রাত (Night)</label>
                                <label class="inline-flex items-center text-xs font-medium"><input type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mr-1"> বিকাল (Evening)</label>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border text-center p-1.5 rounded text-xs bg-white">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border text-center p-1.5 rounded text-xs bg-white">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border text-center p-1.5 rounded text-xs bg-white">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border text-center p-1.5 rounded text-xs bg-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border p-2 text-xs rounded-lg bg-white outline-none">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Duration
                                    Cycle</label>
                                <input type="text" id="med-duration-input" value="7 দিন"
                                    class="w-full border p-2 text-xs rounded-lg bg-white">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide">Custom Clinical
                                Instructions</label>
                            <input type="text" id="med-instruction-input" class="w-full border p-2 text-xs rounded-lg"
                                placeholder="e.g. জ্বর থাকলে (If fever persists)">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-200 border border-slate-300 text-[10px] text-slate-700 px-2 py-1 rounded">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-200 border border-slate-300 text-[10px] text-slate-700 px-2 py-1 rounded">ব্যথা
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='If Fever or Pain'"
                                    class="bg-slate-100 hover:bg-slate-200 border border-slate-300 text-[10px] text-slate-700 px-2 py-1 rounded">If
                                    Fever or Pain</button>
                            </div>
                        </div>

                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-lg text-xs uppercase shadow transition-colors">Append
                            Medicine Record Line</button>
                    </div>

                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs">
                        Select a product molecule compound from the left listing repository ledger registry to initialize
                        the dosage matrix framework layout.
                    </div>
                </div>
            </div>

            <div class="p-4 border-t bg-slate-50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-xs uppercase">Close</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg text-xs uppercase shadow">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl flex flex-col max-h-[85vh] overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-900 text-base">Select Advices</h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1">
                <div class="flex flex-wrap gap-2">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-white border border-slate-200 text-slate-700 text-xs px-3 py-2 rounded-lg font-medium transition-all hover:bg-slate-50 shadow-sm">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div class="p-4 border-t bg-slate-50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('advice-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-xs uppercase">Close</button>
                <button type="button" onclick="saveAdvicePipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg text-xs uppercase shadow">Done</button>
            </div>
        </div>
    </div>
    @endblock

@section('scripts')
    <script>
        // State Tracking Data Layers
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];

        let currentTargetTag = '';

        // Modal Control Pipeline Engine Actions
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- COMPLAINTS ENGINE LOGIC ---
        function selectComplaintTag(tag) {
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-input').value = '';
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }
        Barking

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-medium text-slate-900">• ${item.condition} <span class="text-slate-400 font-normal text-xs ml-2">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- EXAMINATION ENGINE LOGIC ---
        function selectExaminationTag(tag) {
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-medium text-slate-900">• ${item.key}: <span class="text-indigo-600 font-bold bg-indigo-50 px-1.5 py-0.5 rounded text-xs ml-1">${item.val}</span></div>`;
                });
            }
        }

        // --- MEDICATION EXECUTION FRAMEWORK ---
        function stageMedicineItem(drugName) {
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-2">
                        <div class="text-sm font-bold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-normal mt-0.5">
                            ${item.dosage} — <span class="text-slate-700 font-medium">${item.timing}</span> — <span class="text-indigo-600 font-bold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-600 text-[11px] font-medium bg-amber-50 px-1 rounded border border-amber-100 mt-1 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- ADVICE MANAGEMENT PANEL ARRAY ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.classList.remove('bg-indigo-600', 'text-white');
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.classList.add('bg-indigo-600', 'text-white');
                selectedAdvices.push(val);
            }
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-semibold text-slate-800">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>
@endsection --}}


{{-- @extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <div
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] transition-all duration-300 hover:shadow-[0_4px_20px_-3px_rgba(0,0,0,0.06)]">
            <div class="flex items-center space-x-6">
                <div class="h-12 w-12 bg-indigo-50 rounded-xl flex items-center justify-center text-xl shadow-inner">
                    👤
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Active
                        Consultation</label>
                    <span class="text-lg font-extrabold text-slate-900 tracking-tight" id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span class="text-sm text-slate-600 font-semibold bg-slate-100 px-3 py-1 rounded-full">22 Years |
                        Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div>
                <select name="patient_id"
                    class="border border-slate-200 bg-slate-50 text-xs font-bold rounded-xl p-3 text-slate-700 shadow-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none cursor-pointer">
                    @foreach ($patients ?? [] as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">

            <div class="col-span-12 lg:col-span-4 space-y-3">
                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm mb-4">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="space-y-8 text-sm">
                        <div id="live-section-complaints"
                            class="hidden border-l-2 border-amber-400 pl-4 py-0.5 transition-all duration-300">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Chief Symptoms
                                / Complaints</h4>
                            <div id="render-complaints-target" class="text-slate-800 space-y-1 font-semibold text-xs"></div>
                        </div>

                        <div id="live-section-examination"
                            class="hidden border-l-2 border-blue-400 pl-4 py-0.5 transition-all duration-300">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Clinical
                                Examination Findings</h4>
                            <div id="render-examination-target" class="text-slate-800 flex flex-wrap gap-2"></div>
                        </div>

                        <div id="live-section-medication"
                            class="hidden border-l-2 border-indigo-600 pl-4 py-0.5 transition-all duration-300">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-3">Prescribed
                                Therapeutics Regimen</h4>
                            <ol id="render-medication-target"
                                class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                        </div>

                        <div id="live-section-advice"
                            class="hidden border-l-2 border-emerald-500 pl-4 py-0.5 transition-all duration-300">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Therapeutic
                                Lifestyle Advice</h4>
                            <ul id="render-advice-target"
                                class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-12">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="🔍 Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 hover:shadow-md active:scale-95 cursor-pointer">{{ $tag }}</button>
                    @endforeach
                </div>

                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration
                            parameter for: <span id="active-complaint-label"
                                class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    </div>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs tracking-wide uppercase transition-colors">Cancel</button>
                <button type="button" onclick="saveComplaintsPipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs tracking-wide uppercase shadow-md hover:shadow-lg transition-all">Apply
                    Data</button>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer">{{ $exam }}</button>
                    @endforeach
                </div>

                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('examination-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="saveExaminationPipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                    Data</button>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div class="col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 space-y-3">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                        Inventory</h4>
                    <div class="flex flex-col space-y-1.5">
                        @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                        @foreach ($drugs as $drug)
                            <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                <span>{{ $drug }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5 animate-in fade-in duration-200">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">দুপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g. জ্বর থাকলে (If fever persists)">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='If Fever or Pain'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">If
                                    Fever or Pain</button>
                            </div>
                        </div>

                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>

                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix mapping ledger to initiate tracking variables.</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('advice-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="saveAdvicePipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                    Advice</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // State Collections Core JavaScript Controllers Data Array Logic
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];

        let currentTargetTag = '';

        // View Modal Display Pipeline State Triggers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- COMPLAINTS PROCESSING PANEL ---
        function selectComplaintTag(btn, tag) {
            // Clear previous active layout button boundaries styles
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
            btn.classList.add('bg-indigo-600', 'text-white');

            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-input').value = '';
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                // Overwrite if entry matches, otherwise append cleanly
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- EXAMINATION PROCESSING PANEL ---
        function selectExaminationTag(btn, tag) {
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
            btn.classList.add('bg-indigo-600', 'text-white');

            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<span class="bg-blue-50/70 border border-blue-100 text-slate-800 font-bold px-2.5 py-1 rounded-xl text-xs">${item.key}: <span class="text-blue-600">${item.val}</span></span>`;
                });
            }
        }

        // --- TREATMENT PLAN WORKSPACE REGIMEN MODAL ---
        function stageMedicineItem(btn, drugName) {
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50', 'border-indigo-300'));
            btn.classList.add('bg-indigo-50', 'border-indigo-300');

            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- DIETARY ADVICE LOGIC ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                btn.classList.add('bg-slate-50', 'border-slate-200/80', 'text-slate-700');
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.classList.remove('bg-slate-50', 'border-slate-200/80', 'text-slate-700');
                btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                selectedAdvices.push(val);
            }
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>
@endsection --}}


{{-- @extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <div onclick="openModal('patient-session-modal')"
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_-3px_rgba(79,70,229,0.15)] hover:border-indigo-300 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center space-x-6">
                <div
                    class="h-12 w-12 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white rounded-xl flex items-center justify-center text-xl shadow-inner transition-colors duration-300">
                    👤
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5 group-hover:text-indigo-500 transition-colors">Active
                        Consultation (Click to Change/Add)</label>
                    <span
                        class="text-lg font-extrabold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors"
                        id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span
                        class="text-sm text-slate-600 font-semibold bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 px-4 py-1 rounded-full transition-colors"
                        id="current-patient-meta">22 Years | Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div
                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                Manage Patients ⚙️
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">

            <div class="col-span-12 lg:col-span-4 space-y-3">
                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm mb-4">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                        <p><strong>Patient Name:</strong> <span id="canvas-pt-name"
                                class="text-slate-900 font-bold">Rabbi</span></p>
                        <p><strong>Demographics:</strong> <span id="canvas-pt-meta" class="text-slate-900 font-medium">22
                                Years | Male</span></p>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="space-y-8 text-sm">
                        <div id="live-section-complaints" class="hidden border-l-2 border-amber-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Chief Symptoms
                                / Complaints</h4>
                            <div id="render-complaints-target" class="text-slate-800 space-y-1 font-semibold text-xs"></div>
                        </div>

                        <div id="live-section-examination" class="hidden border-l-2 border-blue-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Clinical
                                Examination Findings</h4>
                            <div id="render-examination-target" class="text-slate-800 flex flex-wrap gap-2"></div>
                        </div>

                        <div id="live-section-medication" class="hidden border-l-2 border-indigo-600 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-3">Prescribed
                                Therapeutics Regimen</h4>
                            <ol id="render-medication-target"
                                class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                        </div>

                        <div id="live-section-advice" class="hidden border-l-2 border-emerald-500 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Therapeutic
                                Lifestyle Advice</h4>
                            <ul id="render-advice-target"
                                class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-12">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="patient-session-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4"
        onclick="if(event.target === this) closeModal('patient-session-modal')">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-200 max-h-[85vh]">
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4 text-indigo-900">
                    <span>✨</span> <span>Register New Patient</span>
                </h3>
                <form id="quick-patient-form" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full Legal
                            Name</label>
                        <input type="text" id="new-pt-name" placeholder="e.g. Ariful Islam"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age
                                (Years)</label>
                            <input type="number" id="new-pt-age" placeholder="25"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select id="new-pt-gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white cursor-pointer">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                            Number</label>
                        <input type="text" id="new-pt-phone" placeholder="01737541930"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="button" onclick="registerQuickPatient()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all transform active:scale-95">
                        Save & Activate Profile
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider text-slate-400">Switch Patient
                        Profile</h3>
                    <button type="button" onclick="closeModal('patient-session-modal')"
                        class="text-slate-400 hover:text-slate-600 font-bold text-sm h-6 w-6 rounded-full hover:bg-slate-100 flex items-center justify-center">✕</button>
                </div>
                <input type="text" oninput="filterPatientList(this.value)"
                    placeholder="🔍 Search current patient registry ledger logs..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div id="patient-ledger-list" class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <div onclick="setActivePatient('Rabbi', '22', 'Male')"
                        class="patient-ledger-card p-3 border border-indigo-100 bg-indigo-50/40 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-500 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Rabbi</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 22 • Male • 01737541930</p>
                        </div>
                        <span
                            class="text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm">Active</span>
                    </div>
                    <div onclick="setActivePatient('Md Ariful Islam', '30', 'Male')"
                        class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Md Ariful Islam</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 30 • Male • 01928347291</p>
                        </div>
                        <span class="text-[10px] text-slate-400 font-bold">Select</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="🔍 Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 hover:shadow-md active:scale-95 cursor-pointer">{{ $tag }}</button>
                    @endforeach
                </div>
                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration
                            parameter for: <span id="active-complaint-label"
                                class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    </div>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs tracking-wide uppercase transition-colors">Cancel</button>
                <button type="button" onclick="saveComplaintsPipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs tracking-wide uppercase shadow-md hover:shadow-lg transition-all">Apply
                    Data</button>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer">{{ $exam }}</button>
                    @endforeach
                </div>
                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('examination-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="saveExaminationPipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                    Data</button>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div class="col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 space-y-3">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                        Inventory</h4>
                    <div class="flex flex-col space-y-1.5">
                        @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                        @foreach ($drugs as $drug)
                            <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                <span>{{ $drug }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5 animate-in fade-in duration-200">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">দুপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g. জ্বর থাকলে">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                            </div>
                        </div>
                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>
                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix ledger.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('advice-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="saveAdvicePipeline()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                    Advice</button>
            </div>
        </div>
    </div>
    @endfile
@section('scripts')
    <script>
        // System Local Core Data States Array Map
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];
        let currentTargetTag = '';

        // Modal Control Windows System Handlers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- PATIENT INTERACTIVE LOGIC MODULES ---
        function setActivePatient(name, age, gender) {
            document.getElementById('current-patient-label').innerText = name;
            document.getElementById('current-patient-meta').innerText = `${age} Years | ${gender}`;
            document.getElementById('canvas-pt-name').innerText = name;
            document.getElementById('canvas-pt-meta').innerText = `${age} Years | ${gender}`;

            document.querySelectorAll('.patient-ledger-card').forEach(card => {
                card.classList.remove('border-indigo-100', 'bg-indigo-50/40');
                card.classList.add('border-slate-100', 'bg-slate-50/50');
                const indicator = card.querySelector('span');
                if (indicator) indicator.className = "text-[10px] text-slate-400 font-bold", indicator.innerText =
                    "Select";
            });

            const clickedCard = event.currentTarget;
            clickedCard.classList.remove('border-slate-100', 'bg-slate-50/50');
            clickedCard.classList.add('border-indigo-100', 'bg-indigo-50/40');
            const clickedIndicator = clickedCard.querySelector('span');
            if (clickedIndicator) clickedIndicator.className =
                "text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm",
                clickedIndicator.innerText = "Active";

            closeModal('patient-session-modal');
        }

        function registerQuickPatient() {
            const name = document.getElementById('new-pt-name').value;
            const age = document.getElementById('new-pt-age').value;
            const gender = document.getElementById('new-pt-gender').value;
            const phone = document.getElementById('new-pt-phone').value || '—';

            if (!name || !age) {
                alert('Please specify name and age.');
                return;
            }

            const ledgerContainer = document.getElementById('patient-ledger-list');
            const cardHtml = `
            <div onclick="setActivePatient('${name}', '${age}', '${gender}')" class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all">
                <div>
                    <h4 class="text-xs font-bold text-slate-900 name-field">${name}</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Age: ${age} • ${gender} • Phone: ${phone}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-bold">Select</span>
            </div>`;

            ledgerContainer.insertAdjacentHTML('afterbegin', cardHtml);
            setActivePatient(name, age, gender);
            document.getElementById('quick-patient-form').reset();
        }

        function filterPatientList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('.patient-ledger-card').forEach(card => {
                const name = card.querySelector('.name-field').innerText.toLowerCase();
                card.classList.toggle('hidden', !name.includes(query));
            });
        }

        // --- COMPLAINTS HANDLERS ENGINE ---
        function selectComplaintTag(btn, tag) {
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
            btn.classList.add('bg-indigo-600', 'text-white');
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-input').value = '';
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- ON EXAMINATION FINDINGS METHODS ---
        function selectExaminationTag(btn, tag) {
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
            btn.classList.add('bg-indigo-600', 'text-white');
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        // Render findings visually as distinct badge tags inside the paper canvas
        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<span class="bg-blue-50/70 border border-blue-100 text-slate-800 font-bold px-2.5 py-1 rounded-xl text-xs">${item.key}: <span class="text-blue-600">${item.val}</span></span>`;
                });
            }
        }

        // --- RX MEDICATION PLAN ENGINE ---
        function stageMedicineItem(btn, drugName) {
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50', 'border-indigo-300'));
            btn.classList.add('bg-indigo-50', 'border-indigo-300');
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1 text-slate-900 font-bold">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- LIFESTYLE ADVICE DIALOG MODULE ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                btn.classList.add('bg-slate-50', 'border-slate-200/80', 'text-slate-700');
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.classList.remove('bg-slate-50', 'border-slate-200/80', 'text-slate-700');
                btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                selectedAdvices.push(val);
            }
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <!-- Top Bar: Interactive Patient Switcher / Intake Control Card -->
        <div onclick="openModal('patient-session-modal')"
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_-3px_rgba(79,70,229,0.15)] hover:border-indigo-300 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center space-x-6">
                <div
                    class="h-12 w-12 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white rounded-xl flex items-center justify-center text-xl shadow-inner transition-colors duration-300">
                    👤
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5 group-hover:text-indigo-500 transition-colors">Active
                        Consultation (Click to Change/Add)</label>
                    <span
                        class="text-lg font-extrabold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors"
                        id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span
                        class="text-sm text-slate-600 font-semibold bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 px-4 py-1 rounded-full transition-colors"
                        id="current-patient-meta">22 Years | Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div
                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                Manage Patients ⚙️
            </div>
        </div>

        <!-- Main Workspace Area -->
        <div class="grid grid-cols-12 gap-8 items-start">

            <!-- LEFT COLUMN: Module Prescription Navigators -->
            <div class="col-span-12 lg:col-span-4 space-y-3">
                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm mb-4">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <!-- RIGHT COLUMN: Premium Medical Prescription Canvas Viewport -->
            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <!-- Institutional Header Template -->
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                        <p><strong>Patient Name:</strong> <span id="canvas-pt-name"
                                class="text-slate-900 font-bold">Rabbi</span></p>
                        <p><strong>Demographics:</strong> <span id="canvas-pt-meta" class="text-slate-900 font-medium">22
                                Years | Male</span></p>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="space-y-8 text-sm">
                        <div id="live-section-complaints" class="hidden border-l-2 border-amber-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Chief Symptoms
                                / Complaints</h4>
                            <div id="render-complaints-target" class="text-slate-800 space-y-1 font-semibold text-xs"></div>
                        </div>

                        <div id="live-section-examination" class="hidden border-l-2 border-blue-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Clinical
                                Examination Findings</h4>
                            <div id="render-examination-target" class="text-slate-800 flex flex-wrap gap-2"></div>
                        </div>

                        <div id="live-section-medication" class="hidden border-l-2 border-indigo-600 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-3">Prescribed
                                Therapeutics Regimen</h4>
                            <ol id="render-medication-target"
                                class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                        </div>

                        <div id="live-section-advice" class="hidden border-l-2 border-emerald-500 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Therapeutic
                                Lifestyle Advice</h4>
                            <ul id="render-advice-target"
                                class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-12">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- =========================================================
         MODAL LAYERS WITH INLINE CUSTOM ADD PARAMS
         ========================================================= -->

    <!-- Patient Switcher Overlay -->
    <div id="patient-session-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4"
        onclick="if(event.target === this) closeModal('patient-session-modal')">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-200 max-h-[85vh]">
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4 text-indigo-900">
                    <span>✨</span> <span>Register New Patient</span>
                </h3>
                <form id="quick-patient-form" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full Legal
                            Name</label>
                        <input type="text" id="new-pt-name" placeholder="e.g. Ariful Islam"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age
                                (Years)</label>
                            <input type="number" id="new-pt-age" placeholder="25"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select id="new-pt-gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white cursor-pointer">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                            Number</label>
                        <input type="text" id="new-pt-phone" placeholder="01737541930"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="button" onclick="registerQuickPatient()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all transform active:scale-95">
                        Save & Activate Profile
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider text-slate-400">Switch Patient
                        Profile</h3>
                    <button type="button" onclick="closeModal('patient-session-modal')"
                        class="text-slate-400 hover:text-slate-600 font-bold text-sm h-6 w-6 rounded-full hover:bg-slate-100 flex items-center justify-center">✕</button>
                </div>
                <input type="text" oninput="filterPatientList(this.value)"
                    placeholder="🔍 Search current patient registry ledger logs..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div id="patient-ledger-list" class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <div onclick="setActivePatient('Rabbi', '22', 'Male')"
                        class="patient-ledger-card p-3 border border-indigo-100 bg-indigo-50/40 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-500 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Rabbi</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 22 • Male • 01737541930</p>
                        </div>
                        <span
                            class="text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 1: Custom Patient Complaints (Ref: Screenshot 2026-06-07 at 12.23.47 PM.png) -->
    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div id="complaints-badge-grid" class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer select-none">{{ $tag }}</button>
                    @endforeach
                </div>

                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration parameter
                        for: <span id="active-complaint-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Interactive Footer Pipeline allowing Custom Complaint Additions -->
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-complaint-input" placeholder="Add Custom Complaint..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-56">
                    <button type="button" onclick="appendCustomComplaintTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Tag</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('complaints-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase transition-colors">Cancel</button>
                    <button type="button" onclick="saveComplaintsPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md transition-all">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Custom Examination Diagnostics Matrix (Ref: Screenshot 2026-06-07 at 12.23.38 PM.png) -->
    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="examination-badge-grid" class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer select-none">{{ $exam }}</button>
                    @endforeach
                </div>

                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div id="examination-metrics-grid" class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer Matrix Processing Controls enabling Inline Diagnostics Expansion -->
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <div class="flex gap-1.5">
                        <input type="text" id="custom-exam-name" placeholder="New Exam Name..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-36">
                        <button type="button" onclick="appendCustomExamTag()"
                            class="bg-slate-900 hover:bg-black text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Exam</button>
                    </div>
                    <div class="flex gap-1.5 border-l pl-2 border-slate-200">
                        <input type="text" id="custom-exam-metric" placeholder="New Metric Val..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-32">
                        <button type="button" onclick="appendCustomMetricValue()"
                            class="bg-slate-700 hover:bg-slate-800 text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Metric</button>
                    </div>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('examination-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveExaminationPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Custom Formulations Treatment Flow Scheduler (Ref: Screenshot 2026-06-07 at 12.23.26 PM.png) -->
    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <!-- Left Side Inventory Container Layout Sheet -->
                <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 flex flex-col justify-between">
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                            Inventory</h4>
                        <div id="medicine-catalog-list" class="flex flex-col space-y-1.5 pr-1">
                            @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                            @foreach ($drugs as $drug)
                                <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                    class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                    <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                    <span>{{ $drug }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Append Custom Formulation Molecule Line -->
                    <div class="pt-4 border-t border-slate-200/80 mt-4 bg-white -mx-5 -mb-5 p-4 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400">Add Custom
                            Molecule Formula</label>
                        <div class="flex gap-2">
                            <input type="text" id="custom-medicine-name" placeholder="Form, Molecule, Strength..."
                                class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-semibold shadow-sm w-full">
                            <button type="button" onclick="appendCustomMedicineCatalog()"
                                class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl tracking-wide shadow active:scale-95 shrink-0">Inventory</button>
                        </div>
                    </div>
                </div>

                <!-- Right Side Interactive Param Config Scheduler -->
                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">দুপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g. জ্বর থাকলে">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                            </div>
                        </div>
                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>
                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix ledger.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <!-- Modal 4: Custom Dietary & Care Advices (Ref: Screenshot 2026-06-07 at 12.23.14 PM.png) -->
    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div id="advices-badge-grid" class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>

            <!-- Interactive Advice Footer allowing Custom Care Directives -->
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-advice-input" placeholder="Type Custom Care Advice / Guideline..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-72">
                    <button type="button" onclick="appendCustomAdviceTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Guideline</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('advice-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveAdvicePipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Advice</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Local Framework Storage Engine Array Matrices
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];
        let currentTargetTag = '';

        // Modal Visibility Triggers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- PATIENT RUNTIME ASSIGNMENTS ---
        function setActivePatient(name, age, gender) {
            document.getElementById('current-patient-label').innerText = name;
            document.getElementById('current-patient-meta').innerText = `${age} Years | ${gender}`;
            document.getElementById('canvas-pt-name').innerText = name;
            document.getElementById('canvas-pt-meta').innerText = `${age} Years | ${gender}`;
            closeModal('patient-session-modal');
        }

        function registerQuickPatient() {
            const name = document.getElementById('new-pt-name').value;
            const age = document.getElementById('new-pt-age').value;
            const gender = document.getElementById('new-pt-gender').value;
            if (!name || !age) {
                alert('Please execute necessary parameters.');
                return;
            }

            const ledgerContainer = document.getElementById('patient-ledger-list');
            const cardHtml = `
            <div onclick="setActivePatient('${name}', '${age}', '${gender}')" class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all animate-fade-in">
                <div>
                    <h4 class="text-xs font-bold text-slate-900 name-field">${name}</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Age: ${age} • ${gender}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-bold">Select</span>
            </div>`;
            ledgerContainer.insertAdjacentHTML('afterbegin', cardHtml);
            setActivePatient(name, age, gender);
            document.getElementById('quick-patient-form').reset();
        }

        function filterPatientList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('.patient-ledger-card').forEach(card => {
                const name = card.querySelector('.name-field').innerText.toLowerCase();
                card.classList.toggle('hidden', !name.includes(query));
            });
        }

        // --- 🤢 MODULE 1: COMPLAINTS CUSTOM PIPELINES (Ref: Screenshot 12.23.47 PM) ---
        function selectComplaintTag(btn, tag) {
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
            btn.classList.add('bg-indigo-600', 'text-white');
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function appendCustomComplaintTag() {
            const value = document.getElementById('custom-complaint-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('complaints-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectComplaintTag(this, '${value}')" class="bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 text-indigo-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-complaint-input').value = '';

            // Auto-trigger selection workflow context onto new item execution path
            const spawnedButtons = grid.querySelectorAll('button');
            selectComplaintTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- 🩺 MODULE 2: EXAMINATION CUSTOM PIPELINES (Ref: Screenshot 12.23.38 PM) ---
        function selectExaminationTag(btn, tag) {
            btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
            btn.classList.add('bg-indigo-600', 'text-white');
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function appendCustomExamTag() {
            const value = document.getElementById('custom-exam-name').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectExaminationTag(this, '${value}')" class="bg-blue-50 hover:bg-indigo-600 border border-blue-200 text-blue-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-name').value = '';

            const spawnedButtons = grid.querySelectorAll('button');
            selectExaminationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function appendCustomMetricValue() {
            const value = document.getElementById('custom-exam-metric').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-metrics-grid');
            const btnHtml =
                `<button type="button" onclick="appendExamMetric('${value}')" class="bg-slate-900 text-white hover:bg-black text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-metric').value = '';
            appendExamMetric(value);
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<span class="bg-blue-50/70 border border-blue-100 text-slate-800 font-bold px-2.5 py-1 rounded-xl text-xs shadow-sm">${item.key}: <span class="text-blue-600">${item.val}</span></span>`;
                });
            }
        }

        // --- 💊 MODULE 3: FORMULATIONS MEDICINE CUSTOM PIPELINES (Ref: Screenshot 12.23.26 PM) ---
        function stageMedicineItem(btn, drugName) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50',
                    'border-indigo-300'));
                btn.classList.add('bg-indigo-50', 'border-indigo-300');
            }
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function appendCustomMedicineCatalog() {
            const value = document.getElementById('custom-medicine-name').value.trim();
            if (!value) return;
            const catalog = document.getElementById('medicine-catalog-list');
            const btnHtml = `
            <button type="button" onclick="stageMedicineItem(this, '${value}')" class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-indigo-50/30 hover:bg-indigo-50/50 rounded-xl border border-indigo-200 shadow-sm transition-all duration-150 flex items-center space-x-2 group animate-fade-in">
                <span class="text-indigo-400 font-mono text-xs">✨</span>
                <span>${value}</span>
            </button>`;
            catalog.insertAdjacentHTML('afterbegin', catalog.innerHTML === '' ? btnHtml : btnHtml);
            document.getElementById('custom-medicine-name').value = '';

            const firstBtn = catalog.querySelector('button');
            stageMedicineItem(firstBtn, value);
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1 text-slate-900 font-bold">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- 🍏 MODULE 4: CARE ADVICES CUSTOM PIPELINES (Ref: Screenshot 12.23.14 PM) ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                btn.classList.add('bg-slate-50', 'border-slate-200/80', 'text-slate-700');
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.classList.remove('bg-slate-50', 'border-slate-200/80', 'text-slate-700');
                btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                selectedAdvices.push(val);
            }
        }

        function appendCustomAdviceTag() {
            const value = document.getElementById('custom-advice-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('advices-badge-grid');
            const btnHtml =
                `<button type="button" onclick="toggleAdviceTag(this, '${value}')" class="bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none scale-95 animate-zoom-in">${value}</button>`;

            grid.insertAdjacentHTML('beforeend', btnHtml);
            selectedAdvices.push(value);
            document.getElementById('custom-advice-input').value = '';
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>

    <style>
        /* CSS Utility Keyframes for Client Appends */
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-zoom-in {
            animation: zoomIn 0.15s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>
@endsection --}}


{{-- @extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <div onclick="openModal('patient-session-modal')"
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_-3px_rgba(79,70,229,0.15)] hover:border-indigo-300 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center space-x-6">
                <div
                    class="h-12 w-12 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white rounded-xl flex items-center justify-center text-xl shadow-inner transition-colors duration-300">
                    👤
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5 group-hover:text-indigo-500 transition-colors">Active
                        Consultation (Click to Change/Add)</label>
                    <span
                        class="text-lg font-extrabold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors"
                        id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span
                        class="text-sm text-slate-600 font-semibold bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 px-4 py-1 rounded-full transition-colors"
                        id="current-patient-meta">22 Years | Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div
                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                Manage Patients ⚙️
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">

            <div class="col-span-12 lg:col-span-4 space-y-4">

                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm">
                    <h3
                        class="text-xs font-black uppercase tracking-widest text-indigo-600 mb-3 px-1 flex items-center space-x-1">
                        <span>⚡</span> <span>Preloaded Treatment Plans</span>
                    </h3>
                    <div class="grid grid-cols-1 gap-2">
                        <button type="button" onclick="loadTreatmentTemplate('fever_pack')"
                            class="text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                            <span>🤒 Standard Fever & Flu Protocol</span>
                            <span
                                class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100">Load
                                Plan</span>
                        </button>
                        <button type="button" onclick="loadTreatmentTemplate('hypertension_pack')"
                            class="text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                            <span>❤️ High Blood Pressure / Hypertension</span>
                            <span
                                class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100">Load
                                Plan</span>
                        </button>
                        <button type="button" onclick="loadTreatmentTemplate('acne_pack')"
                            class="text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                            <span>✨ Acne & Dermatological Routine</span>
                            <span
                                class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100">Load
                                Plan</span>
                        </button>
                    </div>
                </div>

                <button type="button" onclick="loadTreatmentTemplate('diabetes_pack')"
                    class="text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                    <span>🩺 Custom Diabetes Management Plan</span>
                    <span
                        class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100">Load
                        Plan</span>
                </button>

                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                        <p><strong>Patient Name:</strong> <span id="canvas-pt-name"
                                class="text-slate-900 font-bold">Rabbi</span></p>
                        <p><strong>Demographics:</strong> <span id="canvas-pt-meta" class="text-slate-900 font-medium">22
                                Years | Male</span></p>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="space-y-8 text-sm">
                        <div id="live-section-complaints" class="hidden border-l-2 border-amber-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Chief Symptoms
                                / Complaints</h4>
                            <div id="render-complaints-target" class="text-slate-800 space-y-1 font-semibold text-xs"></div>
                        </div>

                        <div id="live-section-examination" class="hidden border-l-2 border-blue-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Clinical
                                Examination Findings</h4>
                            <div id="render-examination-target" class="text-slate-800 flex flex-wrap gap-2"></div>
                        </div>

                        <div id="live-section-medication" class="hidden border-l-2 border-indigo-600 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-3">Prescribed
                                Therapeutics Regimen</h4>
                            <ol id="render-medication-target"
                                class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                        </div>

                        <div id="live-section-advice" class="hidden border-l-2 border-emerald-500 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Therapeutic
                                Lifestyle Advice</h4>
                            <ul id="render-advice-target"
                                class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-12">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="patient-session-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4"
        onclick="if(event.target === this) closeModal('patient-session-modal')">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-200 max-h-[85vh]">
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4 text-indigo-900">
                    <span>✨</span> <span>Register New Patient</span>
                </h3>
                <form id="quick-patient-form" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full Legal
                            Name</label>
                        <input type="text" id="new-pt-name" placeholder="e.g. Ariful Islam"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age
                                (Years)</label>
                            <input type="number" id="new-pt-age" placeholder="25"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select id="new-pt-gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white cursor-pointer">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                            Number</label>
                        <input type="text" id="new-pt-phone" placeholder="01737541930"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="button" onclick="registerQuickPatient()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all transform active:scale-95">
                        Save & Activate Profile
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider text-slate-400">Switch Patient
                        Profile</h3>
                    <button type="button" onclick="closeModal('patient-session-modal')"
                        class="text-slate-400 hover:text-slate-600 font-bold text-sm h-6 w-6 rounded-full hover:bg-slate-100 flex items-center justify-center">✕</button>
                </div>
                <input type="text" oninput="filterPatientList(this.value)"
                    placeholder="🔍 Search current patient registry ledger logs..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div id="patient-ledger-list" class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <div onclick="setActivePatient('Rabbi', '22', 'Male')"
                        class="patient-ledger-card p-3 border border-indigo-100 bg-indigo-50/40 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-500 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Rabbi</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 22 • Male • 01737541930</p>
                        </div>
                        <span
                            class="text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div id="complaints-badge-grid" class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer select-none">{{ $tag }}</button>
                    @endforeach
                </div>
                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration parameter
                        for: <span id="active-complaint-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-complaint-input" placeholder="Add Custom Complaint..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-56">
                    <button type="button" onclick="appendCustomComplaintTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Tag</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('complaints-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase transition-colors">Cancel</button>
                    <button type="button" onclick="saveComplaintsPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md transition-all">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="examination-badge-grid" class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer select-none">{{ $exam }}</button>
                    @endforeach
                </div>
                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div id="examination-metrics-grid" class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <div class="flex gap-1.5">
                        <input type="text" id="custom-exam-name" placeholder="New Exam Name..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-36">
                        <button type="button" onclick="appendCustomExamTag()"
                            class="bg-slate-900 hover:bg-black text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Exam</button>
                    </div>
                    <div class="flex gap-1.5 border-l pl-2 border-slate-200">
                        <input type="text" id="custom-exam-metric" placeholder="New Metric Val..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-32">
                        <button type="button" onclick="appendCustomMetricValue()"
                            class="bg-slate-700 hover:bg-slate-800 text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Metric</button>
                    </div>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('examination-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveExaminationPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 flex flex-col justify-between">
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                            Inventory</h4>
                        <div id="medicine-catalog-list" class="flex flex-col space-y-1.5 pr-1">
                            @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                            @foreach ($drugs as $drug)
                                <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                    class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                    <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                    <span>{{ $drug }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-200/80 mt-4 bg-white -mx-5 -mb-5 p-4 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400">Add Custom
                            Molecule Formula</label>
                        <div class="flex gap-2">
                            <input type="text" id="custom-medicine-name" placeholder="Form, Molecule, Strength..."
                                class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-semibold shadow-sm w-full">
                            <button type="button" onclick="appendCustomMedicineCatalog()"
                                class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl tracking-wide shadow active:scale-95 shrink-0">Inventory</button>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">দুপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g.  থাকলে">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                            </div>
                        </div>
                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>
                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix ledger.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div id="advices-badge-grid" class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-advice-input" placeholder="Type Custom Care Advice..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-72">
                    <button type="button" onclick="appendCustomAdviceTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Guideline</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('advice-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveAdvicePipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Advice</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // System Local Memory State Layers Map
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];
        let currentTargetTag = '';

        // Modal UI Managers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- NEW: PRELOADED TEMPLATE DICTIONARY MATRIX ---
        const treatmentTemplates = {
            fever_pack: {
                complaints: [{
                    condition: 'Fever',
                    duration: '3 Days'
                }, {
                    condition: 'Cough',
                    duration: '5 Days'
                }],
                examination: [{
                    key: 'Temperature',
                    val: '102°F'
                }, {
                    key: 'Pulse',
                    val: '92 bpm'
                }],
                medicines: [{
                        name: 'Napa (Tablet, 500 mg)',
                        dosage: '1 + 0 + 1 + 0',
                        timing: 'খাবারের পরে',
                        duration: '৫ দিন',
                        instruction: 'জ্বর থাকলে খাবেন'
                    },
                    {
                        name: 'Azithrocin (Tablet, 500 mg)',
                        dosage: '1 + 0 + 0 + 0',
                        timing: 'খাবারের আগে',
                        duration: '৫ দিন',
                        instruction: ''
                    }
                ],
                advices: ['পানি বেশি করে খাবেন', '৭ দিন বেড রেস্ট করবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']
            },
            hypertension_pack: {
                complaints: [{
                    condition: 'Headache',
                    duration: '1 Week'
                }, {
                    condition: 'Weakness',
                    duration: '3 Days'
                }],
                examination: [{
                    key: 'Blood Pressure',
                    val: '160/95 mmHg'
                }],
                medicines: [{
                    name: 'Indever (Tablet, 10 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের আগে',
                    duration: '১ মাস',
                    instruction: 'নিয়মিত চলবে'
                }],
                advices: ['তেল জাতীয় খাবার খাবেন না', 'ভারী ওজন বহন করবেন না', 'নিয়মিত ওষুধ খাবেন']
            },
            acne_pack: {
                complaints: [{
                    condition: 'Acne',
                    duration: '2 Months'
                }, {
                    condition: 'Itching',
                    duration: '15 Days'
                }],
                examination: [{
                    key: 'Normal',
                    val: 'Skin Breakouts'
                }],
                medicines: [{
                    name: 'Azithrocin (Tablet, 500 mg)',
                    dosage: '1 + 0 + 0 + 0',
                    timing: 'খাবারের পরে',
                    duration: '৩ দিন',
                    instruction: 'সপ্তাহে এক দিন'
                }],
                advices: ['নখ দিয়ে খোঁচাবেন না', 'পানি বেশি করে খাবেন']
            },
            diabetes_pack: {
                complaints: [{
                        condition: 'Increased Thirst',
                        duration: '2 Weeks'
                    },
                    {
                        condition: 'Frequent Urination',
                        duration: '1 Month'
                    }
                ],
                examination: [{
                        key: 'Random Blood Sugar (RBS)',
                        val: '14.2 mmol/L'
                    },
                    {
                        key: 'Weight',
                        val: '84 kg'
                    }
                ],
                medicines: [{
                    name: 'Tab. Metformin 500mg',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের পরে',
                    duration: '৩ মাস',
                    instruction: 'Regular'
                }],
                advices: ['মিষ্টি জাতীয় খাবার পরিহার করবেন', 'প্রতিদিন ৩০ মিনিট হাঁটবেন', 'নিয়মিত ওষুধ খাবেন']
            }
        };

        function loadTreatmentTemplate(templateKey) {
            const pack = treatmentTemplates[templateKey];
            if (!pack) return;

            // Assign core data object structures safely into memory states
            selectedComplaints = [...pack.complaints];
            selectedExaminations = [...pack.examination];
            selectedMedicines = [...pack.medicines];
            selectedAdvices = [...pack.advices];

            // Execute render refreshes on paper-mimic preview canvas side
            renderComplaintsView();
            renderExaminationView();
            renderMedicinesView();

            // Render advice guidelines list template targets manually
            const adviceContainer = document.getElementById('render-advice-target');
            const adviceSection = document.getElementById('live-section-advice');
            adviceContainer.innerHTML = '';
            if (selectedAdvices.length > 0) {
                adviceSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    adviceContainer.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }

            // Sync modal checklist button styling references matching active layout vectors
            document.querySelectorAll('#advices-badge-grid button').forEach(btn => {
                const text = btn.innerText.trim();
                if (selectedAdvices.includes(text)) {
                    btn.className =
                        "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none";
                } else {
                    btn.className =
                        "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                }
            });
        }

        // --- PATIENT RUNTIME ASSIGNMENTS ---
        function setActivePatient(name, age, gender) {
            document.getElementById('current-patient-label').innerText = name;
            document.getElementById('current-patient-meta').innerText = `${age} Years | ${gender}`;
            document.getElementById('canvas-pt-name').innerText = name;
            document.getElementById('canvas-pt-meta').innerText = `${age} Years | ${gender}`;
            closeModal('patient-session-modal');
        }

        function registerQuickPatient() {
            const name = document.getElementById('new-pt-name').value;
            const age = document.getElementById('new-pt-age').value;
            const gender = document.getElementById('new-pt-gender').value;
            if (!name || !age) {
                alert('Please execute parameters.');
                return;
            }

            const ledgerContainer = document.getElementById('patient-ledger-list');
            const cardHtml = `
            <div onclick="setActivePatient('${name}', '${age}', '${gender}')" class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all animate-fade-in">
                <div>
                    <h4 class="text-xs font-bold text-slate-900 name-field">${name}</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Age: ${age} • ${gender}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-bold">Select</span>
            </div>`;
            ledgerContainer.insertAdjacentHTML('afterbegin', cardHtml);
            setActivePatient(name, age, gender);
            document.getElementById('quick-patient-form').reset();
        }

        function filterPatientList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('.patient-ledger-card').forEach(card => {
                const name = card.querySelector('.name-field').innerText.toLowerCase();
                card.classList.toggle('hidden', !name.includes(query));
            });
        }

        // --- COMPLAINTS ENGINE MODULES ---
        function selectComplaintTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function appendCustomComplaintTag() {
            const value = document.getElementById('custom-complaint-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('complaints-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectComplaintTag(this, '${value}')" class="bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 text-indigo-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-complaint-input').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectComplaintTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- EXAMINATION FINDINGS MODULES ---
        function selectExaminationTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function appendCustomExamTag() {
            const value = document.getElementById('custom-exam-name').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectExaminationTag(this, '${value}')" class="bg-blue-50 hover:bg-indigo-600 border border-blue-200 text-blue-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-name').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectExaminationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function appendCustomMetricValue() {
            const value = document.getElementById('custom-exam-metric').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-metrics-grid');
            const btnHtml =
                `<button type="button" onclick="appendExamMetric('${value}')" class="bg-slate-900 text-white hover:bg-black text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-metric').value = '';
            appendExamMetric(value);
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<span class="bg-blue-50/70 border border-blue-100 text-slate-800 font-bold px-2.5 py-1 rounded-xl text-xs shadow-sm">${item.key}: <span class="text-blue-600">${item.val}</span></span>`;
                });
            }
        }

        // --- RX MEDICATION PLAN ENGINE ---
        function stageMedicineItem(btn, drugName) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50',
                    'border-indigo-300'));
                btn.classList.add('bg-indigo-50', 'border-indigo-300');
            }
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function appendCustomMedicineCatalog() {
            const value = document.getElementById('custom-medicine-name').value.trim();
            if (!value) return;
            const catalog = document.getElementById('medicine-catalog-list');
            const btnHtml = `
            <button type="button" onclick="stageMedicineItem(this, '${value}')" class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-indigo-50/30 hover:bg-indigo-50/50 rounded-xl border border-indigo-200 shadow-sm transition-all duration-150 flex items-center space-x-2 group animate-fade-in">
                <span class="text-indigo-400 font-mono text-xs">✨</span>
                <span>${value}</span>
            </button>`;
            catalog.insertAdjacentHTML('afterbegin', btnHtml);
            document.getElementById('custom-medicine-name').value = '';
            const firstBtn = catalog.querySelector('button');
            stageMedicineItem(firstBtn, value);
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1 text-slate-900 font-bold">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- LIFESTYLE ADVICE DIRECTIVES ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.className =
                    "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.className =
                    "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none";
                selectedAdvices.push(val);
            }
        }

        function appendCustomAdviceTag() {
            const value = document.getElementById('custom-advice-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('advices-badge-grid');
            const btnHtml =
                `<button type="button" onclick="toggleAdviceTag(this, '${value}')" class="bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            selectedAdvices.push(value);
            document.getElementById('custom-advice-input').value = '';
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>

    <style>
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-zoom-in {
            animation: zoomIn 0.15s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <div onclick="openModal('patient-session-modal')"
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_-3px_rgba(79,70,229,0.15)] hover:border-indigo-300 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center space-x-6">
                <div
                    class="h-12 w-12 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white rounded-xl flex items-center justify-center text-xl shadow-inner transition-colors duration-300">
                    👤
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5 group-hover:text-indigo-500 transition-colors">Active
                        Consultation (Click to Change/Add)</label>
                    <span
                        class="text-lg font-extrabold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors"
                        id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span
                        class="text-sm text-slate-600 font-semibold bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 px-4 py-1 rounded-full transition-colors"
                        id="current-patient-meta">22 Years | Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div
                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                Manage Patients ⚙️
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">

            <div class="col-span-12 lg:col-span-4 space-y-4">

                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm">
                    <h3
                        class="text-xs font-black uppercase tracking-widest text-indigo-600 mb-3 px-1 flex items-center space-x-1">
                        <span>⚡</span> <span>Treatment Plan Templates</span>
                    </h3>
                    <div id="ui-templates-container" class="grid grid-cols-1 gap-2">
                        <button type="button" onclick="loadTreatmentTemplate('fever_pack')"
                            class="text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                            <span>HN-01: Standard Fever & Flu</span>
                            <span
                                class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100">Load
                                Plan</span>
                        </button>
                        <button type="button" onclick="loadTreatmentTemplate('hypertension_pack')"
                            class="text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                            <span>HN-02: Hypertension Routine</span>
                            <span
                                class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100">Load
                                Plan</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                        <p><strong>Patient Name:</strong> <span id="canvas-pt-name"
                                class="text-slate-900 font-bold">Rabbi</span></p>
                        <p><strong>Demographics:</strong> <span id="canvas-pt-meta" class="text-slate-900 font-medium">22
                                Years | Male</span></p>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="space-y-8 text-sm">
                        <div id="live-section-complaints" class="hidden border-l-2 border-amber-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Chief Symptoms
                                / Complaints</h4>
                            <div id="render-complaints-target" class="text-slate-800 space-y-1 font-semibold text-xs"></div>
                        </div>

                        <div id="live-section-examination" class="hidden border-l-2 border-blue-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Clinical
                                Examination Findings</h4>
                            <div id="render-examination-target" class="text-slate-800 flex flex-wrap gap-2"></div>
                        </div>

                        <div id="live-section-medication" class="hidden border-l-2 border-indigo-600 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-3">Prescribed
                                Therapeutics Regimen</h4>
                            <ol id="render-medication-target"
                                class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                        </div>

                        <div id="live-section-advice" class="hidden border-l-2 border-emerald-500 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Therapeutic
                                Lifestyle Advice</h4>
                            <ul id="render-advice-target"
                                class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-12 bg-slate-50 p-4 border border-slate-200/60 rounded-2xl flex flex-col sm:flex-row gap-3 justify-between items-center shadow-inner">
                    <div class="w-full sm:flex-1">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Save Active
                            Configuration Layout</label>
                        <input type="text" id="custom-template-title-input"
                            placeholder="e.g., Diabetes Pack, Gastric Routine..."
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold bg-white outline-none focus:border-indigo-500 shadow-sm">
                    </div>
                    <button type="button" onclick="createNewTreatmentTemplateFromUI()"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest px-5 py-3 rounded-xl transition-all shadow-md active:scale-95 shrink-0 sm:mt-4">
                        Save as Template 💾
                    </button>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-6">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="patient-session-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4"
        onclick="if(event.target === this) closeModal('patient-session-modal')">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-200 max-h-[85vh]">
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4 text-indigo-900">
                    <span>✨</span> <span>Register New Patient</span>
                </h3>
                <form id="quick-patient-form" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full Legal
                            Name</label>
                        <input type="text" id="new-pt-name" placeholder="e.g. Ariful Islam"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age
                                (Years)</label>
                            <input type="number" id="new-pt-age" placeholder="25"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select id="new-pt-gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white cursor-pointer">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                            Number</label>
                        <input type="text" id="new-pt-phone" placeholder="01737541930"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="button" onclick="registerQuickPatient()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all transform active:scale-95">
                        Save & Activate Profile
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider text-slate-400">Switch Patient
                        Profile</h3>
                    <button type="button" onclick="closeModal('patient-session-modal')"
                        class="text-slate-400 hover:text-slate-600 font-bold text-sm h-6 w-6 rounded-full hover:bg-slate-100 flex items-center justify-center">✕</button>
                </div>
                <input type="text" oninput="filterPatientList(this.value)"
                    placeholder="🔍 Search current patient registry ledger logs..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div id="patient-ledger-list" class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <div onclick="setActivePatient('Rabbi', '22', 'Male')"
                        class="patient-ledger-card p-3 border border-indigo-100 bg-indigo-50/40 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-500 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Rabbi</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 22 • Male • 01737541930</p>
                        </div>
                        <span
                            class="text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div id="complaints-badge-grid" class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 border border-slate-200/60 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 hover:bg-indigo-600 hover:text-white cursor-pointer select-none shadow-sm">{{ $tag }}</button>
                    @endforeach
                </div>

                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration parameter
                        for: <span id="active-complaint-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-complaint-input" placeholder="Add Custom Complaint..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-56">
                    <button type="button" onclick="appendCustomComplaintTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Tag</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('complaints-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase transition-colors">Cancel</button>
                    <button type="button" onclick="saveComplaintsPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md transition-all">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="examination-badge-grid" class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 border border-slate-200/60 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all hover:bg-indigo-600 hover:text-white shadow-sm cursor-pointer select-none">{{ $exam }}</button>
                    @endforeach
                </div>
                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div id="examination-metrics-grid" class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <div class="flex gap-1.5">
                        <input type="text" id="custom-exam-name" placeholder="New Exam Name..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-36">
                        <button type="button" onclick="appendCustomExamTag()"
                            class="bg-slate-900 hover:bg-black text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Exam</button>
                    </div>
                    <div class="flex gap-1.5 border-l pl-2 border-slate-200">
                        <input type="text" id="custom-exam-metric" placeholder="New Metric Val..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-32">
                        <button type="button" onclick="appendCustomMetricValue()"
                            class="bg-slate-700 hover:bg-slate-800 text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Metric</button>
                    </div>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('examination-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveExaminationPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 flex flex-col justify-between">
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                            Inventory</h4>
                        <div id="medicine-catalog-list" class="flex flex-col space-y-1.5 pr-1">
                            @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                            @foreach ($drugs as $drug)
                                <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                    class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                    <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                    <span>{{ $drug }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-200/80 mt-4 bg-white -mx-5 -mb-5 p-4 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400">Add Custom
                            Molecule Formula</label>
                        <div class="flex gap-2">
                            <input type="text" id="custom-medicine-name" placeholder="Form, Molecule, Strength..."
                                class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-semibold shadow-sm w-full">
                            <button type="button" onclick="appendCustomMedicineCatalog()"
                                class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl tracking-wide shadow active:scale-95 shrink-0">Inventory</button>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">дуপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g. জ্বর থাকলে">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                            </div>
                        </div>
                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>
                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix ledger.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div id="advices-badge-grid" class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-advice-input" placeholder="Type Custom Care Advice..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-72">
                    <button type="button" onclick="appendCustomAdviceTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Guideline</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('advice-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveAdvicePipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Advice</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // System Local Framework Storage Collections Core State Maps
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];
        let currentTargetTag = '';

        // Modal Control Pipeline Triggers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- TREATMENT TEMPLATE ARCHITECTURE LEDGER ENGINE ---
        const treatmentTemplates = {
            fever_pack: {
                title: 'HN-01: Standard Fever & Flu',
                complaints: [{
                    condition: 'Fever',
                    duration: '3 Days'
                }, {
                    condition: 'Cough',
                    duration: '5 Days'
                }],
                examination: [{
                    key: 'Temperature',
                    val: '102°F'
                }, {
                    key: 'Pulse',
                    val: '92 bpm'
                }],
                medicines: [{
                    name: 'Napa (Tablet, 500 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের পরে',
                    duration: '৫ দিন',
                    instruction: 'জ্বর থাকলে খাবেন'
                }],
                advices: ['পানি বেশি করে খাবেন', '৭ দিন বেড রেস্ট করবেন']
            },
            hypertension_pack: {
                title: 'HN-02: Hypertension Routine',
                complaints: [{
                    condition: 'Headache',
                    duration: '1 Week'
                }],
                examination: [{
                    key: 'Blood Pressure',
                    val: '160/95 mmHg'
                }],
                medicines: [{
                    name: 'Indever (Tablet, 10 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের আগে',
                    duration: '১ মাস',
                    instruction: 'নিয়মিত চলবে'
                }],
                advices: ['তেল জাতীয় খাবার খাবেন না', 'নিয়মিত ওষুধ খাবেন']
            }
        };

        // NEW: UI Template Generation Engine (Allows doctors to construct custom templates via UI)
        function createNewTreatmentTemplateFromUI() {
            const titleInput = document.getElementById('custom-template-title-input');
            const title = titleInput.value.trim();

            if (!title) {
                alert('Please specify a recognizable Plan Template Name first.');
                return;
            }

            if (selectedComplaints.length === 0 && selectedMedicines.length === 0) {
                alert(
                    'Cannot formulate an empty checklist template asset. Append symptoms or medications onto the right document panel first.');
                return;
            }

            // Generate clean dynamic key identifier index strings
            const uniqueKey = 'custom_pack_' + Date.now();

            // Map live memory metrics arrays safely onto the dictionary collection object parameters
            treatmentTemplates[uniqueKey] = {
                title: title,
                complaints: [...selectedComplaints],
                examination: [...selectedExaminations],
                medicines: [...selectedMedicines],
                advices: [...selectedAdvices]
            };

            // Append template layout trigger element natively into the Left Sidebar panel listing wrapper
            const leftContainer = document.getElementById('ui-templates-container');
            const customButtonHtml = `
            <button type="button" onclick="loadTreatmentTemplate('${uniqueKey}')" class="text-left text-xs font-bold px-4 py-3 bg-emerald-50/60 hover:bg-indigo-600 text-emerald-950 hover:text-white border border-emerald-100 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95 scale-95 animate-zoom-in">
                <span>📋 ${title}</span>
                <span class="text-[10px] bg-white text-emerald-700 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-emerald-100 tracking-wide uppercase">Load Plan</span>
            </button>`;

            leftContainer.insertAdjacentHTML('beforeend', customButtonHtml);

            // Reset input card and prompt user interaction feedback metrics
            titleInput.value = '';
            alert(
                `Success! "${title}" is now added as an active pre-loaded shortcut option inside the left workspace panel list container tray.`);
        }

        function loadTreatmentTemplate(templateKey) {
            const pack = treatmentTemplates[templateKey];
            if (!pack) return;

            // Sync local tracking state maps
            selectedComplaints = [...pack.complaints];
            selectedExaminations = [...pack.examination];
            selectedMedicines = [...pack.medicines];
            selectedAdvices = [...pack.advices];

            // Hydrate views arrays sequentially onto preview sheets components
            renderComplaintsView();
            renderExaminationView();
            renderMedicinesView();

            const adviceContainer = document.getElementById('render-advice-target');
            const adviceSection = document.getElementById('live-section-advice');
            adviceContainer.innerHTML = '';
            if (selectedAdvices.length > 0) {
                adviceSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    adviceContainer.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }

            // Sync modal tags check elements colors
            document.querySelectorAll('#advices-badge-grid button').forEach(btn => {
                const text = btn.innerText.trim();
                if (selectedAdvices.includes(text)) {
                    btn.className =
                        "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl shadow-sm cursor-pointer select-none";
                } else {
                    btn.className =
                        "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                }
            });
        }

        // --- PATIENT RUNTIME TRACKERS ---
        function setActivePatient(name, age, gender) {
            document.getElementById('current-patient-label').innerText = name;
            document.getElementById('current-patient-meta').innerText = `${age} Years | ${gender}`;
            document.getElementById('canvas-pt-name').innerText = name;
            document.getElementById('canvas-pt-meta').innerText = `${age} Years | ${gender}`;
            closeModal('patient-session-modal');
        }

        function registerQuickPatient() {
            const name = document.getElementById('new-pt-name').value;
            const age = document.getElementById('new-pt-age').value;
            const gender = document.getElementById('new-pt-gender').value;
            if (!name || !age) {
                alert('Specify necessary inputs parameters fields.');
                return;
            }

            const ledgerContainer = document.getElementById('patient-ledger-list');
            const cardHtml = `
            <div onclick="setActivePatient('${name}', '${age}', '${gender}')" class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all animate-fade-in">
                <div>
                    <h4 class="text-xs font-bold text-slate-900 name-field">${name}</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Age: ${age} • ${gender}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-bold">Select</span>
            </div>`;
            ledgerContainer.insertAdjacentHTML('afterbegin', cardHtml);
            setActivePatient(name, age, gender);
            document.getElementById('quick-patient-form').reset();
        }

        function filterPatientList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('.patient-ledger-card').forEach(card => {
                const name = card.querySelector('.name-field').innerText.toLowerCase();
                card.classList.toggle('hidden', !name.includes(query));
            });
        }

        // --- COMPLAINTS ENGINE HANDLERS ---
        function selectComplaintTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function appendCustomComplaintTag() {
            const value = document.getElementById('custom-complaint-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('complaints-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectComplaintTag(this, '${value}')" class="bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 text-indigo-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-complaint-input').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectComplaintTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- EXAMINATION TRACKERS ---
        function selectExaminationTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function appendCustomExamTag() {
            const value = document.getElementById('custom-exam-name').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectExaminationTag(this, '${value}')" class="bg-blue-50 hover:bg-indigo-600 border border-blue-200 text-blue-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-name').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectExaminationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function appendCustomMetricValue() {
            const value = document.getElementById('custom-exam-metric').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-metrics-grid');
            const btnHtml =
                `<button type="button" onclick="appendExamMetric('${value}')" class="bg-slate-900 text-white hover:bg-black text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-metric').value = '';
            appendExamMetric(value);
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<span class="bg-blue-50/70 border border-blue-100 text-slate-800 font-bold px-2.5 py-1 rounded-xl text-xs shadow-sm">${item.key}: <span class="text-blue-600">${item.val}</span></span>`;
                });
            }
        }

        // --- MEDICINES ENGINE ---
        function stageMedicineItem(btn, drugName) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50',
                    'border-indigo-300'));
                btn.classList.add('bg-indigo-50', 'border-indigo-300');
            }
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function appendCustomMedicineCatalog() {
            const value = document.getElementById('custom-medicine-name').value.trim();
            if (!value) return;
            const catalog = document.getElementById('medicine-catalog-list');
            const btnHtml = `
            <button type="button" onclick="stageMedicineItem(this, '${value}')" class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-indigo-50/30 hover:bg-indigo-50/50 rounded-xl border border-indigo-200 shadow-sm transition-all duration-150 flex items-center space-x-2 group animate-fade-in">
                <span class="text-indigo-400 font-mono text-xs">✨</span>
                <span>${value}</span>
            </button>`;
            catalog.insertAdjacentHTML('afterbegin', btnHtml);
            document.getElementById('custom-medicine-name').value = '';
            const firstBtn = catalog.querySelector('button');
            stageMedicineItem(firstBtn, value);
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1 text-slate-900 font-bold">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- ADVICES PIPELINES ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.className =
                    "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.className =
                    "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none";
                selectedAdvices.push(val);
            }
        }

        function appendCustomAdviceTag() {
            const value = document.getElementById('custom-advice-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('advices-badge-grid');
            const btnHtml =
                `<button type="button" onclick="toggleAdviceTag(this, '${value}')" class="bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            selectedAdvices.push(value);
            document.getElementById('custom-advice-input').value = '';
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>

    <style>
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-zoom-in {
            animation: zoomIn 0.15s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <div onclick="openModal('patient-session-modal')"
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_-3px_rgba(79,70,229,0.15)] hover:border-indigo-300 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center space-x-6">
                <div
                    class="h-12 w-12 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white rounded-xl flex items-center justify-center text-xl shadow-inner transition-colors duration-300">
                    👤
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5 group-hover:text-indigo-500 transition-colors">Active
                        Consultation (Click to Change/Add)</label>
                    <span
                        class="text-lg font-extrabold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors"
                        id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span
                        class="text-sm text-slate-600 font-semibold bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 px-4 py-1 rounded-full transition-colors"
                        id="current-patient-meta">22 Years | Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div
                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                Manage Patients ⚙️
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">

            <div class="col-span-12 lg:col-span-4 space-y-4">

                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm">
                    <h3
                        class="text-xs font-black uppercase tracking-widest text-indigo-600 mb-3 px-1 flex items-center space-x-1">
                        <span>⚡</span> <span>Treatment Plan Templates</span>
                    </h3>

                    <div class="mb-4">
                        <input type="text" oninput="filterTreatmentTemplatesList(this.value)"
                            placeholder="🔍 Search template packages..."
                            class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 transition-all shadow-sm">
                    </div>

                    <div id="ui-templates-container" class="grid grid-cols-1 gap-2 max-h-[280px] overflow-y-auto pr-1">
                        <div class="template-wrapper-item" data-title="standard fever flu protocol">
                            <button type="button" onclick="loadTreatmentTemplate('fever_pack')"
                                class="w-full text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                                <span>HN-01: Standard Fever & Flu</span>
                                <span
                                    class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100 shrink-0 ml-2">Load
                                    Plan</span>
                            </button>
                        </div>
                        <div class="template-wrapper-item" data-title="hypertension routine routine high blood pressure">
                            <button type="button" onclick="loadTreatmentTemplate('hypertension_pack')"
                                class="w-full text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                                <span>HN-02: Hypertension Routine</span>
                                <span
                                    class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100 shrink-0 ml-2">Load
                                    Plan</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                        <p><strong>Patient Name:</strong> <span id="canvas-pt-name"
                                class="text-slate-900 font-bold">Rabbi</span></p>
                        <p><strong>Demographics:</strong> <span id="canvas-pt-meta" class="text-slate-900 font-medium">22
                                Years | Male</span></p>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="space-y-8 text-sm">
                        <div id="live-section-complaints" class="hidden border-l-2 border-amber-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Chief Symptoms
                                / Complaints</h4>
                            <div id="render-complaints-target" class="text-slate-800 space-y-1 font-semibold text-xs"></div>
                        </div>

                        <div id="live-section-examination" class="hidden border-l-2 border-blue-400 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Clinical
                                Examination Findings</h4>
                            <div id="render-examination-target" class="text-slate-800 flex flex-wrap gap-2"></div>
                        </div>

                        <div id="live-section-medication" class="hidden border-l-2 border-indigo-600 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-3">Prescribed
                                Therapeutics Regimen</h4>
                            <ol id="render-medication-target"
                                class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                        </div>

                        <div id="live-section-advice" class="hidden border-l-2 border-emerald-500 pl-4 py-0.5">
                            <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Therapeutic
                                Lifestyle Advice</h4>
                            <ul id="render-advice-target"
                                class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-12 bg-slate-50 p-4 border border-slate-200/60 rounded-2xl flex flex-col sm:flex-row gap-3 justify-between items-center shadow-inner">
                    <div class="w-full sm:flex-1">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Save
                            Active Configuration Layout</label>
                        <input type="text" id="custom-template-title-input"
                            placeholder="e.g., Diabetes Pack, Gastric Routine..."
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold bg-white outline-none focus:border-indigo-500 shadow-sm">
                    </div>
                    <button type="button" onclick="createNewTreatmentTemplateFromUI()"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest px-5 py-3 rounded-xl transition-all shadow-md active:scale-95 shrink-0 sm:mt-4">
                        Save as Template 💾
                    </button>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-6">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="patient-session-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4"
        onclick="if(event.target === this) closeModal('patient-session-modal')">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-200 max-h-[85vh]">
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4 text-indigo-900">
                    <span>✨</span> <span>Register New Patient</span>
                </h3>
                <form id="quick-patient-form" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full Legal
                            Name</label>
                        <input type="text" id="new-pt-name" placeholder="e.g. Ariful Islam"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age
                                (Years)</label>
                            <input type="number" id="new-pt-age" placeholder="25"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select id="new-pt-gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white cursor-pointer">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                            Number</label>
                        <input type="text" id="new-pt-phone" placeholder="01737541930"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="button" onclick="registerQuickPatient()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all transform active:scale-95">
                        Save & Activate Profile
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider text-slate-400">Switch Patient
                        Profile</h3>
                    <button type="button" onclick="closeModal('patient-session-modal')"
                        class="text-slate-400 hover:text-slate-600 font-bold text-sm h-6 w-6 rounded-full hover:bg-slate-100 flex items-center justify-center">✕</button>
                </div>
                <input type="text" oninput="filterPatientList(this.value)"
                    placeholder="🔍 Search current patient registry ledger logs..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div id="patient-ledger-list" class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <div onclick="setActivePatient('Rabbi', '22', 'Male')"
                        class="patient-ledger-card p-3 border border-indigo-100 bg-indigo-50/40 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-500 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Rabbi</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 22 • Male • 01737541930</p>
                        </div>
                        <span
                            class="text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div id="complaints-badge-grid" class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 border border-slate-200/60 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 hover:bg-indigo-600 hover:text-white cursor-pointer select-none shadow-sm">{{ $tag }}</button>
                    @endforeach
                </div>

                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration parameter
                        for: <span id="active-complaint-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-complaint-input" placeholder="Add Custom Complaint..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-56">
                    <button type="button" onclick="appendCustomComplaintTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Tag</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('complaints-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase transition-colors">Cancel</button>
                    <button type="button" onclick="saveComplaintsPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md transition-all">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="examination-badge-grid" class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all hover:bg-indigo-600 hover:text-white shadow-sm cursor-pointer select-none">{{ $exam }}</button>
                    @endforeach
                </div>
                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div id="examination-metrics-grid" class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <div class="flex gap-1.5">
                        <input type="text" id="custom-exam-name" placeholder="New Exam Name..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-36">
                        <button type="button" onclick="appendCustomExamTag()"
                            class="bg-slate-900 hover:bg-black text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Exam</button>
                    </div>
                    <div class="flex gap-1.5 border-l pl-2 border-slate-200">
                        <input type="text" id="custom-exam-metric" placeholder="New Metric Val..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-32">
                        <button type="button" onclick="appendCustomMetricValue()"
                            class="bg-slate-700 hover:bg-slate-800 text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Metric</button>
                    </div>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('examination-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveExaminationPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 flex flex-col justify-between">
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                            Inventory</h4>
                        <div id="medicine-catalog-list" class="flex flex-col space-y-1.5 pr-1">
                            @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                            @foreach ($drugs as $drug)
                                <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                    class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                    <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                    <span>{{ $drug }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-200/80 mt-4 bg-white -mx-5 -mb-5 p-4 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400">Add Custom
                            Molecule Formula</label>
                        <div class="flex gap-2">
                            <input type="text" id="custom-medicine-name" placeholder="Form, Molecule, Strength..."
                                class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-semibold shadow-sm w-full">
                            <button type="button" onclick="appendCustomMedicineCatalog()"
                                class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl tracking-wide shadow active:scale-95 shrink-0">Inventory</button>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">দুপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g. জ্বর থাকলে">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                            </div>
                        </div>
                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>
                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix ledger.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div id="advices-badge-grid" class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-advice-input" placeholder="Type Custom Care Advice..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-72">
                    <button type="button" onclick="appendCustomAdviceTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Guideline</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('advice-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveAdvicePipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Advice</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // System Local Framework Storage Collections Core State Maps
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];
        let currentTargetTag = '';

        // Modal Control Pipeline Triggers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- TREATMENT TEMPLATE ARCHITECTURE LEDGER ENGINE ---
        const treatmentTemplates = {
            fever_pack: {
                title: 'HN-01: Standard Fever & Flu',
                complaints: [{
                    condition: 'Fever',
                    duration: '3 Days'
                }, {
                    condition: 'Cough',
                    duration: '5 Days'
                }],
                examination: [{
                    key: 'Temperature',
                    val: '102°F'
                }, {
                    key: 'Pulse',
                    val: '92 bpm'
                }],
                medicines: [{
                    name: 'Napa (Tablet, 500 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের পরে',
                    duration: '৫ দিন',
                    instruction: 'জ্বর থাকলে খাবেন'
                }],
                advices: ['পানি বেশি করে খাবেন', '৭ দিন বেড রেস্ট করবেন']
            },
            hypertension_pack: {
                title: 'HN-02: Hypertension Routine',
                complaints: [{
                    condition: 'Headache',
                    duration: '1 Week'
                }],
                examination: [{
                    key: 'Blood Pressure',
                    val: '160/95 mmHg'
                }],
                medicines: [{
                    name: 'Indever (Tablet, 10 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের আগে',
                    duration: '১ মাস',
                    instruction: 'নিয়মিত চলবে'
                }],
                advices: ['তেল জাতীয় খাবার খাবেন না', 'নিয়মিত ওষুধ খাবেন']
            }
        };

        // NEW: Template Search Filtering Engine
        function filterTreatmentTemplatesList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('#ui-templates-container .template-wrapper-item').forEach(item => {
                const indexTitle = item.getAttribute('data-title');
                item.classList.toggle('hidden', !indexTitle.includes(query));
            });
        }

        // UI Template Generation Engine (Allows doctors to construct custom templates via UI)
        function createNewTreatmentTemplateFromUI() {
            const titleInput = document.getElementById('custom-template-title-input');
            const title = titleInput.value.trim();

            if (!title) {
                alert('Please specify a recognizable Plan Template Name first.');
                return;
            }

            if (selectedComplaints.length === 0 && selectedMedicines.length === 0) {
                alert(
                    'Cannot formulate an empty checklist template asset. Append symptoms or medications onto the right document panel first.');
                return;
            }

            const uniqueKey = 'custom_pack_' + Date.now();

            treatmentTemplates[uniqueKey] = {
                title: title,
                complaints: [...selectedComplaints],
                examination: [...selectedExaminations],
                medicines: [...selectedMedicines],
                advices: [...selectedAdvices]
            };

            const leftContainer = document.getElementById('ui-templates-container');

            // Lowercase query search metadata helper attribute strings compilation
            const dataSearchMeta = title.toLowerCase().replace(/[^a-z0-9 ]/g, '');

            const customButtonHtml = `
            <div class="template-wrapper-item" data-title="${dataSearchMeta}">
                <button type="button" onclick="loadTreatmentTemplate('${uniqueKey}')" class="w-full text-left text-xs font-bold px-4 py-3 bg-emerald-50/60 hover:bg-indigo-600 text-emerald-950 hover:text-white border border-emerald-100 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95 scale-95 animate-zoom-in">
                    <span>📋 ${title}</span>
                    <span class="text-[10px] bg-white text-emerald-700 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-emerald-100 tracking-wide uppercase shrink-0 ml-2">Load Plan</span>
                </button>
            </div>`;

            leftContainer.insertAdjacentHTML('beforeend', customButtonHtml);
            titleInput.value = '';
            alert(
                `Success! "${title}" is now added as an active pre-loaded shortcut option inside the left workspace panel list container tray.`);
        }

        function loadTreatmentTemplate(templateKey) {
            const pack = treatmentTemplates[templateKey];
            if (!pack) return;

            selectedComplaints = [...pack.complaints];
            selectedExaminations = [...pack.examination];
            selectedMedicines = [...pack.medicines];
            selectedAdvices = [...pack.advices];

            renderComplaintsView();
            renderExaminationView();
            renderMedicinesView();

            const adviceContainer = document.getElementById('render-advice-target');
            const adviceSection = document.getElementById('live-section-advice');
            adviceContainer.innerHTML = '';
            if (selectedAdvices.length > 0) {
                adviceSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    adviceContainer.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }

            document.querySelectorAll('#advices-badge-grid button').forEach(btn => {
                const text = btn.innerText.trim();
                if (selectedAdvices.includes(text)) {
                    btn.className =
                        "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl shadow-sm cursor-pointer select-none";
                } else {
                    btn.className =
                        "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                }
            });
        }

        // --- PATIENT RUNTIME TRACKERS ---
        function setActivePatient(name, age, gender) {
            document.getElementById('current-patient-label').innerText = name;
            document.getElementById('current-patient-meta').innerText = `${age} Years | ${gender}`;
            document.getElementById('canvas-pt-name').innerText = name;
            document.getElementById('canvas-pt-meta').innerText = `${age} Years | ${gender}`;
            closeModal('patient-session-modal');
        }

        function registerQuickPatient() {
            const name = document.getElementById('new-pt-name').value;
            const age = document.getElementById('new-pt-age').value;
            const gender = document.getElementById('new-pt-gender').value;
            if (!name || !age) {
                alert('Specify necessary inputs parameters fields.');
                return;
            }

            const ledgerContainer = document.getElementById('patient-ledger-list');
            const cardHtml = `
            <div onclick="setActivePatient('${name}', '${age}', '${gender}')" class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all animate-fade-in">
                <div>
                    <h4 class="text-xs font-bold text-slate-900 name-field">${name}</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Age: ${age} • ${gender}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-bold">Select</span>
            </div>`;
            ledgerContainer.insertAdjacentHTML('afterbegin', cardHtml);
            setActivePatient(name, age, gender);
            document.getElementById('quick-patient-form').reset();
        }

        function filterPatientList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('.patient-ledger-card').forEach(card => {
                const name = card.querySelector('.name-field').innerText.toLowerCase();
                card.classList.toggle('hidden', !name.includes(query));
            });
        }

        // --- COMPLAINTS ENGINE HANDLERS ---
        function selectComplaintTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function appendCustomComplaintTag() {
            const value = document.getElementById('custom-complaint-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('complaints-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectComplaintTag(this, '${value}')" class="bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 text-indigo-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-complaint-input').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectComplaintTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- EXAMINATION TRACKERS ---
        function selectExaminationTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function appendCustomExamTag() {
            const value = document.getElementById('custom-exam-name').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectExaminationTag(this, '${value}')" class="bg-blue-50 hover:bg-indigo-600 border border-blue-200 text-blue-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-name').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectExaminationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function appendCustomMetricValue() {
            const value = document.getElementById('custom-exam-metric').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-metrics-grid');
            const btnHtml =
                `<button type="button" onclick="appendExamMetric('${value}')" class="bg-slate-900 text-white hover:bg-black text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-metric').value = '';
            appendExamMetric(value);
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<span class="bg-blue-50/70 border border-blue-100 text-slate-800 font-bold px-2.5 py-1 rounded-xl text-xs shadow-sm">${item.key}: <span class="text-blue-600">${item.val}</span></span>`;
                });
            }
        }

        // --- MEDICINES ENGINE ---
        function stageMedicineItem(btn, drugName) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50',
                    'border-indigo-300'));
                btn.classList.add('bg-indigo-50', 'border-indigo-300');
            }
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function appendCustomMedicineCatalog() {
            const value = document.getElementById('custom-medicine-name').value.trim();
            if (!value) return;
            const catalog = document.getElementById('medicine-catalog-list');
            const btnHtml = `
            <button type="button" onclick="stageMedicineItem(this, '${value}')" class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-indigo-50/30 hover:bg-indigo-50/50 rounded-xl border border-indigo-200 shadow-sm transition-all duration-150 flex items-center space-x-2 group animate-fade-in">
                <span class="text-indigo-400 font-mono text-xs">✨</span>
                <span>${value}</span>
            </button>`;
            catalog.insertAdjacentHTML('afterbegin', btnHtml);
            document.getElementById('custom-medicine-name').value = '';
            const firstBtn = catalog.querySelector('button');
            stageMedicineItem(firstBtn, value);
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1 text-slate-900 font-bold">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- ADVICES PIPELINES ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.className =
                    "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.className =
                    "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none";
                selectedAdvices.push(val);
            }
        }

        function appendCustomAdviceTag() {
            const value = document.getElementById('custom-advice-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('advices-badge-grid');
            const btnHtml =
                `<button type="button" onclick="toggleAdviceTag(this, '${value}')" class="bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            selectedAdvices.push(value);
            document.getElementById('custom-advice-input').value = '';
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>

    <style>
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-zoom-in {
            animation: zoomIn 0.15s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <div onclick="openModal('patient-session-modal')"
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_-3px_rgba(79,70,229,0.15)] hover:border-indigo-300 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center space-x-6">
                <div
                    class="h-12 w-12 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white rounded-xl flex items-center justify-center text-xl shadow-inner transition-colors duration-300">
                    👤
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5 group-hover:text-indigo-500 transition-colors">Active
                        Consultation (Click to Change/Add)</label>
                    <span
                        class="text-lg font-extrabold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors"
                        id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span
                        class="text-sm text-slate-600 font-semibold bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 px-4 py-1 rounded-full transition-colors"
                        id="current-patient-meta">22 Years | Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div
                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                Manage Patients ⚙️
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">

            <div class="col-span-12 lg:col-span-4 space-y-4">

                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm">
                    <h3
                        class="text-xs font-black uppercase tracking-widest text-indigo-600 mb-3 px-1 flex items-center space-x-1">
                        <span>⚡</span> <span>Treatment Plan Templates</span>
                    </h3>
                    <div class="mb-4">
                        <input type="text" oninput="filterTreatmentTemplatesList(this.value)"
                            placeholder="🔍 Search template packages..."
                            class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 transition-all shadow-sm">
                    </div>
                    <div id="ui-templates-container" class="grid grid-cols-1 gap-2 max-h-[200px] overflow-y-auto pr-1">
                        <div class="template-wrapper-item" data-title="standard fever flu protocol">
                            <button type="button" onclick="loadTreatmentTemplate('fever_pack')"
                                class="w-full text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                                <span>HN-01: Standard Fever & Flu</span>
                                <span
                                    class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100 shrink-0 ml-2">Load</span>
                            </button>
                        </div>
                        <div class="template-wrapper-item" data-title="hypertension routine routine high blood pressure">
                            <button type="button" onclick="loadTreatmentTemplate('hypertension_pack')"
                                class="w-full text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                                <span>HN-02: Hypertension Routine</span>
                                <span
                                    class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100 shrink-0 ml-2">Load</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('investigation-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-purple-50 rounded-lg text-purple-600 group-hover:scale-110 transition-transform">🔬</span>
                            <span>Investigations & Tests</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                        <p><strong>Patient Name:</strong> <span id="canvas-pt-name"
                                class="text-slate-900 font-bold">Rabbi</span></p>
                        <p><strong>Demographics:</strong> <span id="canvas-pt-meta" class="text-slate-900 font-medium">22
                                Years | Male</span></p>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="grid grid-cols-12 gap-6 items-start">

                        <div class="col-span-4 space-y-6 border-r border-slate-100 pr-4">
                            <div id="live-section-complaints" class="hidden py-0.5">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Complaints
                                </h4>
                                <div id="render-complaints-target"
                                    class="text-slate-800 space-y-1 font-bold text-xs leading-normal"></div>
                            </div>

                            <div id="live-section-examination" class="hidden py-0.5">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">On
                                    Examination</h4>
                                <div id="render-examination-target"
                                    class="text-slate-800 flex flex-col gap-1 text-xs font-bold"></div>
                            </div>

                            <div id="live-section-investigation" class="hidden py-0.5">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-purple-400 mb-1.5">
                                    Investigations / Tests</h4>
                                <div id="render-investigation-target"
                                    class="text-slate-800 space-y-1 font-bold text-xs leading-normal"></div>
                            </div>
                        </div>

                        <div class="col-span-8 pl-2 space-y-6">
                            <div id="live-section-medication" class="hidden py-0.5">
                                <ol id="render-medication-target"
                                    class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                            </div>

                            <div id="live-section-advice"
                                class="hidden py-0.5 border-t border-dashed border-slate-200 pt-4">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Doctor's
                                    Advice</h4>
                                <ul id="render-advice-target"
                                    class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-12 bg-slate-50 p-4 border border-slate-200/60 rounded-2xl flex flex-col sm:flex-row gap-3 justify-between items-center shadow-inner">
                    <div class="w-full sm:flex-1">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Save
                            Active Configuration Layout</label>
                        <input type="text" id="custom-template-title-input"
                            placeholder="e.g., Diabetes Pack, Gastric Routine..."
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold bg-white outline-none focus:border-indigo-500 shadow-sm">
                    </div>
                    <button type="button" onclick="createNewTreatmentTemplateFromUI()"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest px-5 py-3 rounded-xl transition-all shadow-md active:scale-95 shrink-0 sm:mt-4">
                        Save as Template 💾
                    </button>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-6">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="patient-session-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4"
        onclick="if(event.target === this) closeModal('patient-session-modal')">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-200 max-h-[85vh]">
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4 text-indigo-900">
                    <span>✨</span> <span>Register New Patient</span>
                </h3>
                <form id="quick-patient-form" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full Legal
                            Name</label>
                        <input type="text" id="new-pt-name" placeholder="e.g. Ariful Islam"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age
                                (Years)</label>
                            <input type="number" id="new-pt-age" placeholder="25"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select id="new-pt-gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white cursor-pointer">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                            Number</label>
                        <input type="text" id="new-pt-phone" placeholder="01737541930"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="button" onclick="registerQuickPatient()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all transform active:scale-95">
                        Save & Activate Profile
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider text-slate-400">Switch Patient
                        Profile</h3>
                    <button type="button" onclick="closeModal('patient-session-modal')"
                        class="text-slate-400 hover:text-slate-600 font-bold text-sm h-6 w-6 rounded-full hover:bg-slate-100 flex items-center justify-center">✕</button>
                </div>
                <input type="text" oninput="filterPatientList(this.value)"
                    placeholder="🔍 Search current patient registry..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div id="patient-ledger-list" class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <div onclick="setActivePatient('Rabbi', '22', 'Male')"
                        class="patient-ledger-card p-3 border border-indigo-100 bg-indigo-50/40 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-500 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Rabbi</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 22 • Male • 01737541930</p>
                        </div>
                        <span
                            class="text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div id="complaints-badge-grid" class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer select-none shadow-sm">{{ $tag }}</button>
                    @endforeach
                </div>

                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration parameter
                        for: <span id="active-complaint-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-complaint-input" placeholder="Add Custom Complaint..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-56">
                    <button type="button" onclick="appendCustomComplaintTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Tag</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('complaints-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase transition-colors">Cancel</button>
                    <button type="button" onclick="saveComplaintsPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md transition-all">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="examination-badge-grid" class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all hover:bg-indigo-600 hover:text-white shadow-sm cursor-pointer select-none">{{ $exam }}</button>
                    @endforeach
                </div>
                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div id="examination-metrics-grid" class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <div class="flex gap-1.5">
                        <input type="text" id="custom-exam-name" placeholder="New Exam Name..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-36">
                        <button type="button" onclick="appendCustomExamTag()"
                            class="bg-slate-900 hover:bg-black text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Exam</button>
                    </div>
                    <div class="flex gap-1.5 border-l pl-2 border-slate-200">
                        <input type="text" id="custom-exam-metric" placeholder="New Metric Val..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-32">
                        <button type="button" onclick="appendCustomMetricValue()"
                            class="bg-slate-700 hover:bg-slate-800 text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Metric</button>
                    </div>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('examination-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveExaminationPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="investigation-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🔬</span> <span>Select Investigations & Lab Tests</span>
                </h3>
                <button type="button" onclick="closeModal('investigation-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="🔍 Filter laboratory parameters or scanning codes..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="investigation-badge-grid" class="flex flex-wrap gap-2">
                    @php $tests = ['CBC', 'Serum Creatinine', 'RBS', 'S. Cholesterol', 'SGPT', 'TSH', 'Urine R/E', 'X-Ray Chest PA View', 'USG of Whole Abdomen', 'ECG', 'HbA1c', 'Lipid Profile', 'Serum Bilirubin']; @endphp
                    @foreach ($tests as $test)
                        <button type="button" onclick="selectInvestigationTag(this, '{{ $test }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all hover:bg-purple-600 hover:text-white shadow-sm cursor-pointer select-none">{{ $test }}</button>
                    @endforeach
                </div>

                <div id="investigation-result-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Lab Results for:
                        <span id="active-investigation-label"
                            class="text-purple-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="investigation-result-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                        placeholder="e.g. 11.5 gm/dL or Normal">
                    <div class="flex flex-wrap gap-1.5">
                        @php $resTemplates = ['Normal', 'Elevated', 'Pending Result', 'Attached Report', 'Borderline', 'Negative', 'Positive']; @endphp
                        @foreach ($resTemplates as $resT)
                            <button type="button"
                                onclick="document.getElementById('investigation-result-input').value='{{ $resT }}'"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $resT }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-investigation-input" placeholder="Add Custom Test Catalog Name..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-64">
                    <button type="button" onclick="appendCustomInvestigationTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Test</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('investigation-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveInvestigationPipeline()"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Test</button>
                </div>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div
                    class="col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 flex flex-col justify-between">
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                            Inventory</h4>
                        <div id="medicine-catalog-list" class="flex flex-col space-y-1.5 pr-1">
                            @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                            @foreach ($drugs as $drug)
                                <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                    class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                    <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                    <span>{{ $drug }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-200/80 mt-4 bg-white -mx-5 -mb-5 p-4 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400">Add Custom
                            Molecule Formula</label>
                        <div class="flex gap-2">
                            <input type="text" id="custom-medicine-name" placeholder="Form, Molecule, Strength..."
                                class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-semibold shadow-sm w-full">
                            <button type="button" onclick="appendCustomMedicineCatalog()"
                                class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl tracking-wide shadow active:scale-95 shrink-0">Inventory</button>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">দুপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g. জ্বর থাকলে">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                            </div>
                        </div>
                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>
                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix ledger.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div id="advices-badge-grid" class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-advice-input" placeholder="Type Custom Care Advice..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-72">
                    <button type="button" onclick="appendCustomAdviceTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Guideline</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('advice-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveAdvicePipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Advice</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // System Local Framework Storage Memory Collections Array Map
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedInvestigations = []; // NEW: Array mapper for active labs array list tracker
        let selectedMedicines = [];
        let selectedAdvices = [];
        let currentTargetTag = '';

        // Modal Dynamic Layer State Window Controllers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- TREATMENT TEMPLATE ARCHITECTURE LEDGER ENGINE ---
        const treatmentTemplates = {
            fever_pack: {
                title: 'HN-01: Standard Fever & Flu',
                complaints: [{
                    condition: 'Fever',
                    duration: '3 Days'
                }, {
                    condition: 'Cough',
                    duration: '5 Days'
                }],
                examination: [{
                    key: 'Temperature',
                    val: '102°F'
                }, {
                    key: 'Pulse',
                    val: '92 bpm'
                }],
                investigations: [{
                    code: 'CBC',
                    result: 'Hb: 11.2 gm/dL'
                }],
                medicines: [{
                    name: 'Napa (Tablet, 500 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের পরে',
                    duration: '৫ দিন',
                    instruction: 'জ্বর থাকলে খাবেন'
                }],
                advices: ['পানি বেশি করে খাবেন', '৭ দিন বেড রেস্ট করবেন']
            },
            hypertension_pack: {
                title: 'HN-02: Hypertension Routine',
                complaints: [{
                    condition: 'Headache',
                    duration: '1 Week'
                }],
                examination: [{
                    key: 'Blood Pressure',
                    val: '160/95 mmHg'
                }],
                investigations: [{
                    code: 'Serum Creatinine',
                    result: '0.9 mg/dL (Normal)'
                }],
                medicines: [{
                    name: 'Indever (Tablet, 10 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের আগে',
                    duration: '১ মাস',
                    instruction: 'নিয়মিত চলবে'
                }],
                advices: ['তেল জাতীয় খাবার খাবেন না', 'নিয়মিত ওষুধ খাবেন']
            }
        };

        function filterTreatmentTemplatesList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('#ui-templates-container .template-wrapper-item').forEach(item => {
                const indexTitle = item.getAttribute('data-title');
                item.classList.toggle('hidden', !indexTitle.includes(query));
            });
        }

        function createNewTreatmentTemplateFromUI() {
            const titleInput = document.getElementById('custom-template-title-input');
            const title = titleInput.value.trim();

            if (!title) {
                alert('Specify template label name first.');
                return;
            }
            if (selectedComplaints.length === 0 && selectedMedicines.length === 0) {
                alert('Cannot register empty datasets packages template context.');
                return;
            }

            const uniqueKey = 'custom_pack_' + Date.now();

            treatmentTemplates[uniqueKey] = {
                title: title,
                complaints: [...selectedComplaints],
                examination: [...selectedExaminations],
                investigations: [...selectedInvestigations],
                medicines: [...selectedMedicines],
                advices: [...selectedAdvices]
            };

            const leftContainer = document.getElementById('ui-templates-container');
            const dataSearchMeta = title.toLowerCase().replace(/[^a-z0-9 ]/g, '');

            const customButtonHtml = `
            <div class="template-wrapper-item" data-title="${dataSearchMeta}">
                <button type="button" onclick="loadTreatmentTemplate('${uniqueKey}')" class="w-full text-left text-xs font-bold px-4 py-3 bg-emerald-50/60 hover:bg-indigo-600 text-emerald-950 hover:text-white border border-emerald-100 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95 scale-95 animate-zoom-in">
                    <span>📋 ${title}</span>
                    <span class="text-[10px] bg-white text-emerald-700 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-emerald-100 tracking-wide uppercase shrink-0 ml-2">Load</span>
                </button>
            </div>`;

            leftContainer.insertAdjacentHTML('beforeend', customButtonHtml);
            titleInput.value = '';
        }

        function loadTreatmentTemplate(templateKey) {
            const pack = treatmentTemplates[templateKey];
            if (!pack) return;

            selectedComplaints = [...pack.complaints];
            selectedExaminations = [...pack.examination];
            selectedInvestigations = pack.investigations ? [...pack.investigations] : [];
            selectedMedicines = [...pack.medicines];
            selectedAdvices = [...pack.advices];

            renderComplaintsView();
            renderExaminationView();
            renderInvestigationsView(); // Refresh laboratory section parameters mappings
            renderMedicinesView();

            const adviceContainer = document.getElementById('render-advice-target');
            const adviceSection = document.getElementById('live-section-advice');
            adviceContainer.innerHTML = '';
            if (selectedAdvices.length > 0) {
                adviceSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    adviceContainer.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
        }

        // --- PATIENT RUNTIME ASSIGNMENTS ---
        function setActivePatient(name, age, gender) {
            document.getElementById('current-patient-label').innerText = name;
            document.getElementById('current-patient-meta').innerText = `${age} Years | ${gender}`;
            document.getElementById('canvas-pt-name').innerText = name;
            document.getElementById('canvas-pt-meta').innerText = `${age} Years | ${gender}`;
            closeModal('patient-session-modal');
        }

        function registerQuickPatient() {
            const name = document.getElementById('new-pt-name').value;
            const age = document.getElementById('new-pt-age').value;
            const gender = document.getElementById('new-pt-gender').value;
            if (!name || !age) {
                alert('Provide essential details parameters fields logs.');
                return;
            }

            const ledgerContainer = document.getElementById('patient-ledger-list');
            const cardHtml = `
            <div onclick="setActivePatient('${name}', '${age}', '${gender}')" class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all animate-fade-in">
                <div>
                    <h4 class="text-xs font-bold text-slate-900 name-field">${name}</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Age: ${age} • ${gender}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-bold">Select</span>
            </div>`;
            ledgerContainer.insertAdjacentHTML('afterbegin', cardHtml);
            setActivePatient(name, age, gender);
            document.getElementById('quick-patient-form').reset();
        }

        function filterPatientList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('.patient-ledger-card').forEach(card => {
                const name = card.querySelector('.name-field').innerText.toLowerCase();
                card.classList.toggle('hidden', !name.includes(query));
            });
        }

        // --- COMPLAINTS ENGINE PIPELINES ---
        function selectComplaintTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function appendCustomComplaintTag() {
            const value = document.getElementById('custom-complaint-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('complaints-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectComplaintTag(this, '${value}')" class="bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 text-indigo-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all duration-150 scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-complaint-input').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectComplaintTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- EXAMINATION FINDINGS PIPELINES ---
        function selectExaminationTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function appendCustomExamTag() {
            const value = document.getElementById('custom-exam-name').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectExaminationTag(this, '${value}')" class="bg-blue-50 hover:bg-indigo-600 border border-blue-200 text-blue-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-name').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectExaminationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function appendCustomMetricValue() {
            const value = document.getElementById('custom-exam-metric').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-metrics-grid');
            const btnHtml =
                `<button type="button" onclick="appendExamMetric('${value}')" class="bg-slate-900 text-white hover:bg-black text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-metric').value = '';
            appendExamMetric(value);
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<div class="text-slate-800 py-0.5 text-xs font-bold">• ${item.key}: <span class="text-indigo-600">${item.val}</span></div>`;
                });
            }
        }

        // --- NEW: MODULE 2.5: INVESTIGATIONS LAB TEST CONTROLLERS ---
        function selectInvestigationTag(btn, testCode) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-purple-600', 'text-white'));
                btn.classList.add('bg-purple-600', 'text-white');
            }
            currentTargetTag = testCode;
            document.getElementById('active-investigation-label').innerText = testCode;
            document.getElementById('investigation-result-input').value = '';
            document.getElementById('investigation-result-builder').classList.remove('hidden');
        }

        function appendCustomInvestigationTag() {
            const value = document.getElementById('custom-investigation-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('investigation-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectInvestigationTag(this, '${value}')" class="bg-purple-50 hover:bg-purple-600 border border-purple-200 text-purple-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-investigation-input').value = '';

            const spawnedButtons = grid.querySelectorAll('button');
            selectInvestigationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveInvestigationPipeline() {
            const testResult = document.getElementById('investigation-result-input').value || 'Normal';
            if (currentTargetTag) {
                selectedInvestigations = selectedInvestigations.filter(item => item.code !== currentTargetTag);
                selectedInvestigations.push({
                    code: currentTargetTag,
                    result: testResult
                });
                renderInvestigationsView();
            }
            document.getElementById('investigation-result-builder').classList.add('hidden');
            closeModal('investigation-modal');
        }

        function renderInvestigationsView() {
            const container = document.getElementById('render-investigation-target');
            const rootSection = document.getElementById('live-section-investigation');
            container.innerHTML = '';
            if (selectedInvestigations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedInvestigations.forEach(item => {
                    container.innerHTML +=
                        `<div class="text-slate-900 py-0.5 text-xs font-bold">• ${item.code} <span class="text-purple-600 font-medium ml-1">[${item.result}]</span></div>`;
                });
            }
        }

        // --- RX MEDICATION PLAN ENGINE ---
        function stageMedicineItem(btn, drugName) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50',
                    'border-indigo-300'));
                btn.classList.add('bg-indigo-50', 'border-indigo-300');
            }
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function appendCustomMedicineCatalog() {
            const value = document.getElementById('custom-medicine-name').value.trim();
            if (!value) return;
            const catalog = document.getElementById('medicine-catalog-list');
            const btnHtml = `
            <button type="button" onclick="stageMedicineItem(this, '${value}')" class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-indigo-50/30 hover:bg-indigo-50/50 rounded-xl border border-indigo-200 shadow-sm transition-all duration-150 flex items-center space-x-2 group animate-fade-in">
                <span class="text-indigo-400 font-mono text-xs">✨</span>
                <span>${value}</span>
            </button>`;
            catalog.insertAdjacentHTML('afterbegin', btnHtml);
            document.getElementById('custom-medicine-name').value = '';
            const firstBtn = catalog.querySelector('button');
            stageMedicineItem(firstBtn, value);
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1 text-slate-900 font-bold">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- ADVICES PIPELINES ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.className =
                    "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.className =
                    "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none";
                selectedAdvices.push(val);
            }
        }

        function appendCustomAdviceTag() {
            const value = document.getElementById('custom-advice-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('advices-badge-grid');
            const btnHtml =
                `<button type="button" onclick="toggleAdviceTag(this, '${value}')" class="bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            selectedAdvices.push(value);
            document.getElementById('custom-advice-input').value = '';
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>

    <style>
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-zoom-in {
            animation: zoomIn 0.15s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>
@endsection --}}


@extends('layouts.app')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen text-slate-800 -m-8 p-8">

        <div onclick="openModal('patient-session-modal')"
            class="bg-white border border-slate-200/80 rounded-2xl p-5 mb-8 flex justify-between items-center shadow-[0_2px_12px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_-3px_rgba(79,70,229,0.15)] hover:border-indigo-300 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center space-x-6">
                <div
                    class="h-12 w-12 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white rounded-xl flex items-center justify-center text-xl shadow-inner transition-colors duration-300">
                    👤
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5 group-hover:text-indigo-500 transition-colors">Active
                        Consultation (Click to Change/Add)</label>
                    <span
                        class="text-lg font-extrabold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors"
                        id="current-patient-label">Rabbi</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center">
                    <span
                        class="text-sm text-slate-600 font-semibold bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 px-4 py-1 rounded-full transition-colors"
                        id="current-patient-meta">22 Years | Male</span>
                </div>
                <div class="border-l border-slate-200 pl-6 h-8 flex items-center hidden md:flex">
                    <span class="text-xs text-slate-400 font-mono tracking-wider">📅 Date: {{ date('d M, Y') }}</span>
                </div>
            </div>
            <div
                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                Manage Patients ⚙️
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">

            <div class="col-span-12 lg:col-span-4 space-y-4">

                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm">
                    <h3
                        class="text-xs font-black uppercase tracking-widest text-indigo-600 mb-3 px-1 flex items-center space-x-1">
                        <span>⚡</span> <span>Treatment Plan Templates</span>
                    </h3>
                    <div class="mb-4">
                        <input type="text" oninput="filterTreatmentTemplatesList(this.value)"
                            placeholder="🔍 Search template packages..."
                            class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 transition-all shadow-sm">
                    </div>
                    <div id="ui-templates-container" class="grid grid-cols-1 gap-2 max-h-[180px] overflow-y-auto pr-1">
                        <div class="template-wrapper-item" data-title="standard fever flu protocol">
                            <button type="button" onclick="loadTreatmentTemplate('fever_pack')"
                                class="w-full text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                                <span>HN-01: Standard Fever & Flu</span>
                                <span
                                    class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100 shrink-0 ml-2">Load</span>
                            </button>
                        </div>
                        <div class="template-wrapper-item" data-title="hypertension routine routine high blood pressure">
                            <button type="button" onclick="loadTreatmentTemplate('hypertension_pack')"
                                class="w-full text-left text-xs font-bold px-4 py-3 bg-indigo-50/50 hover:bg-indigo-600 text-indigo-950 hover:text-white border border-indigo-100/80 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95">
                                <span>HN-02: Hypertension Routine</span>
                                <span
                                    class="text-[10px] bg-white text-indigo-600 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-indigo-100 shrink-0 ml-2">Load</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 px-1">Prescription Modules
                    </h3>

                    <button type="button" onclick="openModal('complaints-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:scale-110 transition-transform">🤢</span>
                            <span>Patient Complaints</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('examination-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:scale-110 transition-transform">🩺</span>
                            <span>On Examination</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('diagnosis-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-rose-50 rounded-lg text-rose-600 group-hover:scale-110 transition-transform">🎯</span>
                            <span>Diagnosis / Impressions</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('investigation-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-purple-50 rounded-lg text-purple-600 group-hover:scale-110 transition-transform">🔬</span>
                            <span>Investigations & Tests</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('medicine-modal')"
                        class="w-full flex justify-between items-center bg-gradient-to-r from-indigo-900 to-slate-900 hover:from-indigo-950 hover:to-black p-4 rounded-xl font-bold text-sm text-white transition-all duration-200 group shadow-md mb-2.5">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-white/10 rounded-lg text-indigo-300 group-hover:rotate-12 transition-transform">💊</span>
                            <span class="tracking-wide">Rₓ Medication Plan</span>
                        </div>
                        <span
                            class="bg-white/20 group-hover:bg-emerald-500 h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>

                    <button type="button" onclick="openModal('advice-modal')"
                        class="w-full flex justify-between items-center bg-white border border-slate-100 hover:border-indigo-500 hover:bg-indigo-50/20 p-4 rounded-xl font-bold text-sm text-slate-700 transition-all duration-200 group shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span
                                class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:scale-110 transition-transform">🍏</span>
                            <span>Advices & Diet Plans</span>
                        </div>
                        <span
                            class="text-indigo-500 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white h-6 w-6 rounded-md flex items-center justify-center font-bold text-sm transition-all shadow-sm">⊕</span>
                    </button>
                </div>
            </div>

            <div
                class="col-span-12 lg:col-span-8 bg-white border border-slate-200/60 rounded-3xl p-10 min-h-[700px] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div>
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">DR. JOHN DOE, MD</h2>
                            <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mt-0.5">Cardiology &
                                Internal Medicine</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-400 font-medium leading-relaxed">
                            <p class="font-bold text-slate-700">Metro Health Complex</p>
                            <p>Clinical Wing Alpha, Dhaka</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs grid grid-cols-2 gap-2 mb-6">
                        <p><strong>Patient Name:</strong> <span id="canvas-pt-name"
                                class="text-slate-900 font-bold">Rabbi</span></p>
                        <p><strong>Demographics:</strong> <span id="canvas-pt-meta" class="text-slate-900 font-medium">22
                                Years | Male</span></p>
                    </div>

                    <div class="mb-6">
                        <span
                            class="text-4xl font-serif font-black bg-gradient-to-br from-indigo-600 to-indigo-900 bg-clip-text text-transparent select-none">Rₓ</span>
                    </div>

                    <div class="grid grid-cols-12 gap-6 items-start">

                        <div class="col-span-4 space-y-6 border-r border-slate-100 pr-4">
                            <div id="live-section-complaints" class="hidden py-0.5">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Complaints
                                </h4>
                                <div id="render-complaints-target"
                                    class="text-slate-800 space-y-1 font-bold text-xs leading-normal"></div>
                            </div>

                            <div id="live-section-diagnosis" class="hidden py-0.5">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-rose-500 mb-1.5">Diagnosis
                                </h4>
                                <div id="render-diagnosis-target"
                                    class="text-slate-900 space-y-1 font-extrabold text-xs leading-normal italic"></div>
                            </div>

                            <div id="live-section-examination" class="hidden py-0.5">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">On
                                    Examination</h4>
                                <div id="render-examination-target"
                                    class="text-slate-800 flex flex-col gap-1 text-xs font-bold"></div>
                            </div>

                            <div id="live-section-investigation" class="hidden py-0.5">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-purple-400 mb-1.5">
                                    Investigations / Tests</h4>
                                <div id="render-investigation-target"
                                    class="text-slate-800 space-y-1 font-bold text-xs leading-normal"></div>
                            </div>
                        </div>

                        <div class="col-span-8 pl-2 space-y-6">
                            <div id="live-section-medication" class="hidden py-0.5">
                                <ol id="render-medication-target"
                                    class="list-decimal pl-4 font-bold space-y-4 text-slate-900 text-sm"></ol>
                            </div>

                            <div id="live-section-advice"
                                class="hidden py-0.5 border-t border-dashed border-slate-200 pt-4">
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Doctor's
                                    Advice</h4>
                                <ul id="render-advice-target"
                                    class="list-disc pl-4 text-slate-700 font-medium space-y-1.5 text-xs"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-12 bg-slate-50 p-4 border border-slate-200/60 rounded-2xl flex flex-col sm:flex-row gap-3 justify-between items-center shadow-inner">
                    <div class="w-full sm:flex-1">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Save
                            Active Configuration Layout</label>
                        <input type="text" id="custom-template-title-input"
                            placeholder="e.g., Diabetes Pack, Gastric Routine..."
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold bg-white outline-none focus:border-indigo-500 shadow-sm">
                    </div>
                    <button type="button" onclick="createNewTreatmentTemplateFromUI()"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest px-5 py-3 rounded-xl transition-all shadow-md active:scale-95 shrink-0 sm:mt-4">
                        Save as Template 💾
                    </button>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end space-x-3 mt-6">
                    <button type="button"
                        class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 transition-all uppercase tracking-wider shadow-sm">
                        Save Record
                    </button>
                    <button type="button"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black hover:from-emerald-700 hover:to-teal-700 transition-all uppercase tracking-widest shadow-md hover:shadow-lg transform active:scale-95">
                        Print + Finalize Document 🖨️
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="patient-session-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4"
        onclick="if(event.target === this) closeModal('patient-session-modal')">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-12 overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-200 max-h-[85vh]">
            <div class="md:col-span-5 bg-slate-50/80 p-6 border-r border-slate-100 overflow-y-auto">
                <h3
                    class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center space-x-2 mb-4 text-indigo-900">
                    <span>✨</span> <span>Register New Patient</span>
                </h3>
                <form id="quick-patient-form" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full Legal
                            Name</label>
                        <input type="text" id="new-pt-name" placeholder="e.g. Ariful Islam"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age
                                (Years)</label>
                            <input type="number" id="new-pt-age" placeholder="25"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                            <select id="new-pt-gender"
                                class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white cursor-pointer">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                            Number</label>
                        <input type="text" id="new-pt-phone" placeholder="01737541930"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <button type="button" onclick="registerQuickPatient()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all transform active:scale-95">
                        Save & Activate Profile
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 p-6 flex flex-col bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider text-slate-400">Switch Patient
                        Profile</h3>
                    <button type="button" onclick="closeModal('patient-session-modal')"
                        class="text-slate-400 hover:text-slate-600 font-bold text-sm h-6 w-6 rounded-full hover:bg-slate-100 flex items-center justify-center">✕</button>
                </div>
                <input type="text" oninput="filterPatientList(this.value)"
                    placeholder="🔍 Search current patient registry..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-medium transition-all mb-4">
                <div id="patient-ledger-list" class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <div onclick="setActivePatient('Rabbi', '22', 'Male')"
                        class="patient-ledger-card p-3 border border-indigo-100 bg-indigo-50/40 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-500 transition-all">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 name-field">Rabbi</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Age: 22 • Male • 01737541930</p>
                        </div>
                        <span
                            class="text-xs text-indigo-600 font-bold bg-white border border-indigo-200 px-2 py-0.5 rounded-md shadow-sm">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="complaints-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🤢</span> <span>Select Patient Complaints</span>
                </h3>
                <button type="button" onclick="closeModal('complaints-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="Search or filter medical indicators instantly..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-white">
                <div id="complaints-badge-grid" class="flex flex-wrap gap-2">
                    @php $complaints = ['Fever', 'Weakness', 'Cough', 'Memory loss', 'Vomiting', 'Chest pain', 'Itching', 'Swelling of legs', 'Sleep disturbances', 'Abdominal pain', 'Vaginal discharge', 'Constipation', 'Headache', 'Pain', 'Mood swings', 'Nasal congestion', 'Noisy breathing', 'Diarrhea', 'Back pain', 'Loss of appetite', 'Sore throat', 'Acne', 'Weight loss']; @endphp
                    @foreach ($complaints as $tag)
                        <button type="button" onclick="selectComplaintTag(this, '{{ $tag }}')"
                            class="bg-slate-50 hover:bg-indigo-600 border border-slate-200/60 text-slate-700 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer select-none shadow-sm">{{ $tag }}</button>
                    @endforeach
                </div>

                <div id="complaint-duration-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Duration parameter
                        for: <span id="active-complaint-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="complaint-duration-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 3 days">
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php $durations = ['3 days', '7 days', '1 month', '15 day', '4 day', 'Dry', 'for 5 days', '2 months', '1 week']; @endphp
                        @foreach ($durations as $dur)
                            <button type="button" onclick="appendDurationValue('{{ $dur }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $dur }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-complaint-input" placeholder="Add Custom Complaint..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-56">
                    <button type="button" onclick="appendCustomComplaintTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Tag</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('complaints-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase transition-colors">Cancel</button>
                    <button type="button" onclick="saveComplaintsPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md transition-all">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="examination-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🩺</span> <span>On Examination Diagnostics Matrix</span>
                </h3>
                <button type="button" onclick="closeModal('examination-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="examination-badge-grid" class="flex flex-wrap gap-2">
                    @php $exams = ['Temperature', 'Blood Pressure', 'Weight', 'Dehydration', 'Breath sounds', 'Anemia', 'Spleen', 'Pulse', 'Respiratory Rate', 'Oxygen Saturation', 'JVP', 'Lungs- clear']; @endphp
                    @foreach ($exams as $exam)
                        <button type="button" onclick="selectExaminationTag(this, '{{ $exam }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all hover:bg-indigo-600 hover:text-white shadow-sm cursor-pointer select-none">{{ $exam }}</button>
                    @endforeach
                </div>
                <div id="exam-value-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Metrics parameters
                        for: <span id="active-exam-label"
                            class="text-indigo-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="exam-value-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:border-indigo-500 transition-all"
                        placeholder="e.g. 102 F">
                    <div id="examination-metrics-grid" class="flex flex-wrap gap-1.5">
                        @php $metrics = ['Normal', '100°F', '101 F', '98.4', '103 F', 'Normal(96.3)', '120/80 mmHg']; @endphp
                        @foreach ($metrics as $met)
                            <button type="button" onclick="appendExamMetric('{{ $met }}')"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $met }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <div class="flex gap-1.5">
                        <input type="text" id="custom-exam-name" placeholder="New Exam Name..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-36">
                        <button type="button" onclick="appendCustomExamTag()"
                            class="bg-slate-900 hover:bg-black text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Exam</button>
                    </div>
                    <div class="flex gap-1.5 border-l pl-2 border-slate-200">
                        <input type="text" id="custom-exam-metric" placeholder="New Metric Val..."
                            class="border border-slate-200 rounded-xl px-2.5 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-32">
                        <button type="button" onclick="appendCustomMetricValue()"
                            class="bg-slate-700 hover:bg-slate-800 text-white px-2.5 py-2 text-xs font-bold rounded-xl shadow transition-all active:scale-95 shrink-0">+
                            Metric</button>
                    </div>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('examination-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveExaminationPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div id="diagnosis-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🎯</span> <span>Select Clinical Diagnosis</span>
                </h3>
                <button type="button" onclick="closeModal('diagnosis-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="🔍 Quick search standard system clinical entries..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div id="diagnosis-badge-grid" class="flex flex-wrap gap-2">
                    @php $diagnoses = ['Acute Viral Fever', 'Hypertension (HTN)', 'Type 2 Diabetes Mellitus', 'Acute Gastritis', 'Bronchial Asthma', 'Dermatitis', 'Urinary Tract Infection (UTI)', 'Migraine', 'Allergic Rhinitis', 'Enteric Fever', 'Upper Respiratory Tract Infection (URTI)']; @endphp
                    @foreach ($diagnoses as $diag)
                        <button type="button" onclick="toggleDiagnosisTag(this, '{{ $diag }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 shadow-sm cursor-pointer select-none">{{ $diag }}</button>
                    @endforeach
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-diagnosis-input" placeholder="Type Custom Medical Diagnosis..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-64">
                    <button type="button" onclick="appendCustomDiagnosisTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Diagnosis</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('diagnosis-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveDiagnosisPipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Diagnosis</button>
                </div>
            </div>
        </div>
    </div>

    <div id="investigation-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🔬</span> <span>Select Investigations & Lab Tests</span>
                </h3>
                <button type="button" onclick="closeModal('investigation-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-4 border-b border-slate-100 bg-white">
                <input type="text" placeholder="🔍 Filter laboratory parameters or scanning codes..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs bg-slate-50 outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-medium transition-all">
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-white">
                <div id="investigation-badge-grid" class="flex flex-wrap gap-2">
                    @php $tests = ['CBC', 'Serum Creatinine', 'RBS', 'S. Cholesterol', 'SGPT', 'TSH', 'Urine R/E', 'X-Ray Chest PA View', 'USG of Whole Abdomen', 'ECG', 'HbA1c', 'Lipid Profile', 'Serum Bilirubin']; @endphp
                    @foreach ($tests as $test)
                        <button type="button" onclick="selectInvestigationTag(this, '{{ $test }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all hover:bg-purple-600 hover:text-white shadow-sm cursor-pointer select-none">{{ $test }}</button>
                    @endforeach
                </div>
                <div id="investigation-result-builder"
                    class="hidden bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 shadow-inner">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Configure Lab Results for:
                        <span id="active-investigation-label"
                            class="text-purple-600 underline font-extrabold ml-1"></span></span>
                    <input type="text" id="investigation-result-input"
                        class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-white shadow-sm outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                        placeholder="e.g. 11.5 gm/dL or Normal">
                    <div class="flex flex-wrap gap-1.5">
                        @php $resTemplates = ['Normal', 'Elevated', 'Pending Result', 'Attached Report', 'Borderline', 'Negative', 'Positive']; @endphp
                        @foreach ($resTemplates as $resT)
                            <button type="button"
                                onclick="document.getElementById('investigation-result-input').value='{{ $resT }}'"
                                class="bg-white hover:bg-slate-900 border border-slate-200 text-slate-800 hover:text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95">{{ $resT }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-investigation-input" placeholder="Add Custom Test Catalog Name..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-64">
                    <button type="button" onclick="appendCustomInvestigationTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Test</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('investigation-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveInvestigationPipeline()"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Test</button>
                </div>
            </div>
        </div>
    </div>

    <div id="medicine-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">💊</span> <span>Rₓ Formulations Treatment Flow Scheduler</span>
                </h3>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>

            <div class="grid grid-cols-12 flex-1 overflow-hidden">
                <div
                    class="col-span-12 md:col-span-5 border-r border-slate-100 p-5 overflow-y-auto bg-slate-50/60 flex flex-col justify-between">
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Common Catalog
                            Inventory</h4>
                        <div id="medicine-catalog-list" class="flex flex-col space-y-1.5 pr-1">
                            @php $drugs = ['Napa (Tablet, 500 mg)', 'Indever (Tablet, 10 mg)', 'Bislol (Tablet, 2.5 mg)', 'Ace (Syrup, 120mg/5 ml)', 'Betaloc (Tablet, 50 mg)', 'Azithrocin (Tablet, 500 mg)']; @endphp
                            @foreach ($drugs as $drug)
                                <button type="button" onclick="stageMedicineItem(this, '{{ $drug }}')"
                                    class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-white hover:bg-indigo-50/50 rounded-xl border border-slate-100 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                                    <span class="text-slate-300 group-hover:text-indigo-500 font-mono text-xs">🗂️</span>
                                    <span>{{ $drug }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-200/80 mt-4 bg-white -mx-5 -mb-5 p-4 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400">Add Custom
                            Molecule Formula</label>
                        <div class="flex gap-2">
                            <input type="text" id="custom-medicine-name" placeholder="Form, Molecule, Strength..."
                                class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-slate-50 outline-none focus:bg-white focus:border-indigo-500 font-semibold shadow-sm w-full">
                            <button type="button" onclick="appendCustomMedicineCatalog()"
                                class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl tracking-wide shadow active:scale-95 shrink-0">Inventory</button>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-7 p-6 overflow-y-auto space-y-6 bg-white flex flex-col justify-center">
                    <div id="med-scheduler-panel" class="hidden space-y-5">
                        <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3"
                            id="scheduled-med-title">Tab. Napa</h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Interval
                                Schedule Parameters</label>
                            <div
                                class="grid grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner">
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">সকাল</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">দুপুর</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox" checked
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">রাত</label>
                                <label
                                    class="flex flex-col items-center p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold cursor-pointer hover:border-indigo-500 select-none transition-colors"><input
                                        type="checkbox"
                                        class="rounded border-slate-300 text-indigo-600 mb-1.5 h-4 w-4">বিকাল</label>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <input type="text" id="dose-qty-1" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-2" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-3" value="1"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                                <input type="text" id="dose-qty-4" value="0"
                                    class="border border-slate-200 font-extrabold text-center p-3 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Meal
                                    Relation</label>
                                <select id="med-timing-select"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm cursor-pointer outline-none focus:bg-white focus:border-indigo-500">
                                    <option value="খাবারের পরে">খাবারের পরে (After Food)</option>
                                    <option value="খাবারের আগে">খাবারের আগে (Before Food)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="text" id="med-duration-input" value="৭ দিন"
                                    class="w-full border border-slate-200 p-3 text-xs font-bold rounded-xl bg-slate-50 shadow-sm outline-none focus:bg-white focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Custom
                                Administration Instructions</label>
                            <input type="text" id="med-instruction-input"
                                class="w-full border border-slate-200 p-3 text-xs font-semibold rounded-xl outline-none focus:border-indigo-500 shadow-sm"
                                placeholder="e.g. জ্বর থাকলে">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='জ্বর থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">জ্বর
                                    থাকলে</button>
                                <button type="button"
                                    onclick="document.getElementById('med-instruction-input').value='ব্যথা থাকলে'"
                                    class="bg-slate-100 hover:bg-slate-900 border border-slate-200/80 text-[10px] text-slate-700 hover:text-white font-bold px-2.5 py-1.5 rounded-lg transition-colors shadow-sm active:scale-95">ব্যথা
                                    থাকলে</button>
                            </div>
                        </div>
                        <button type="button" onclick="commitMedicineToStack()"
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest shadow-md transition-colors pt-4 active:scale-95">Add
                            Entry to Plan</button>
                    </div>
                    <div id="med-placeholder-notice" class="text-center py-20 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📥</div>
                        <p class="font-medium text-slate-400">Select a molecule formula from the inventory menu stack
                            matrix ledger.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                <button type="button" onclick="closeModal('medicine-modal')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Done</button>
            </div>
        </div>
    </div>

    <div id="advice-modal"
        class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-md flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900 text-base flex items-center space-x-2">
                    <span class="text-lg">🍏</span> <span>Select Dietary & Care Advices</span>
                </h3>
                <button type="button" onclick="closeModal('advice-modal')"
                    class="text-slate-400 hover:text-slate-600 h-8 w-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold transition-all">✕</button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-white">
                <div id="advices-badge-grid" class="flex flex-wrap gap-2.5">
                    @php $advices = ['পানি বেশি করে খাবেন', 'ভারী ওজন বহন করবেন না', 'তেল জাতীয় খাবার খাবেন না', 'হাই কমোড ব্যবহার করবেন', 'গরম পানির শেক দিবেন', 'নখ দিয়ে খোঁচাবেন না', 'বেশি করে তরল খাবার খাবেন', '৭ দিন বেড রেস্ট করবেন', 'নিয়মিত ওষুধ খাবেন', 'হালকা, সহজপাচ্য খাবার খেতে চেষ্টা করুন']; @endphp
                    @foreach ($advices as $adv)
                        <button type="button" onclick="toggleAdviceTag(this, '{{ $adv }}')"
                            class="bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none">{{ $adv }}</button>
                    @endforeach
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex w-full sm:w-auto gap-2">
                    <input type="text" id="custom-advice-input" placeholder="Type Custom Care Advice..."
                        class="border border-slate-200 rounded-xl px-3 py-2 text-xs bg-white outline-none focus:border-indigo-500 font-medium shadow-sm w-full sm:w-72">
                    <button type="button" onclick="appendCustomAdviceTag()"
                        class="bg-slate-900 hover:bg-black text-white px-3 py-2 text-xs font-bold rounded-xl transition-all active:scale-95 shadow-sm shrink-0">+
                        Add Guideline</button>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="closeModal('advice-modal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">Cancel</button>
                    <button type="button" onclick="saveAdvicePipeline()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase shadow-md">Apply
                        Advice</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Local Framework Storage Runtime State Layer Arrays
        let selectedComplaints = [];
        let selectedExaminations = [];
        let selectedInvestigations = [];
        let selectedMedicines = [];
        let selectedAdvices = [];
        let selectedDiagnoses = []; // NEW: Tracking runtime array state mapping for clinical diagnoses
        let currentTargetTag = '';

        // General Modal Window Trigger Handlers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- TREATMENT TEMPLATE ARCHITECTURE LEDGER ENGINE ---
        const treatmentTemplates = {
            fever_pack: {
                title: 'HN-01: Standard Fever & Flu',
                complaints: [{
                    condition: 'Fever',
                    duration: '3 Days'
                }, {
                    condition: 'Cough',
                    duration: '5 Days'
                }],
                examination: [{
                    key: 'Temperature',
                    val: '102°F'
                }],
                investigations: [{
                    code: 'CBC',
                    result: 'Hb: 11.2 gm/dL'
                }],
                diagnoses: ['Acute Viral Fever'],
                medicines: [{
                    name: 'Napa (Tablet, 500 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের পরে',
                    duration: '৫ দিন',
                    instruction: 'জ্বর থাকলে খাবেন'
                }],
                advices: ['পানি বেশি করে খাবেন', '৭ দিন বেড রেস্ট করবেন']
            },
            hypertension_pack: {
                title: 'HN-02: Hypertension Routine',
                complaints: [{
                    condition: 'Headache',
                    duration: '1 Week'
                }],
                examination: [{
                    key: 'Blood Pressure',
                    val: '160/95 mmHg'
                }],
                investigations: [{
                    code: 'Serum Creatinine',
                    result: 'Normal'
                }],
                diagnoses: ['Hypertension (HTN)'],
                medicines: [{
                    name: 'Indever (Tablet, 10 mg)',
                    dosage: '1 + 0 + 1 + 0',
                    timing: 'খাবারের আগে',
                    duration: '১ মাস',
                    instruction: 'নিয়মিত চলবে'
                }],
                advices: ['তেল জাতীয় খাবার খাবেন না', 'নিয়মিত ওষুধ খাবেন']
            }
        };

        function filterTreatmentTemplatesList(searchQuery) {
            const query = searchQuery.toLowerCase().trim();
            document.querySelectorAll('#ui-templates-container .template-wrapper-item').forEach(item => {
                const indexTitle = item.getAttribute('data-title');
                item.classList.toggle('hidden', !indexTitle.includes(query));
            });
        }

        function createNewTreatmentTemplateFromUI() {
            const titleInput = document.getElementById('custom-template-title-input');
            const title = titleInput.value.trim();

            if (!title) {
                alert('Specify template label name first.');
                return;
            }
            if (selectedComplaints.length === 0 && selectedMedicines.length === 0) {
                alert('Cannot register empty datasets packages template context.');
                return;
            }

            const uniqueKey = 'custom_pack_' + Date.now();

            treatmentTemplates[uniqueKey] = {
                title: title,
                complaints: [...selectedComplaints],
                examination: [...selectedExaminations],
                investigations: [...selectedInvestigations],
                diagnoses: [...selectedDiagnoses],
                medicines: [...selectedMedicines],
                advices: [...selectedAdvices]
            };

            const leftContainer = document.getElementById('ui-templates-container');
            const dataSearchMeta = title.toLowerCase().replace(/[^a-z0-9 ]/g, '');

            const customButtonHtml = `
            <div class="template-wrapper-item" data-title="${dataSearchMeta}">
                <button type="button" onclick="loadTreatmentTemplate('${uniqueKey}')" class="w-full text-left text-xs font-bold px-4 py-3 bg-emerald-50/60 hover:bg-indigo-600 text-emerald-950 hover:text-white border border-emerald-100 rounded-xl transition-all duration-200 flex items-center justify-between group shadow-sm active:scale-95 scale-95 animate-zoom-in">
                    <span>📋 ${title}</span>
                    <span class="text-[10px] bg-white text-emerald-700 group-hover:bg-indigo-700 group-hover:text-white px-2 py-0.5 rounded border border-emerald-100 tracking-wide uppercase shrink-0 ml-2">Load</span>
                </button>
            </div>`;

            leftContainer.insertAdjacentHTML('beforeend', customButtonHtml);
            titleInput.value = '';
        }

        function loadTreatmentTemplate(templateKey) {
            const pack = treatmentTemplates[templateKey];
            if (!pack) return;

            selectedComplaints = [...pack.complaints];
            selectedExaminations = [...pack.examination];
            selectedInvestigations = pack.investigations ? [...pack.investigations] : [];
            selectedDiagnoses = pack.diagnoses ? [...pack.diagnoses] : [];
            selectedMedicines = [...pack.medicines];
            selectedAdvices = [...pack.advices];

            renderComplaintsView();
            renderExaminationView();
            renderInvestigationsView();
            renderDiagnosisView(); // Dynamic execution mapping out templates diagnosis lines
            renderMedicinesView();

            const adviceContainer = document.getElementById('render-advice-target');
            const adviceSection = document.getElementById('live-section-advice');
            adviceContainer.innerHTML = '';
            if (selectedAdvices.length > 0) {
                adviceSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    adviceContainer.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
        }

        // --- PATIENT RUNTIME TRACKERS ---
        function setActivePatient(name, age, gender) {
            document.getElementById('current-patient-label').innerText = name;
            document.getElementById('current-patient-meta').innerText = `${age} Years | ${gender}`;
            document.getElementById('canvas-pt-name').innerText = name;
            document.getElementById('canvas-pt-meta').innerText = `${age} Years | ${gender}`;
            closeModal('patient-session-modal');
        }

        function registerQuickPatient() {
            const name = document.getElementById('new-pt-name').value;
            const age = document.getElementById('new-pt-age').value;
            const gender = document.getElementById('new-pt-gender').value;
            if (!name || !age) {
                alert('Provide essential details parameters.');
                return;
            }

            const ledgerContainer = document.getElementById('patient-ledger-list');
            const cardHtml = `
            <div onclick="setActivePatient('${name}', '${age}', '${gender}')" class="patient-ledger-card p-3 border border-slate-100 bg-slate-50/50 hover:bg-indigo-50/20 rounded-xl flex justify-between items-center cursor-pointer hover:border-indigo-400 transition-all animate-fade-in">
                <div>
                    <h4 class="text-xs font-bold text-slate-900 name-field">${name}</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Age: ${age} • ${gender}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-bold">Select</span>
            </div>`;
            ledgerContainer.insertAdjacentHTML('afterbegin', cardHtml);
            setActivePatient(name, age, gender);
            document.getElementById('quick-patient-form').reset();
        }

        // --- COMPLAINTS MODULE PIPELINES ---
        function selectComplaintTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-complaint-label').innerText = tag;
            document.getElementById('complaint-duration-builder').classList.remove('hidden');
        }

        function appendDurationValue(val) {
            document.getElementById('complaint-duration-input').value = val;
        }

        function appendCustomComplaintTag() {
            const value = document.getElementById('custom-complaint-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('complaints-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectComplaintTag(this, '${value}')" class="bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 text-indigo-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all duration-150 scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-complaint-input').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectComplaintTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveComplaintsPipeline() {
            const duration = document.getElementById('complaint-duration-input').value || '1 week';
            if (currentTargetTag) {
                selectedComplaints = selectedComplaints.filter(item => item.condition !== currentTargetTag);
                selectedComplaints.push({
                    condition: currentTargetTag,
                    duration: duration
                });
                renderComplaintsView();
            }
            document.getElementById('complaint-duration-builder').classList.add('hidden');
            closeModal('complaints-modal');
        }

        function renderComplaintsView() {
            const container = document.getElementById('render-complaints-target');
            const rootSection = document.getElementById('live-section-complaints');
            container.innerHTML = '';
            if (selectedComplaints.length > 0) {
                rootSection.classList.remove('hidden');
                selectedComplaints.forEach(item => {
                    container.innerHTML +=
                        `<div class="font-bold text-slate-900 text-xs py-0.5">• ${item.condition} <span class="text-slate-400 font-normal text-[11px] ml-1.5">— ${item.duration}</span></div>`;
                });
            }
        }

        // --- EXAMINATION MODULE PIPELINES ---
        function selectExaminationTag(btn, tag) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                btn.classList.add('bg-indigo-600', 'text-white');
            }
            currentTargetTag = tag;
            document.getElementById('active-exam-label').innerText = tag;
            document.getElementById('exam-value-input').value = '';
            document.getElementById('exam-value-builder').classList.remove('hidden');
        }

        function appendExamMetric(val) {
            document.getElementById('exam-value-input').value = val;
        }

        function appendCustomExamTag() {
            const value = document.getElementById('custom-exam-name').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectExaminationTag(this, '${value}')" class="bg-blue-50 hover:bg-indigo-600 border border-blue-200 text-blue-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-name').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectExaminationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function appendCustomMetricValue() {
            const value = document.getElementById('custom-exam-metric').value.trim();
            if (!value) return;
            const grid = document.getElementById('examination-metrics-grid');
            const btnHtml =
                `<button type="button" onclick="appendExamMetric('${value}')" class="bg-slate-900 text-white hover:bg-black text-[11px] font-bold px-3 py-2 rounded-lg transition-all shadow-sm active:scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-exam-metric').value = '';
            appendExamMetric(value);
        }

        function saveExaminationPipeline() {
            const metric = document.getElementById('exam-value-input').value || 'Normal';
            if (currentTargetTag) {
                selectedExaminations = selectedExaminations.filter(item => item.key !== currentTargetTag);
                selectedExaminations.push({
                    key: currentTargetTag,
                    val: metric
                });
                renderExaminationView();
            }
            document.getElementById('exam-value-builder').classList.add('hidden');
            closeModal('examination-modal');
        }

        function renderExaminationView() {
            const container = document.getElementById('render-examination-target');
            const rootSection = document.getElementById('live-section-examination');
            container.innerHTML = '';
            if (selectedExaminations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedExaminations.forEach(item => {
                    container.innerHTML +=
                        `<div class="text-slate-800 py-0.5 text-xs font-bold">• ${item.key}: <span class="text-indigo-600">${item.val}</span></div>`;
                });
            }
        }

        // --- NEW: DIAGNOSIS / CLINICAL IMPRESSIONS EXECUTION MODULES ---
        function toggleDiagnosisTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.className =
                    "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm cursor-pointer select-none";
                selectedDiagnoses = selectedDiagnoses.filter(item => item !== val);
            } else {
                btn.className =
                    "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm cursor-pointer select-none";
                selectedDiagnoses.push(val);
            }
        }

        function appendCustomDiagnosisTag() {
            const value = document.getElementById('custom-diagnosis-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('diagnosis-badge-grid');
            const btnHtml =
                `<button type="button" onclick="toggleDiagnosisTag(this, '${value}')" class="bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm cursor-pointer select-none scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            selectedDiagnoses.push(value);
            document.getElementById('custom-diagnosis-input').value = '';
        }

        function saveDiagnosisPipeline() {
            renderDiagnosisView();
            closeModal('diagnosis-modal');
        }

        function renderDiagnosisView() {
            const container = document.getElementById('render-diagnosis-target');
            const rootSection = document.getElementById('live-section-diagnosis');
            container.innerHTML = '';
            if (selectedDiagnoses.length > 0) {
                rootSection.classList.remove('hidden');
                selectedDiagnoses.forEach(diag => {
                    container.innerHTML +=
                        `<div class="text-slate-900 py-0.5 text-xs font-extrabold italic">• Provisional Dx: <span class="text-rose-600 font-black">${diag}</span></div>`;
                });
            } else {
                rootSection.classList.add('hidden');
            }
        }

        // --- INVESTIGATIONS MODULE PIPELINES ---
        function selectInvestigationTag(btn, testCode) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-purple-600', 'text-white'));
                btn.classList.add('bg-purple-600', 'text-white');
            }
            currentTargetTag = testCode;
            document.getElementById('active-investigation-label').innerText = testCode;
            document.getElementById('investigation-result-input').value = '';
            document.getElementById('investigation-result-builder').classList.remove('hidden');
        }

        function appendCustomInvestigationTag() {
            const value = document.getElementById('custom-investigation-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('investigation-badge-grid');
            const btnHtml =
                `<button type="button" onclick="selectInvestigationTag(this, '${value}')" class="bg-purple-50 hover:bg-purple-600 border border-purple-200 text-purple-700 hover:text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            document.getElementById('custom-investigation-input').value = '';
            const spawnedButtons = grid.querySelectorAll('button');
            selectInvestigationTag(spawnedButtons[spawnedButtons.length - 1], value);
        }

        function saveInvestigationPipeline() {
            const testResult = document.getElementById('investigation-result-input').value || 'Normal';
            if (currentTargetTag) {
                selectedInvestigations = selectedInvestigations.filter(item => item.code !== currentTargetTag);
                selectedInvestigations.push({
                    code: currentTargetTag,
                    result: testResult
                });
                renderInvestigationsView();
            }
            document.getElementById('investigation-result-builder').classList.add('hidden');
            closeModal('investigation-modal');
        }

        function renderInvestigationsView() {
            const container = document.getElementById('render-investigation-target');
            const rootSection = document.getElementById('live-section-investigation');
            container.innerHTML = '';
            if (selectedInvestigations.length > 0) {
                rootSection.classList.remove('hidden');
                selectedInvestigations.forEach(item => {
                    container.innerHTML +=
                        `<div class="text-slate-900 py-0.5 text-xs font-bold">• ${item.code} <span class="text-purple-600 font-medium ml-1">[${item.result}]</span></div>`;
                });
            }
        }

        // --- RX MEDICATION PLAN ENGINE ---
        function stageMedicineItem(btn, drugName) {
            if (btn) {
                btn.parentNode.querySelectorAll('button').forEach(b => b.classList.remove('bg-indigo-50',
                    'border-indigo-300'));
                btn.classList.add('bg-indigo-50', 'border-indigo-300');
            }
            currentTargetTag = drugName;
            document.getElementById('med-placeholder-notice').classList.add('hidden');
            document.getElementById('med-scheduler-panel').classList.remove('hidden');
            document.getElementById('scheduled-med-title').innerText = drugName;
        }

        function appendCustomMedicineCatalog() {
            const value = document.getElementById('custom-medicine-name').value.trim();
            if (!value) return;
            const catalog = document.getElementById('medicine-catalog-list');
            const btnHtml = `
            <button type="button" onclick="stageMedicineItem(this, '${value}')" class="text-left text-xs text-indigo-600 hover:text-indigo-950 font-semibold py-2.5 px-3 bg-indigo-50/30 hover:bg-indigo-50/50 rounded-xl border border-indigo-200 shadow-sm transition-all duration-150 flex items-center space-x-2 group">
                <span class="text-indigo-400 font-mono text-xs">✨</span>
                <span>${value}</span>
            </button>`;
            catalog.insertAdjacentHTML('afterbegin', btnHtml);
            document.getElementById('custom-medicine-name').value = '';
            const firstBtn = catalog.querySelector('button');
            stageMedicineItem(firstBtn, value);
        }

        function commitMedicineToStack() {
            const q1 = document.getElementById('dose-qty-1').value;
            const q2 = document.getElementById('dose-qty-2').value;
            const q3 = document.getElementById('dose-qty-3').value;
            const q4 = document.getElementById('dose-qty-4').value;

            const dosagePattern = `${q1} + ${q2} + ${q3} + ${q4}`;
            const timing = document.getElementById('med-timing-select').value;
            const duration = document.getElementById('med-duration-input').value;
            const customInstruction = document.getElementById('med-instruction-input').value;

            selectedMedicines.push({
                name: currentTargetTag,
                dosage: dosagePattern,
                timing: timing,
                duration: duration,
                instruction: customInstruction
            });

            renderMedicinesView();
            document.getElementById('med-scheduler-panel').classList.add('hidden');
            document.getElementById('med-placeholder-notice').classList.remove('hidden');
            closeModal('medicine-modal');
        }

        function renderMedicinesView() {
            const container = document.getElementById('render-medication-target');
            const rootSection = document.getElementById('live-section-medication');
            container.innerHTML = '';
            if (selectedMedicines.length > 0) {
                rootSection.classList.remove('hidden');
                selectedMedicines.forEach(item => {
                    container.innerHTML += `
                    <li class="mb-1 pl-1 text-slate-900 font-bold">
                        <div class="text-sm font-extrabold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            💥 <span class="text-slate-800 font-bold">${item.dosage}</span> — <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">${item.timing}</span> — <span class="text-indigo-600 font-extrabold">${item.duration}</span>
                            ${item.instruction ? `<br><span class="text-amber-700 text-[11px] font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100 mt-1.5 inline-block">Instruction: ${item.instruction}</span>` : ''}
                        </div>
                    </li>`;
                });
            }
        }

        // --- ADVICES PIPELINES ---
        function toggleAdviceTag(btn, val) {
            if (btn.classList.contains('bg-indigo-600')) {
                btn.className =
                    "bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 hover:bg-slate-100 hover:border-slate-300 shadow-sm cursor-pointer select-none";
                selectedAdvices = selectedAdvices.filter(item => item !== val);
            } else {
                btn.className =
                    "bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none";
                selectedAdvices.push(val);
            }
        }

        function appendCustomAdviceTag() {
            const value = document.getElementById('custom-advice-input').value.trim();
            if (!value) return;
            const grid = document.getElementById('advices-badge-grid');
            const btnHtml =
                `<button type="button" onclick="toggleAdviceTag(this, '${value}')" class="bg-indigo-600 border border-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all duration-150 shadow-sm cursor-pointer select-none scale-95 animate-zoom-in">${value}</button>`;
            grid.insertAdjacentHTML('beforeend', btnHtml);
            selectedAdvices.push(value);
            document.getElementById('custom-advice-input').value = '';
        }

        function saveAdvicePipeline() {
            const container = document.getElementById('render-advice-target');
            const rootSection = document.getElementById('live-section-advice');
            container.innerHTML = '';
            if (selectedAdvices.length > 0) {
                rootSection.classList.remove('hidden');
                selectedAdvices.forEach(adv => {
                    container.innerHTML += `<li class="text-xs font-bold text-slate-800 py-0.5">${adv}</li>`;
                });
            }
            closeModal('advice-modal');
        }
    </script>

    <style>
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-zoom-in {
            animation: zoomIn 0.15s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>
@endsection
