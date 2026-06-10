@extends('layouts.app')

@block('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 bg-slate-50 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Patient Intake Registry</h2>
            <p class="text-xs text-slate-500">Add profile demographics prior to setting up clinical consult pathways.</p>
        </div>

        <form action="{{ route('patients.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Full Legal Name</label>
                <input type="text" name="name" placeholder="John Doe"
                    class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 outline-none"
                    required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Age</label>
                    <input type="number" name="age" placeholder="35" min="0"
                        class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Assigned
                        Gender</label>
                    <select name="gender"
                        class="w-full border border-slate-300 rounded-xl p-3 bg-white focus:ring-2 focus:ring-indigo-500 outline-none"
                        required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Mobile Phone
                        No.</label>
                    <input type="text" name="phone" placeholder="+88017xxxxxxxx"
                        class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Blood Group
                        Type</label>
                    <select name="blood_group"
                        class="w-full border border-slate-300 rounded-xl p-3 bg-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">Unknown</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl shadow transition-colors mt-2">
                Commit Profile Registry
            </button>
        </form>
    </div>
@endblock
