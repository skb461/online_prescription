<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RxMaster Pro - Doctor Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white shadow-xl border border-slate-200/60 rounded-3xl p-8">

        <div class="text-center mb-8">
            <span class="text-4xl block mb-2">🩺</span>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">RxMaster Pro</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Sign in to manage patient consultations and scripts.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200/50 text-emerald-800 text-xs font-semibold rounded-xl flex items-center space-x-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">Email
                    Address</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="doctor@rxmaster.com"
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 placeholder-slate-400">
                </div>
                @error('email')
                    <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide">Password</label>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm transition-all focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 placeholder-slate-400">
                @error('password')
                    <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs font-semibold">
                <label class="flex items-center space-x-2 text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember"
                        class="rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 h-4 w-4">
                    <span>Remember Device</span>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl text-xs uppercase tracking-widest shadow-md shadow-indigo-600/10 transition-all cursor-pointer block text-center">
                Secure Log In
            </button>
        </form>

        {{-- <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500 font-medium">
                New to the system framework?
                <a href="{{ route('register') }}"
                    class="text-indigo-600 hover:text-indigo-700 font-bold ml-1 transition">Register here →</a>
            </p>
        </div> --}}

    </div>

</body>

</html>
