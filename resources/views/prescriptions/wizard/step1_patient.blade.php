{{--
    Step 1 — Patient selection / registration.
    No JS: two separate <form> blocks, each posts to the same endpoint
    with a different "mode" hidden field so the controller knows which
    branch to use.
--}}
<x-prescriptions.wizard._layout :current-step="1" page-title="Step 1: Patient">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 1 — Select or Register Patient</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Choose an existing patient or register a new one to begin.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- ── Existing patient ── --}}
        <div>
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Existing Patient</h3>

            @if ($patients->isEmpty())
                <p class="text-xs text-slate-400 italic">No patients registered yet. Use the form on the right.</p>
            @else
                <form method="POST" action="{{ route('prescriptions.wizard.patient') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="mode" value="existing">

                    <div class="max-h-80 overflow-y-auto border border-slate-200 rounded-xl divide-y divide-slate-100">
                        @foreach ($patients as $pt)
                            <label class="flex items-center gap-3 p-3 hover:bg-slate-50 cursor-pointer text-xs">
                                <input type="radio" name="patient_id" value="{{ $pt->patient_id }}"
                                    {{ ($state['patient_id'] ?? null) == $pt->patient_id ? 'checked' : '' }} required>
                                <span>
                                    <span class="font-bold text-slate-900">{{ $pt->patient_name }}</span>
                                    <span class="text-slate-400 font-medium">— {{ $pt->patient_age }} yrs,
                                        {{ $pt->patient_gender }}{{ $pt->patient_phone_number ? ', ' . $pt->patient_phone_number : '' }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all">
                        Use Selected Patient →
                    </button>
                </form>
            @endif
        </div>

        {{-- ── New patient ── --}}
        <div class="border-l border-slate-100 pl-8">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Register New Patient</h3>

            <form method="POST" action="{{ route('prescriptions.wizard.patient') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="mode" value="new">

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Full
                        Name</label>
                    <input type="text" name="patient_name" required
                        value="{{ old('patient_name', $state['patient']['name'] ?? '') }}"
                        placeholder="e.g. Md Ariful Islam"
                        class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label
                            class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Age</label>
                        <input type="number" name="patient_age" required min="0" max="150"
                            value="{{ old('patient_age', $state['patient']['age'] ?? '') }}"
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Gender</label>
                        <select name="patient_gender" required
                            class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Phone
                        Number</label>
                    <input type="text" name="patient_phone"
                        value="{{ old('patient_phone', $state['patient']['phone'] ?? '') }}" placeholder="01700000000"
                        class="w-full border border-slate-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:border-indigo-500 shadow-sm bg-white">
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 hover:bg-black text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all">
                    Register &amp; Continue →
                </button>
            </form>
        </div>
    </div>

</x-prescriptions.wizard._layout>
