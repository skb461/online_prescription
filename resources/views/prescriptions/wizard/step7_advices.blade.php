{{-- Step 7 — Advice & Diet Plans + optional follow-up date. --}}
<x-prescriptions.wizard._layout :current-step="7" page-title="Step 7: Advice" :state="$state">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 7 — Advice &amp; Diet Plans</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Select care instructions and (optionally) a follow-up date.</p>

    @php
        $saved = collect($state['advices'] ?? []);
    @endphp

    <form method="POST" action="{{ route('prescriptions.wizard.advices') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-80 overflow-y-auto pr-1">
            @forelse($advices as $i => $adv)
                <label
                    class="flex items-center gap-2 border border-slate-100 rounded-xl p-3 hover:bg-slate-50 text-xs font-bold text-slate-800 cursor-pointer">
                    <input type="checkbox" name="advice_name[{{ $i }}]" value="{{ $adv->advice_name }}"
                        {{ $saved->contains($adv->advice_name) ? 'checked' : '' }} class="h-4 w-4 shrink-0">
                    {{ $adv->advice_name }}
                </label>
            @empty
                <p class="text-xs text-slate-400 italic col-span-3">No advices in the master list yet — add a custom one
                    below.</p>
            @endforelse
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">+ Add Custom
                Advice</label>
            <input type="text" name="custom_advice_name" placeholder="e.g. Avoid spicy food"
                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-indigo-400 bg-white">
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Next Follow-up Date
                (optional)</label>
            <input type="date" name="next_meeting_date" value="{{ $state['next_meeting_date'] ?? '' }}"
                class="border border-slate-200 rounded-xl p-3 text-xs font-bold outline-none focus:border-indigo-500 shadow-sm bg-white">
        </div>

        <div class="flex justify-between pt-4 border-t border-slate-100">
            <a href="{{ route('prescriptions.wizard.medicines') }}"
                class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 uppercase tracking-wider">
                ← Back
            </a>
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest shadow-md">
                Continue to Review →
            </button>
        </div>
    </form>

</x-prescriptions.wizard._layout>
