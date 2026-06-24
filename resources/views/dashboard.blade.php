@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200/60 pb-5">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">System Dashboard Overview</h1>
                <p class="text-xs font-medium text-slate-500 mt-0.5">Welcome back! Here is what's happening across your
                    clinic metrics infrastructure matrix today.</p>
            </div>
            <div
                class="flex items-center space-x-2 text-xs font-semibold bg-white border border-slate-200/80 rounded-xl px-4 py-2.5 shadow-sm text-slate-600">
                <span class="text-emerald-500 animate-pulse text-sm">●</span>
                <span class="font-mono">Server Time Status: {{ date('d M, Y — H:i') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">Total
                        Patients</span>
                    <span
                        class="text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalPatients) }}</span>
                </div>
                <div class="h-12 w-12 bg-indigo-50 rounded-xl flex items-center justify-center text-xl shadow-inner">👥
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">Total Rₓ
                        Issued</span>
                    <span
                        class="text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalPrescriptions) }}</span>
                </div>
                <div class="h-12 w-12 bg-purple-50 rounded-xl flex items-center justify-center text-xl shadow-inner">📋
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">Consultations
                        Today</span>
                    <span
                        class="text-3xl font-black text-indigo-600 tracking-tight block">{{ number_format($prescriptionsToday) }}</span>
                </div>
                <div class="h-12 w-12 bg-emerald-50 rounded-xl flex items-center justify-center text-xl shadow-inner">📝
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">Active
                        Medicines</span>
                    <span
                        class="text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($systemMedicines) }}</span>
                </div>
                <div class="h-12 w-12 bg-amber-50 rounded-xl flex items-center justify-center text-xl shadow-inner">💊</div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6 items-start">

            <div class="col-span-12 lg:col-span-8 bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Recent Consultations Output</h3>
                        <p class="text-[11px] font-medium text-slate-400 mt-0.5">Quick trace audit framework tracking the
                            latest five generated prescription records.</p>
                    </div>
                    <a href="{{ route('prescriptions.index') }}"
                        class="text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white px-3 py-1.5 rounded-lg transition">
                        View Logs →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="bg-slate-50 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <tr>
                                <th class="px-4 py-3">Rₓ ID</th>
                                <th class="px-4 py-3">Patient Name</th>
                                <th class="px-4 py-3">Attending Practitioner</th>
                                <th class="px-4 py-3">Date Stamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                            @forelse($recentPrescriptions as $rx)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-4 py-3 font-mono text-xs text-indigo-600 font-bold">
                                        #{{ $rx->prescription_id }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-900 font-semibold">
                                        {{ $rx->patient->patient_name ?? 'Anonymous File' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-500">
                                        {{ $rx->doctor->doctors_name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs">
                                        {{ $rx->prescription_date }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-4 py-8 text-center text-slate-400 italic font-normal text-xs">
                                        No logged prescriptions saved inside system framework databases yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4 bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Demographics Snapshot</h3>
                    <p class="text-[11px] font-medium text-slate-400 mt-0.5">Distribution allocation footprint split
                        breakdown analysis.</p>
                </div>

                <div class="space-y-3">
                    @forelse($genderDistribution as $gender)
                        @php
                            // Simple percentage gauge visualization indicator
                            $percentage = $totalPatients > 0 ? ($gender->total / $totalPatients) * 100 : 0;
                            $colorClass =
                                $gender->patient_gender === 'Male'
                                    ? 'bg-blue-500'
                                    : ($gender->patient_gender === 'Female'
                                        ? 'bg-pink-500'
                                        : 'bg-purple-500');
                        @endphp
                        <div class="space-y-1">
                            <div class="flex justify-between items-center text-xs font-bold text-slate-700">
                                <span class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full {{ $colorClass }}"></span>
                                    {{ $gender->patient_gender }}
                                </span>
                                <span class="font-mono text-slate-500">{{ $gender->total }}
                                    ({{ round($percentage, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="{{ $colorClass }} h-full transition-all duration-500"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic py-4 text-center">No active statistical gender markers
                            tracked inside dynamic models.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
