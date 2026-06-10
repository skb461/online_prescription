@extends('layouts.app')

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
@endblock
