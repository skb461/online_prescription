{{-- @extends('layouts.app')

@block('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Prescriptions Archive</h1>
            <p class="text-sm text-slate-500">View and print historical patient consultation charts.</p>
        </div>
        <a href="{{ route('prescriptions.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
            + Create Prescription
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                    <th class="p-4">ID</th>
                    <th class="p-4">Patient Profile</th>
                    <th class="p-4">Primary Complaint</th>
                    <th class="p-4">Date Issued</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($prescriptions as $prescription)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-mono text-slate-400">#{{ str_pad($prescription->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="p-4">
                            <div class="font-semibold text-slate-900">{{ $prescription->patient->name }}</div>
                            <div class="text-xs text-slate-400">{{ $prescription->patient->age }}Y /
                                {{ $prescription->patient->gender }}</div>
                        </td>
                        <td class="p-4 text-slate-600 truncate max-w-xs">{{ $prescription->chief_complaints }}</td>
                        <td class="p-4 text-slate-500 text-xs">{{ $prescription->created_at->format('M d, Y') }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('prescriptions.show', $prescription->id) }}"
                                class="inline-flex items-center text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg border border-slate-300 transition-colors">
                                🔍 View & Print Chart
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400 italic">No prescriptions found within
                            database system archives.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endblock --}}



@extends('layouts.app')

