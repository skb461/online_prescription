@extends('layouts.app')

@section('content')
    <div class="max-w-3xl bg-white shadow-sm border border-slate-200/80 rounded-2xl p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6">
            <h2 class="text-xl font-bold text-slate-900">Register New Patient</h2>
            <p class="text-xs text-slate-500 mt-1">Add a new patient record to the system directory.</p>
        </div>

        <form action="{{ route('patients.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Patient Name <span
                        class="text-rose-500">*</span></label>
                <input type="text" name="patient_name" value="{{ old('patient_name') }}" required
                    placeholder="Enter full name"
                    class="block w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                @error('patient_name')
                    <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Age</label>
                    <input type="number" name="patient_age" value="{{ old('patient_age') }}" min="0" max="150"
                        placeholder="Years"
                        class="block w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    @error('patient_age')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Gender</label>
                    <select name="patient_gender"
                        class="block w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('patient_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('patient_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('patient_gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('patient_gender')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Phone Number</label>
                <input type="text" name="patient_phone_number" value="{{ old('patient_phone_number') }}"
                    placeholder="e.g. 017XXXXXXXX"
                    class="block w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                @error('patient_phone_number')
                    <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <div
                    class="text-xs font-bold text-indigo-600 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">
                    Address Details
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Division</label>
                        <input type="text" name="patient_division" value="{{ old('patient_division') }}"
                            placeholder="Division"
                            class="block w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        @error('patient_division')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">District</label>
                        <input type="text" name="patient_district" value="{{ old('patient_district') }}"
                            placeholder="District"
                            class="block w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        @error('patient_district')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Union /
                            Village</label>
                        <input type="text" name="patient_union_village" value="{{ old('patient_union_village') }}"
                            placeholder="Village/Union"
                            class="block w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        @error('patient_union_village')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('patients.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl text-sm shadow-md shadow-indigo-600/10 transition cursor-pointer">
                    Save Profile
                </button>
            </div>
        </form>
    </div>
@endsection
