{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RxMaster - Prescription System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-800 min-h-screen flex">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-900 text-slate-200 flex flex-col fixed inset-y-0 left-0 z-50 shadow-xl">
        <div class="p-5 border-b border-slate-800 flex items-center space-x-2">
            <span class="text-2xl">🩺</span>
            <span class="text-xl font-bold tracking-tight text-white">RxMaster Pro</span>
        </div>
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <a href="{{ route('prescriptions.create') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('prescriptions.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>📝</span> <span class="font-semibold text-sm">Create Prescription</span>
            </a>
            <a href="{{ route('prescriptions.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('prescriptions.index') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>📋</span> <span class="font-semibold text-sm">Prescriptions Log</span>
            </a>
            <div class="pt-4 pb-2 border-t border-slate-800 my-2">
                <span class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Registry</span>
            </div>
            <a href="{{ route('prescriptions.create') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('patients.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>👤</span> <span class="font-semibold text-sm">Register Patient</span>
            </a>
            <a href="{{ route('prescriptions.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('patients.index') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>👥</span> <span class="font-semibold text-sm">View All Patients</span>
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800 text-[11px] font-medium text-slate-500 text-center tracking-wide">
            Logged in as Admin/Doctor
        </div>
    </aside>

    <!-- Main Content Panel Wrapper (Fixed width offsetting sidebar width) -->
    <main class="flex-1 pl-64 min-w-0">
        <div class="p-8 max-w-[1600px] mx-auto">

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-200/60 text-emerald-800 rounded-2xl font-semibold text-sm shadow-sm flex items-center space-x-2 animate-in fade-in slide-in-from-top-2 duration-300">
                    <span class="text-base">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>

</html> --}}





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RxMaster - Prescription System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-800 min-h-screen flex">

    <aside class="w-64 bg-slate-900 text-slate-200 flex flex-col fixed inset-y-0 left-0 z-50 shadow-xl">
        <div class="p-5 border-b border-slate-800 flex items-center space-x-2">
            <span class="text-2xl">🩺</span>
            <span class="text-xl font-bold tracking-tight text-white">RxMaster Pro</span>
        </div>
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <a href="{{ route('prescriptions.create') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('prescriptions.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>📝</span> <span class="font-semibold text-sm">Create Prescription</span>
            </a>
            <a href="{{ route('prescriptions.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('prescriptions.index') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>📋</span> <span class="font-semibold text-sm">Prescriptions Log</span>
            </a>

            <div class="pt-4 pb-2 border-t border-slate-800 my-2">
                <span class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Registry</span>
            </div>

            <a href="{{ route('patients.create') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('patients.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>👤</span> <span class="font-semibold text-sm">Register Patient</span>
            </a>

            <a href="{{ route('patients.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all duration-200 {{ request()->routeIs('patients.index') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : '' }}">
                <span>👥</span> <span class="font-semibold text-sm">View All Patients</span>
            </a>

            <a href="{{ route('appointments.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 
                {{ request()->routeIs('appointments.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>📅</span>
                <span class="font-semibold text-sm">Appointments Hub</span>
            </a>

            <div>
                <a href="{{ route('appointments.create') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm shadow-md shadow-indigo-600/10 transition text-center">
                    + Create New Appointment
                </a>
            </div>
        </nav>
        <div class="p-4 border-t border-slate-800 text-[11px] font-medium text-slate-500 text-center tracking-wide">
            Logged in as Admin/Doctor
        </div>
        <div class="p-4 border-t border-slate-800 flex flex-col gap-2">
            <div class="text-[11px] font-medium text-slate-500 text-center tracking-wide">
                {{ $doctor->doctors_name ?? 'Logged in as Doctor' }}
            </div>

            <form action="{{ route('logout') }}" method="POST"
                onsubmit="return confirm('Log out of current workspace?');">
                @csrf
                <button type="submit"
                    class="w-full bg-slate-800 hover:bg-rose-950 text-slate-400 hover:text-rose-200 text-[10px] font-black uppercase tracking-widest py-2 rounded-lg transition-all cursor-pointer">
                    Sign Out 📴
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 pl-64 min-w-0">
        <div class="p-8 max-w-[1600px] mx-auto">

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-200/60 text-emerald-800 rounded-2xl font-semibold text-sm shadow-sm flex items-center space-x-2 animate-in fade-in slide-in-from-top-2 duration-300">
                    <span class="text-base">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>

</html>
