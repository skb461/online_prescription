{{--
    Step 6 — Medicines.
    Unlike other steps, this one POSTs to a separate "add" endpoint each time
    a medicine is added, then reloads the SAME step showing the growing list.
    A separate "Continue" button (its own form) advances to the next step.
    Each row in the list has its own tiny remove-form (no JS confirm dialogs).
--}}
<x-prescriptions.wizard._layout :current-step="6" page-title="Step 6: Medicines" :state="$state">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 6 — Medication Plan</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Add medicines one at a time. Add as many as needed, then continue.
    </p>

    {{-- ── Already-added medicines ── --}}
    @if (!empty($state['medicines']))
        <div class="mb-8">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Added Medicines
                ({{ count($state['medicines']) }})</h3>
            <div class="space-y-2">
                @foreach ($state['medicines'] as $i => $med)
                    <div class="flex items-start justify-between border border-slate-200 rounded-xl p-4 bg-slate-50">
                        <div class="text-xs">
                            <p class="font-black text-slate-900 text-sm">{{ $med['name'] }}</p>
                            <p class="text-slate-600 font-semibold mt-1">
                                Dose: <span class="font-bold">{{ $med['dosage'] }}</span>
                                — {{ $med['timing'] }} — <span
                                    class="text-indigo-600 font-bold">{{ $med['duration'] }}</span>
                            </p>
                            @if (!empty($med['instruction']))
                                <p class="text-amber-700 bg-amber-50 inline-block px-2 py-1 rounded mt-1.5 font-bold">
                                    {{ $med['instruction'] }}</p>
                            @endif
                        </div>
                        <form method="POST"
                            action="{{ route('prescriptions.wizard.medicines.remove', ['index' => $i]) }}">
                            @csrf
                            <button type="submit"
                                class="text-rose-500 hover:text-white hover:bg-rose-500 border border-rose-200 rounded-lg px-3 py-1.5 text-[10px] font-black uppercase tracking-wide transition-all">
                                Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Add a medicine ── --}}
    <div class="border-t border-slate-100 pt-6">
        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Add a Medicine</h3>

        <form method="POST" action="{{ route('prescriptions.wizard.medicines.add') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Medicine
                    Name</label>
                <input type="text" name="medicine_name" list="medicine-catalog" required
                    placeholder="Type or select from catalog..."
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white">
                <datalist id="medicine-catalog">
                    @foreach ($medicines as $med)
                        <option value="{{ $med->medicine_name }}">{{ $med->medicine_power }}</option>
                    @endforeach
                </datalist>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">Dose Schedule
                    (per time of day)</label>
                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <span class="block text-[9px] font-bold text-slate-400 text-center mb-1">Morning</span>
                        <input type="number" name="dose_morning" value="0" min="0" step="0.5"
                            class="w-full border border-slate-200 rounded-lg p-2 text-xs text-center font-bold bg-slate-50">
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-slate-400 text-center mb-1">Noon</span>
                        <input type="number" name="dose_noon" value="0" min="0" step="0.5"
                            class="w-full border border-slate-200 rounded-lg p-2 text-xs text-center font-bold bg-slate-50">
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-slate-400 text-center mb-1">Night</span>
                        <input type="number" name="dose_night" value="1" min="0" step="0.5"
                            class="w-full border border-slate-200 rounded-lg p-2 text-xs text-center font-bold bg-slate-50">
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-slate-400 text-center mb-1">Evening</span>
                        <input type="number" name="dose_evening" value="0" min="0" step="0.5"
                            class="w-full border border-slate-200 rounded-lg p-2 text-xs text-center font-bold bg-slate-50">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Meal
                        Relation</label>
                    <select name="medicine_timing" required
                        class="w-full border border-slate-200 rounded-xl p-3 text-xs font-bold bg-white outline-none focus:border-indigo-500">
                        <option value="After Food">After Food</option>
                        <option value="Before Food">Before Food</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Duration</label>
                    <input type="text" name="medicine_duration" value="Continue" required
                        class="w-full border border-slate-200 rounded-xl p-3 text-xs font-bold bg-white outline-none focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Custom
                    Instruction (optional)</label>
                <input type="text" name="medicine_instruction" placeholder="e.g. Take if fever persists"
                    class="w-full border border-slate-200 rounded-xl p-3 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
            </div>

            <button type="submit"
                class="w-full bg-slate-900 hover:bg-black text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all">
                + Add This Medicine to Plan
            </button>
        </form>
    </div>

    {{-- ── Navigation ── --}}
    <div class="flex justify-between pt-6 mt-6 border-t border-slate-100">
        <a href="{{ route('prescriptions.wizard.investigations') }}"
            class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 uppercase tracking-wider">
            ← Back
        </a>
        <form method="POST" action="{{ route('prescriptions.wizard.medicines.continue') }}">
            @csrf
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest shadow-md">
                Continue to Advice →
            </button>
        </form>
    </div>

</x-prescriptions.wizard._layout>
