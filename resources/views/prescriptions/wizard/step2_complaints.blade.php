{{--
    Step 2 — Complaints.
    Each master-list complaint is a checkbox + a paired text input for duration.
    A custom complaint row is always available at the bottom.
    Previously saved selections (from $state) are pre-checked/pre-filled so
    going Back and Forward doesn't lose data.
--}}
<x-prescriptions.wizard._layout :current-step="2" page-title="Step 2: Complaints" :state="$state">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 2 — Patient Complaints</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Check each complaint that applies and note its duration.</p>

    @php
        // Build a lookup of previously-saved complaints so checkboxes/inputs can be pre-filled
        $saved = collect($state['complaints'] ?? [])->keyBy('name');
    @endphp

    <form method="POST" action="{{ route('prescriptions.wizard.complaints') }}" class="space-y-6">
        @csrf

        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
            @forelse($complaints as $i => $c)
                @php $existing = $saved->get($c->complaint_name); @endphp
                <div class="flex items-center gap-3 border border-slate-100 rounded-xl p-3 hover:bg-slate-50">
                    <input type="checkbox" name="complaint_name[{{ $i }}]" value="{{ $c->complaint_name }}"
                        id="complaint-{{ $i }}" {{ $existing ? 'checked' : '' }} class="h-4 w-4 shrink-0">
                    <label for="complaint-{{ $i }}" class="text-xs font-bold text-slate-800 w-44 shrink-0">
                        {{ $c->complaint_name }}
                    </label>
                    <input type="text" name="complaint_duration[{{ $i }}]"
                        value="{{ $existing['duration'] ?? '' }}" placeholder="Duration e.g. 3 days"
                        class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium outline-none focus:border-indigo-400">
                </div>
            @empty
                <p class="text-xs text-slate-400 italic">No complaints in the master list yet — add a custom one below.
                </p>
            @endforelse
        </div>

        {{-- Custom complaint --}}
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">+ Add Custom
                Complaint</label>
            <div class="flex gap-2">
                <input type="text" name="custom_complaint_name" placeholder="Complaint name"
                    class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
                <input type="text" name="custom_complaint_duration" placeholder="Duration"
                    class="w-40 border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
            </div>
        </div>

        <div class="flex justify-between pt-4 border-t border-slate-100">
            <a href="{{ route('prescriptions.wizard.patient') }}"
                class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 uppercase tracking-wider">
                ← Back
            </a>
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest shadow-md">
                Continue to Examination →
            </button>
        </div>
    </form>

</x-prescriptions.wizard._layout>
