{{-- Step 5 — Investigations & Tests. Checkbox + result value, same pattern as complaints. --}}
<x-prescriptions.wizard._layout :current-step="5" page-title="Step 5: Investigation" :state="$state">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 5 — Investigations &amp; Lab Tests</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Check each test ordered and record its result, if known.</p>

    @php
        $saved = collect($state['investigations'] ?? [])->keyBy('name');
    @endphp

    <form method="POST" action="{{ route('prescriptions.wizard.investigations') }}" class="space-y-6">
        @csrf

        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
            @forelse($investigations as $i => $inv)
                @php $existing = $saved->get($inv->investigation_name); @endphp
                <div class="flex items-center gap-3 border border-slate-100 rounded-xl p-3 hover:bg-slate-50">
                    <input type="checkbox" name="investigation_name[{{ $i }}]"
                        value="{{ $inv->investigation_name }}" id="inv-{{ $i }}"
                        {{ $existing ? 'checked' : '' }} class="h-4 w-4 shrink-0">
                    <label for="inv-{{ $i }}" class="text-xs font-bold text-slate-800 w-44 shrink-0">
                        {{ $inv->investigation_name }}
                    </label>
                    <input type="text" name="investigation_result[{{ $i }}]"
                        value="{{ $existing['result'] ?? '' }}" placeholder="Result (optional)"
                        class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium outline-none focus:border-indigo-400">
                </div>
            @empty
                <p class="text-xs text-slate-400 italic">No investigations in the master list yet — add a custom one
                    below.</p>
            @endforelse
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">+ Add Custom
                Investigation</label>
            <div class="flex gap-2">
                <input type="text" name="custom_investigation_name" placeholder="Test name"
                    class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
                <input type="text" name="custom_investigation_result" placeholder="Result"
                    class="w-40 border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
            </div>
        </div>

        <div class="flex justify-between pt-4 border-t border-slate-100">
            <a href="{{ route('prescriptions.wizard.diagnoses') }}"
                class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 uppercase tracking-wider">
                ← Back
            </a>
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest shadow-md">
                Continue to Medicines →
            </button>
        </div>
    </form>

</x-prescriptions.wizard._layout>
