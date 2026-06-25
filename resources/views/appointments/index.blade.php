@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-sm border border-slate-200/80 rounded-2xl p-6 md:p-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Appointment Schedule</h2>
                <p class="text-xs text-slate-500 mt-1">Review, confirm, or cancel incoming patient appointments.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('appointments.index') }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold border {{ !request('status') ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100' }}">All</a>
                <a href="{{ route('appointments.index', ['status' => 1]) }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold border {{ request('status') == 1 ? 'bg-amber-600 text-white border-amber-600' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100' }}">Pending</a>
                <a href="{{ route('appointments.index', ['status' => 2]) }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold border {{ request('status') == 2 ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100' }}">Confirmed</a>
                <a href="{{ route('appointments.index', ['status' => 3]) }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold border {{ request('status') == 3 ? 'bg-rose-600 text-white border-rose-600' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100' }}">Cancelled</a>
            </div>
        </div>

        <div class="overflow-x-auto border border-slate-100 rounded-xl mt-6">
            <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                <thead class="bg-slate-50/70 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-6 py-4">Appointment ID</th>
                        <th class="px-6 py-4">Patient Profile</th>
                        <th class="px-6 py-4">Phone Number</th>
                        <th class="px-6 py-4">Date &amp; Time Slot</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions Matrix</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-slate-400 text-xs">
                                #{{ $appointment->appointment_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-900 font-semibold">
                                {{ $appointment->patient->patient_name ?? 'Unknown Patient' }}
                                <span class="text-xs font-medium text-slate-400 block mt-0.5">Age:
                                    {{ $appointment->patient->patient_age ?? '—' }} |
                                    {{ $appointment->patient->patient_gender ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">
                                {{ $appointment->patient->patient_phone_number ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-slate-900 font-semibold block">{{ date('d M, Y', strtotime($appointment->appointment_date)) }}</span>
                                <span class="text-xs font-mono text-indigo-600 block mt-0.5">⏰
                                    {{ date('h:i A', strtotime($appointment->appointment_date)) }}</span>
                            </td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($appointment->appointment_status == 1)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                                    @elif($appointment->appointment_status == 2)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Confirmed</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">Cancelled</span>
                                @endif
                            </td> --}}
                            {{-- Locate this section inside resources/views/appointments/index.blade.php --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($appointment->appointment_status == 1)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>

                                    {{-- FIXED: Changed @elif to @elseif --}}
                                @elseif($appointment->appointment_status == 2)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Confirmed</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right space-x-1">
                                @if ($appointment->appointment_status == 1)
                                    <form action="{{ route('appointments.updateStatus', $appointment->appointment_id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="2">
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm cursor-pointer">
                                            Confirm
                                        </button>
                                    </form>

                                    <form action="{{ route('appointments.updateStatus', $appointment->appointment_id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="3">
                                        <button type="submit" onclick="return confirm('Cancel this appointment slot?');"
                                            class="px-3 py-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 text-xs font-bold rounded-xl transition cursor-pointer">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic">No actions available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-normal">
                                <span class="text-2xl block mb-2">📅</span>
                                No appointments found for your profile criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $appointments->withQueryString()->links() }}
        </div>

    </div>
@endsection
