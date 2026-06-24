{{--
    Step 8 — Review everything, then submit.
    This is the ONLY step where data actually hits the database
    (via reviewSubmit() → DB::transaction in the controller).
--}}
<x-prescriptions.wizard._layout :current-step="8" page-title="Step 8: Review" :state="$state">

    <h2 class="text-lg font-black text-slate-900 mb-1">Step 8 — Review &amp; Submit</h2>
    <p class="text-xs text-slate-400 font-medium mb-6">Check everything below, then submit to save the prescription.</p>

    <div class="space-y-6 text-xs">

        {{-- Patient --}}
        <div class="border border-slate-100 rounded-xl p-4">
            <h3 class="font-black uppercase tracking-wider text-slate-400 text-[10px] mb-2">Patient</h3>
            <p class="font-bold text-slate-900 text-sm">{{ $state['patient']['name'] }}</p>
            <p class="text-slate-500 font-medium">{{ $state['patient']['age'] }} yrs •
                {{ $state['patient']['gender'] }}{{ $state['patient']['phone'] ? ' • ' . $state['patient']['phone'] : '' }}
            </p>
        </div>

        {{-- Complaints --}}
        <div class="border border-slate-100 rounded-xl p-4">
            <h3 class="font-black uppercase tracking-wider text-slate-400 text-[10px] mb-2">Complaints</h3>
            @forelse($state['complaints'] ?? [] as $c)
                <p class="font-bold text-slate-800 py-0.5">• {{ $c['name'] }} ({{ $c['duration'] }})</p>
            @empty
                <p class="text-slate-300 italic">None recorded</p>
            @endforelse
        </div>

        {{-- Examinations --}}
        <div class="border border-slate-100 rounded-xl p-4">
            <h3 class="font-black uppercase tracking-wider text-slate-400 text-[10px] mb-2">On Examination</h3>
            @forelse($state['examinations'] ?? [] as $e)
                <p class="font-bold text-slate-800 py-0.5">• {{ $e['name'] }}: <span
                        class="text-indigo-600">{{ $e['value'] }}</span></p>
            @empty
                <p class="text-slate-300 italic">None recorded</p>
            @endforelse
        </div>

        {{-- Diagnoses --}}
        <div class="border border-slate-100 rounded-xl p-4">
            <h3 class="font-black uppercase tracking-wider text-slate-400 text-[10px] mb-2">Diagnosis</h3>
            @forelse($state['diagnoses'] ?? [] as $d)
                <p class="font-extrabold italic text-rose-600 py-0.5">• {{ $d }}</p>
            @empty
                <p class="text-slate-300 italic">None recorded</p>
            @endforelse
        </div>

        {{-- Investigations --}}
        <div class="border border-slate-100 rounded-xl p-4">
            <h3 class="font-black uppercase tracking-wider text-slate-400 text-[10px] mb-2">Investigations</h3>
            @forelse($state['investigations'] ?? [] as $inv)
                <p class="font-bold text-slate-800 py-0.5">• {{ $inv['name'] }} <span
                        class="text-purple-600">[{{ $inv['result'] }}]</span></p>
            @empty
                <p class="text-slate-300 italic">None recorded</p>
            @endforelse
        </div>

        {{-- Medicines --}}
        <div class="border border-slate-100 rounded-xl p-4">
            <h3 class="font-black uppercase tracking-wider text-slate-400 text-[10px] mb-2">Medication Plan</h3>
            @forelse($state['medicines'] ?? [] as $med)
                <div class="py-1.5 border-b border-slate-50 last:border-0">
                    <p class="font-black text-slate-900">{{ $med['name'] }}</p>
                    <p class="text-slate-600 font-semibold">{{ $med['dosage'] }} — {{ $med['timing'] }} — <span
                            class="text-indigo-600 font-bold">{{ $med['duration'] }}</span></p>
                    @if (!empty($med['instruction']))
                        <p class="text-amber-700 font-bold">{{ $med['instruction'] }}</p>
                    @endif
                </div>
            @empty
                <p class="text-slate-300 italic">None recorded</p>
            @endforelse
        </div>

        {{-- Advice --}}
        <div class="border border-slate-100 rounded-xl p-4">
            <h3 class="font-black uppercase tracking-wider text-slate-400 text-[10px] mb-2">Advice</h3>
            @forelse($state['advices'] ?? [] as $a)
                <p class="font-bold text-slate-800 py-0.5">• {{ $a }}</p>
            @empty
                <p class="text-slate-300 italic">None recorded</p>
            @endforelse

            @if (!empty($state['next_meeting_date']))
                <p class="mt-2 text-indigo-600 font-bold">📅 Next follow-up: {{ $state['next_meeting_date'] }}</p>
            @endif
        </div>
    </div>

    <div class="flex justify-between pt-6 mt-6 border-t border-slate-100">
        <a href="{{ route('prescriptions.wizard.advices') }}"
            class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 uppercase tracking-wider">
            ← Back
        </a>
        <form method="POST" action="{{ route('prescriptions.wizard.review') }}">
            @csrf
            <button type="submit"
                class="px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-black uppercase tracking-widest shadow-md">
                ✓ Confirm &amp; Save Prescription
            </button>
        </form>
    </div>

</x-prescriptions.wizard._layout>
