{{-- Step 4 — Diagnosis. Simple checkbox list (no paired value, just the name). --}}
<x-prescriptions.wizard._layout :current-step="4" page-title="Step 4: Diagnosis" :state="$state">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 4 — Diagnosis / Impressions</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Select all that apply.</p>

    @php
        $saved = collect($state['diagnoses'] ?? []);
    @endphp

    <form method="POST" action="{{ route('prescriptions.wizard.diagnoses') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-96 overflow-y-auto pr-1">
            @forelse($diagnoses as $i => $d)
                <label
                    class="flex items-center gap-2 border border-slate-100 rounded-xl p-3 hover:bg-slate-50 text-xs font-bold text-slate-800 cursor-pointer">
                    <input type="checkbox" name="diagnosis_name[{{ $i }}]" value="{{ $d->diagnosis_name }}"
                        {{ $saved->contains($d->diagnosis_name) ? 'checked' : '' }} class="h-4 w-4 shrink-0">
                    {{ $d->diagnosis_name }}
                </label>
            @empty
                <p class="text-xs text-slate-400 italic col-span-3">No diagnoses in the master list yet — add a custom
                    one below.</p>
            @endforelse
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">+ Add Custom
                Diagnosis</label>
            <input type="text" name="custom_diagnosis_name" placeholder="Diagnosis name"
                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
        </div>

        <div class="flex justify-between pt-4 border-t border-slate-100">
            <a href="{{ route('prescriptions.wizard.examinations') }}"
                class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 uppercase tracking-wider">
                ← Back
            </a>
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest shadow-md">
                Continue to Investigation →
            </button>
        </div>
    </form>

</x-prescriptions.wizard._layout>
