@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-sm border border-slate-200/80 rounded-2xl p-6 md:p-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Patient Registry</h2>
                <p class="text-xs text-slate-500 mt-1">Lookup, search, and manage master patient information files.</p>
            </div>
            <div>
                <a href="{{ route('patients.create') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm shadow-md shadow-indigo-600/10 transition text-center">
                    + Register New Patient
                </a>
            </div>
        </div>

        <div class="my-6">
            <form action="{{ route('patients.index') }}" method="GET" class="flex items-center gap-2 max-w-md">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by patient name or phone..."
                        class="block w-full pl-4 pr-10 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 placeholder-slate-400 text-slate-700">
                </div>
                <button type="submit"
                    class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm cursor-pointer">
                    Search
                </button>
                @if (request('search'))
                    <a href="{{ route('patients.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium px-4 py-2.5 rounded-xl transition flex items-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto border border-slate-100 rounded-xl">
            <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                <thead class="bg-slate-50/70 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Age / Sex</th>
                        <th class="px-6 py-4">Phone Number</th>
                        <th class="px-6 py-4">Address Summary</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-slate-400 text-xs">
                                #{{ $patient->patient_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-900 font-semibold">
                                {{ $patient->patient_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                {{ $patient->patient_age ?? '—' }} Yrs <span class="text-slate-300 mx-1">|</span>
                                {{ $patient->patient_gender ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">
                                {{ $patient->patient_phone_number ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate text-xs">
                                {{ collect([$patient->patient_union_village, $patient->patient_district, $patient->patient_division])->filter()->implode(', ') ?:'—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($patient->patient_status == 1)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-50 text-slate-400 border border-slate-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-normal">
                                <span class="text-2xl block mb-2">📂</span>
                                No matching patient files found in database records.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $patients->withQueryString()->links() }}
        </div>

    </div>
@endsection
