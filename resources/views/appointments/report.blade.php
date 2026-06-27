@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5 no-print">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Appointments Analysis Report</h2>
                <p class="text-xs text-slate-500 mt-1">Review operational capacity metrics, booking volume, and attendance
                    statuses.</p>
            </div>
            <div>
                <button onclick="window.print()"
                    class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-5 rounded-xl text-sm shadow-sm transition">
                    Print Report 🖨️
                </button>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm no-print">
            <form method="GET" action="{{ route('appointments.report') }}"
                class="grid grid-cols-1 sm:grid-cols-4 items-end gap-4">

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">Start
                        Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="block w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">End
                        Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="block w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">Filter By
                        Doctor</label>
                    <select name="doctors_id"
                        class="block w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 font-semibold text-slate-700">
                        <option value="">— All Doctors —</option>
                        @foreach ($doctors as $doc)
                            <option value="{{ $doc->doctors_id }}"
                                {{ request('doctors_id') == $doc->doctors_id ? 'selected' : '' }}>
                                {{ $doc->doctors_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs uppercase tracking-wider py-3 rounded-xl shadow-sm transition">
                    Filter Matrix
                </button>
            </form>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Total Booked</span>
                <span class="text-2xl font-black text-slate-900 block mt-1">{{ $totalAppointments }}</span>
            </div>
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm">
                <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest block">Pending Queue</span>
                <span class="text-2xl font-black text-amber-600 block mt-1">{{ $pendingCount }}</span>
            </div>
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm">
                <span
                    class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block">Served/Confirmed</span>
                <span class="text-2xl font-black text-emerald-600 block mt-1">{{ $confirmedCount }}</span>
            </div>
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Cancelled</span>
                <span class="text-2xl font-black text-rose-600 block mt-1">{{ $cancelledCount }}</span>
            </div>
        </div>

        <div class="hidden print:block border-b-2 border-slate-900 pb-4 mb-6">
            <h1 class="text-2xl font-black text-slate-900">RxMaster Pro Consultation Audit</h1>
            <p class="text-xs font-mono font-bold text-slate-500">
                Timeline Query Frame: {{ $startDate }} to {{ $endDate }}
                @if (request('doctors_id'))
                    | Filtered Target Practitioner ID: #{{ request('doctors_id') }}
                @endif
            </p>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-slate-50 text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Patient Profile Name</th>
                            <th class="px-4 py-3">Assigned Doctor</th>
                            <th class="px-4 py-3">Contact Number</th>
                            <th class="px-4 py-3">Scheduled DateTime</th>
                            <th class="px-4 py-3 text-center">Status Badge</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                        @forelse($reportData as $row)
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="px-4 py-3 font-mono text-xs text-slate-400">#{{ $row->appointment_id }}</td>
                                <td class="px-4 py-3 text-slate-900 font-semibold">
                                    {{ $row->patient->patient_name ?? 'Anonymous File' }}
                                    <span class="text-[11px] text-slate-400 font-normal block">Age:
                                        {{ $row->patient->patient_age ?? '—' }} |
                                        {{ $row->patient->patient_gender ?? '—' }}</span>
                                </td>

                                <td class="px-4 py-3 text-slate-800 font-semibold text-xs whitespace-nowrap">
                                    🩺 {{ $row->doctor->doctors_name ?? 'Unassigned' }}
                                </td>

                                <td class="px-4 py-3 font-mono text-xs">{{ $row->patient->patient_phone_number ?? '—' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span
                                        class="block text-slate-800">{{ date('d M, Y', strtotime($row->appointment_date)) }}</span>
                                    <span class="block text-[11px] font-mono text-indigo-600 mt-0.5">⏰
                                        {{ date('h:i A', strtotime($row->appointment_date)) }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($row->appointment_status == 1)
                                        <span
                                            class="inline-flex px-2 py-0.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                                    @elseif($row->appointment_status == 2)
                                        <span
                                            class="inline-flex px-2 py-0.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Confirmed</span>
                                    @else
                                        <span
                                            class="inline-flex px-2 py-0.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-slate-400 text-xs italic">
                                    No allocation logs registered across this specified date-range window selection.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
