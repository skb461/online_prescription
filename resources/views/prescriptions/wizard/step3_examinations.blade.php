{{-- Step 3 — On Examination. Same checkbox+value pattern as Step 2. --}}
<x-prescriptions.wizard._layout :current-step="3" page-title="Step 3: Examination" :state="$state">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 3 — On Examination</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Check each finding and record its value.</p>

    @php
        $saved = collect($state['examinations'] ?? [])->keyBy('name');
    @endphp

    <form method="POST" action="{{ route('prescriptions.wizard.examinations') }}" class="space-y-6">
        @csrf

        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
            @forelse($examinations as $i => $ex)
                @php $existing = $saved->get($ex->examination_name); @endphp
                <div class="flex items-center gap-3 border border-slate-100 rounded-xl p-3 hover:bg-slate-50">
                    <input type="checkbox" name="examination_name[{{ $i }}]"
                        value="{{ $ex->examination_name }}" id="exam-{{ $i }}"
                        {{ $existing ? 'checked' : '' }} class="h-4 w-4 shrink-0">
                    <label for="exam-{{ $i }}" class="text-xs font-bold text-slate-800 w-44 shrink-0">
                        {{ $ex->examination_name }}
                    </label>
                    <input type="text" name="examination_value[{{ $i }}]"
                        value="{{ $existing['value'] ?? '' }}" placeholder="Value e.g. 120/70"
                        class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium outline-none focus:border-indigo-400">
                </div>
            @empty
                <p class="text-xs text-slate-400 italic">No examinations in the master list yet — add a custom one
                    below.</p>
            @endforelse
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">+ Add Custom
                Examination</label>
            <div class="flex gap-2">
                <input type="text" name="custom_examination_name" placeholder="Examination name"
                    class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
                <input type="text" name="custom_examination_value" placeholder="Value"
                    class="w-40 border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
            </div>
        </div>

        <div class="flex justify-between pt-4 border-t border-slate-100">
            <a href="{{ route('prescriptions.wizard.complaints') }}"
                class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 uppercase tracking-wider">
                ← Back
            </a>
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest shadow-md">
                Continue to Diagnosis →
            </button>
        </div>
    </form>

</x-prescriptions.wizard._layout>
