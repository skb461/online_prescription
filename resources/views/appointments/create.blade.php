{{-- @extends('layouts.app')

@section('content')
    <div class="max-w-2xl bg-white shadow-sm border border-slate-200/80 rounded-2xl p-6 md:p-8">

        <div class="border-b border-slate-100 pb-4 mb-6">
            <h2 class="text-xl font-bold text-slate-900">Book New Appointment</h2>
            <p class="text-xs text-slate-500 mt-1">Assign an appointment slot to an existing registered patient file.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200/60 text-rose-800 rounded-xl text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Select Patient <span
                        class="text-rose-500">*</span></label>
                <select name="patient_id" required
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 font-medium text-slate-700">
                    <option value="">— Choose Patient File —</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->patient_id }}"
                            {{ old('patient_id') == $patient->patient_id ? 'selected' : '' }}>
                            {{ $patient->patient_name }} ({{ $patient->patient_phone_number ?? 'No Phone' }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Can't find the patient? <a href="{{ route('patients.create') }}"
                        class="text-indigo-600 font-bold hover:underline">Register them first →</a></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Appointment Date
                        <span class="text-rose-500">*</span></label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date', date('Y-m-d')) }}"
                        min="{{ date('Y-m-d') }}" required
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Time Slot <span
                            class="text-rose-500">*</span></label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time', '18:00') }}" required
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('appointments.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                    Back to Hub
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl text-sm shadow-md shadow-indigo-600/10 transition cursor-pointer">
                    Confirm Booking Slot
                </button>
            </div>
        </form>
    </div>
@endsection --}}


@extends('layouts.app')

@section('content')
    <div class="max-w-2xl bg-white shadow-sm border border-slate-200/80 rounded-2xl p-6 md:p-8">

        <div class="border-b border-slate-100 pb-4 mb-6">
            <h2 class="text-xl font-bold text-slate-900">Book New Appointment</h2>
            <p class="text-xs text-slate-500 mt-1">Assign an appointment slot to a patient and doctor profile.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200/60 text-rose-800 rounded-xl text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Select Patient <span
                        class="text-rose-500">*</span></label>
                <select name="patient_id" required
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 font-medium text-slate-700">
                    <option value="">— Choose Patient File —</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->patient_id }}"
                            {{ old('patient_id') == $patient->patient_id ? 'selected' : '' }}>
                            {{ $patient->patient_name }} ({{ $patient->patient_phone_number ?? 'No Phone' }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Can't find the patient? <a href="{{ route('patients.create') }}"
                        class="text-indigo-600 font-bold hover:underline">Register them first →</a></p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Assigned Doctor <span
                        class="text-rose-500">*</span></label>
                <select name="doctors_id" required
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 font-medium text-slate-700">
                    <option value="">— Choose Practitioner —</option>
                    @foreach ($doctors as $doc)
                        <option value="{{ $doc->doctors_id }}"
                            {{ old('doctors_id', isset($doctor) ? $doctor->doctors_id : '') == $doc->doctors_id ? 'selected' : '' }}>
                            {{ $doc->doctors_name }} ({{ $doc->doctors_speciality ?? 'General Medicine' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Appointment Date
                        <span class="text-rose-500">*</span></label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date', date('Y-m-d')) }}"
                        min="{{ date('Y-m-d') }}" required
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Time Slot <span
                            class="text-rose-500">*</span></label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time', '18:00') }}" required
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('appointments.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                    Back to Hub
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl text-sm shadow-md shadow-indigo-600/10 transition cursor-pointer">
                    Confirm Booking Slot
                </button>
            </div>
        </form>
    </div>
@endsection
