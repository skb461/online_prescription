<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RxMaster - Practitioner Onboarding</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-800 min-h-screen flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-4xl bg-white shadow-xl border border-slate-200/60 rounded-3xl p-8">

        <div class="border-b border-slate-100 pb-4 mb-6 text-center">
            <span class="text-4xl">🩺</span>
            <h2 class="text-2xl font-black text-slate-900 mt-2">Practitioner Registration System</h2>
            <p class="text-xs text-slate-500 mt-1">Setup user account parameters, clinic assignments, and fee schedules.
            </p>
        </div>

        @if ($errors->has('error'))
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200/60 text-rose-800 rounded-xl text-xs font-bold">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <h3
                    class="text-xs font-black text-indigo-600 uppercase tracking-widest border-b border-slate-100 pb-1.5 mb-3">
                    1. Login Credentials</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Email
                            Address <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        @error('email')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Password
                            <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        @error('password')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Confirm
                            Password <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div>
                <h3
                    class="text-xs font-black text-indigo-600 uppercase tracking-widest border-b border-slate-100 pb-1.5 mb-3">
                    2. Professional Profile</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 space-y-0">
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Full Name
                            <span class="text-rose-500">*</span></label>
                        <input type="text" name="doctors_name" value="{{ old('doctors_name') }}" required
                            placeholder="e.g. Dr. Mohammad Rahman"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        @error('doctors_name')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">BMDC Reg.
                            Number</label>
                        <input type="text" name="bmdc_number" value="{{ old('bmdc_number') }}"
                            placeholder="e.g. BMDC-202609"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        @error('bmdc_number')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Designations</label>
                        <input type="text" name="doctors_designations" value="{{ old('doctors_designations') }}"
                            placeholder="e.g. MBBS, FCPS (Medicine)"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Speciality</label>
                        <input type="text" name="doctors_speciality" value="{{ old('doctors_speciality') }}"
                            placeholder="e.g. Internal Medicine"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Department</label>
                        <input type="text" name="doctors_department" value="{{ old('doctors_department') }}"
                            placeholder="e.g. Cardiology"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Phone
                            Number</label>
                        <input type="text" name="doctors_phone_number" value="{{ old('doctors_phone_number') }}"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Gender</label>
                        <select name="doctors_gender"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Doctor
                            Type</label>
                        <select name="doctors_type"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                            <option value="Permanent">Permanent</option>
                            <option value="Guest">Guest</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">NID
                            Number</label>
                        <input type="text" name="doctors_nid" value="{{ old('doctors_nid') }}"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Nationality</label>
                        <input type="text" name="doctors_nationality"
                            value="{{ old('doctors_nationality', 'Bangladeshi') }}"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Address /
                            Practice Chamber</label>
                        <input type="text" name="doctors_address" value="{{ old('doctors_address') }}"
                            placeholder="Chamber Location"
                            class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div>
                <h3
                    class="text-xs font-black text-indigo-600 uppercase tracking-widest border-b border-slate-100 pb-1.5 mb-3">
                    3. Operational Schedule &amp; Visiting Fees</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start">
                    <div>
                        <label
                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">Visiting
                            Days <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2 bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                            @foreach (['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
                                <label
                                    class="inline-flex items-center space-x-2 text-xs font-semibold text-slate-700 cursor-pointer">
                                    <input type="checkbox" name="visiting_days[]" value="{{ $day }}"
                                        class="rounded text-indigo-600">
                                    <span>{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('visiting_days')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Visiting
                                Time Frame</label>
                            <input type="text" name="visiting_time"
                                value="{{ old('visiting_time', '18:00:00') }}" placeholder="e.g. 18:00:00 or 4:00 PM"
                                class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">New
                                Patient Fee <span class="text-rose-500">*</span></label>
                            <input type="number" name="fees_new" value="{{ old('fees_new', '800.00') }}"
                                step="0.01" required
                                class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1">Old
                                (Follow-up) Fee <span class="text-rose-500">*</span></label>
                            <input type="number" name="fees_old" value="{{ old('fees_old', '500.00') }}"
                                step="0.01" required
                                class="block w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest py-3 px-8 rounded-xl shadow-md shadow-indigo-600/10 transition cursor-pointer">
                    Finalize Registration
                </button>
            </div>
        </form>
    </div>

</body>

</html>
