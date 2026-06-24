<div class="flex flex-col w-64 h-screen px-4 py-8 bg-white border-r border-gray-200">
    <div class="flex items-center px-2">
        <span class="text-xl font-bold text-gray-800 tracking-wide">Prescription System</span>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="space-y-6">

            <div>
                <span class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Patient Records
                </span>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('patients.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-md group
                       {{ request()->routeIs('patients.index') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Patient Directory
                    </a>

                    <a href="{{ route('patients.create') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-md group
                       {{ request()->routeIs('patients.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 011 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Register Patient
                    </a>
                </div>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Prescriptions
                </span>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('prescriptions.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-md group
                       {{ request()->routeIs('prescriptions.index') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        All Prescriptions
                    </a>

                    <a href="{{ route('prescriptions.create') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-md group
                       {{ request()->routeIs('prescriptions.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Create Prescription
                    </a>

                    <a href="{{ route('prescriptions.printPreview') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-md group
                       {{ request()->routeIs('prescriptions.printPreview') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Preview
                    </a>
                </div>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Developer Tools
                </span>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('prescriptions.debugTest') }}"
                        class="flex items-center px-4 py-2 text-xs font-mono transition-colors duration-200 rounded-md group
                       {{ request()->routeIs('prescriptions.debugTest') ? 'bg-amber-500 text-white' : 'text-amber-600 hover:bg-amber-50 hover:text-amber-800' }}">
                        <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        debug-test
                    </a>
                </div>
            </div>

        </nav>

        <div class="pt-4 border-t border-gray-100">
            <form action="{{ route('prescriptions.clearSession') }}" method="POST"
                onsubmit="return confirm('Clear current prescription entry cache?');">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center px-4 py-2 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition duration-150 cursor-pointer">
                    Clear Input Session
                </button>
            </form>
        </div>
    </div>
</div>