@section('content')

    <div class="p-8 max-w-[1400px] mx-auto">

        {{-- ── Header ── --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Prescriptions Archive</h1>
                <p class="text-sm text-slate-400 mt-1">View and print all patient consultation records.</p>
            </div>
            <a href="{{ route('prescriptions.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                + Create Prescription
            </a>
        </div>

        {{-- ── Flash messages ── --}}
        @if (session('success'))
            <div
                class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 font-semibold text-sm px-5 py-3 rounded-xl">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 font-semibold text-sm px-5 py-3 rounded-xl">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- ── Stats Row ── --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <p class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-1">Total Prescriptions</p>
                <p class="text-3xl font-black text-indigo-600">{{ $prescriptions->total() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <p class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-1">This Page</p>
                <p class="text-3xl font-black text-slate-700">{{ $prescriptions->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <p class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-1">Current Page</p>
                <p class="text-3xl font-black text-slate-700">{{ $prescriptions->currentPage() }} /
                    {{ $prescriptions->lastPage() }}</p>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b-2 border-slate-200 text-[11px] font-black uppercase tracking-widest text-slate-500">
                        <th class="px-5 py-4">#</th>
                        <th class="px-5 py-4">Patient ID</th>
                        <th class="px-5 py-4">Prescription ID</th>
                        <th class="px-5 py-4">Patient Name</th>
                        <th class="px-5 py-4">Prescription Date</th>
                        <th class="px-5 py-4">Next Meeting</th>
                        <th class="px-5 py-4">Doctor</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">

                    @forelse($prescriptions as $index => $prescription)
                        @php
                            $serial = ($prescriptions->currentPage() - 1) * $prescriptions->perPage() + $index + 1;
                            $patientId = $prescription->prescription_for_patient_id;
                            $rxId = $prescription->prescription_id;
                            $patientName = $prescription->patient->patient_name ?? '—';
                            $rxDate = $prescription->prescription_date
                                ? \Carbon\Carbon::parse($prescription->prescription_date)->format('d M Y')
                                : '—';
                            $nextMeeting = $prescription->next_meeting_date
                                ? \Carbon\Carbon::parse($prescription->next_meeting_date)->format('d M Y')
                                : null;
                            $doctorName = $prescription->doctor->doctors_name ?? '—';
                            $status = $prescription->prescription_status;

                            // Days until next meeting
                            $daysLeft = null;
                            $overdue = false;
                            if ($prescription->next_meeting_date) {
                                $daysLeft = now()->diffInDays(
                                    \Carbon\Carbon::parse($prescription->next_meeting_date),
                                    false,
                                );
                                $overdue = $daysLeft < 0;
                            }
                        @endphp
                        <tr class="hover:bg-indigo-50/30 transition-colors">

                            {{-- Serial No. --}}
                            <td class="px-5 py-4 font-black text-slate-400 text-xs">
                                {{ $serial }}
                            </td>

                            {{-- Patient ID --}}
                            <td class="px-5 py-4">
                                <span
                                    class="font-mono text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-bold">
                                    PT-{{ str_pad($patientId, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Prescription ID --}}
                            <td class="px-5 py-4">
                                <span
                                    class="font-mono text-xs bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-lg font-black border border-indigo-100">
                                    RX-{{ str_pad($rxId, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Patient Name --}}
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $patientName }}</div>
                                @if ($prescription->patient)
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $prescription->patient->patient_age ?? '' }}Y
                                        &nbsp;·&nbsp;
                                        {{ $prescription->patient->patient_gender ?? '' }}
                                    </div>
                                @endif
                            </td>

                            {{-- Prescription Date --}}
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-700">{{ $rxDate }}</div>
                            </td>

                            {{-- Next Meeting Date --}}
                            <td class="px-5 py-4">
                                @if ($nextMeeting)
                                    <div class="font-semibold {{ $overdue ? 'text-rose-600' : 'text-emerald-700' }}">
                                        {{ $nextMeeting }}
                                    </div>
                                    <div
                                        class="text-[11px] mt-0.5 font-bold
                                {{ $overdue ? 'text-rose-400' : ($daysLeft <= 3 ? 'text-amber-500' : 'text-slate-400') }}">
                                        @if ($overdue)
                                            ⚠️ {{ abs((int) $daysLeft) }}d overdue
                                        @elseif($daysLeft == 0)
                                            📅 Today
                                        @else
                                            in {{ (int) $daysLeft }}d
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-300 text-xs font-medium italic">Not scheduled</span>
                                @endif
                            </td>

                            {{-- Doctor --}}
                            <td class="px-5 py-4">
                                <div class="text-xs font-semibold text-slate-600">{{ $doctorName }}</div>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                @if ($status == 1)
                                    <span
                                        class="inline-flex items-center gap-1 text-[11px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full">
                                        ● Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 text-[11px] font-black bg-slate-100 text-slate-400 border border-slate-200 px-2.5 py-1 rounded-full">
                                        ● Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('prescriptions.show', $prescription->prescription_id) }}"
                                        class="inline-flex items-center gap-1 text-xs font-bold bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white px-3 py-1.5 rounded-lg border border-indigo-200 hover:border-indigo-600 transition-all">
                                        🔍 View
                                    </a>
                                    <a href="{{ route('prescriptions.show', $prescription->prescription_id) }}?print=1"
                                        class="inline-flex items-center gap-1 text-xs font-bold bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white px-3 py-1.5 rounded-lg border border-emerald-200 hover:border-emerald-600 transition-all">
                                        🖨️ Print
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-20 text-center">
                                <div class="text-4xl mb-3">📋</div>
                                <p class="text-slate-400 font-semibold text-sm">No prescriptions found.</p>
                                <a href="{{ route('prescriptions.create') }}"
                                    class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2 rounded-xl text-xs transition-colors">
                                    Create First Prescription
                                </a>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if ($prescriptions->hasPages())
            <div class="mt-6 flex items-center justify-between">
                <p class="text-xs text-slate-400 font-medium">
                    Showing {{ $prescriptions->firstItem() }}–{{ $prescriptions->lastItem() }}
                    of {{ $prescriptions->total() }} records
                </p>
                <div class="flex items-center gap-1">
                    {{-- Previous --}}
                    @if ($prescriptions->onFirstPage())
                        <span
                            class="px-4 py-2 text-xs font-bold text-slate-300 bg-slate-50 border border-slate-200 rounded-xl cursor-not-allowed">←
                            Prev</span>
                    @else
                        <a href="{{ $prescriptions->previousPageUrl() }}"
                            class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 transition-all">
                            ← Prev
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($prescriptions->getUrlRange(max(1, $prescriptions->currentPage() - 2), min($prescriptions->lastPage(), $prescriptions->currentPage() + 2)) as $page => $url)
                        @if ($page == $prescriptions->currentPage())
                            <span
                                class="px-4 py-2 text-xs font-black text-white bg-indigo-600 border border-indigo-600 rounded-xl">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($prescriptions->hasMorePages())
                        <a href="{{ $prescriptions->nextPageUrl() }}"
                            class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 transition-all">
                            Next →
                        </a>
                    @else
                        <span
                            class="px-4 py-2 text-xs font-bold text-slate-300 bg-slate-50 border border-slate-200 rounded-xl cursor-not-allowed">Next
                            →</span>
                    @endif
                </div>
            </div>
        @endif

    </div>

@endsection
