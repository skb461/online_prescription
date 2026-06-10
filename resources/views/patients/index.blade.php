@extends('layouts.app')

@block('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Patient Directory</h1>
            <p class="text-sm text-slate-500">Historical archive directory logs tracking registered system consumers.</p>
        </div>
        <a href="{{ route('patients.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
            + Register New Patient
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                    <th class="p-4">ID</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Age/Gender</th>
                    <th class="p-4">Phone Number</th>
                    <th class="p-4">Blood Group</th>
                    <th class="p-4">Registered Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($patients as $patient)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-mono text-slate-400">#{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-4 font-semibold text-slate-900">{{ $patient->name }}</td>
                        <td class="p-4">{{ $patient->age }}Y / {{ $patient->gender }}</td>
                        <td class="p-4 text-slate-500">{{ $patient->phone ?? '—' }}</td>
                        <td class="p-4"><span
                                class="px-2 py-0.5 bg-rose-50 text-rose-700 rounded text-xs font-bold border border-rose-100">{{ $patient->blood_group ?? 'N/A' }}</span>
                        </td>
                        <td class="p-4 text-slate-400 text-xs">{{ $patient->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-slate-400 italic">No patients found inside database
                            storage registry logs.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endblock
