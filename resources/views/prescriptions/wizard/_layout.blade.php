<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Prescription Wizard' }} – RxMaster</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-800 min-h-screen">

    <div class="max-w-3xl mx-auto py-10 px-4">

        {{-- Header --}}
        <div class="flex items-center space-x-2 mb-6">
            <span class="text-2xl">🩺</span>
            <span class="text-xl font-black tracking-tight text-slate-900">RxMaster — Prescription Wizard</span>
        </div>

        {{-- Step progress bar --}}
        @php
            $steps = [
                1 => ['label' => 'Patient', 'route' => 'prescriptions.wizard.patient'],
                2 => ['label' => 'Complaints', 'route' => 'prescriptions.wizard.complaints'],
                3 => ['label' => 'Examination', 'route' => 'prescriptions.wizard.examinations'],
                4 => ['label' => 'Diagnosis', 'route' => 'prescriptions.wizard.diagnoses'],
                5 => ['label' => 'Investigation', 'route' => 'prescriptions.wizard.investigations'],
                6 => ['label' => 'Medicines', 'route' => 'prescriptions.wizard.medicines'],
                7 => ['label' => 'Advice', 'route' => 'prescriptions.wizard.advices'],
                8 => ['label' => 'Review', 'route' => 'prescriptions.wizard.review'],
            ];
            $currentStep = $currentStep ?? 1;
        @endphp

        <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-8 shadow-sm">
            <div class="flex items-center justify-between">
                @foreach ($steps as $num => $info)
                    <div class="flex-1 flex flex-col items-center {{ $num < count($steps) ? 'relative' : '' }}">
                        @if ($num < count($steps))
                            <div
                                class="absolute top-3 left-1/2 w-full h-0.5
                            {{ $num < $currentStep ? 'bg-indigo-500' : 'bg-slate-200' }}">
                            </div>
                        @endif
                        <div
                            class="relative z-10 h-7 w-7 rounded-full flex items-center justify-center text-[11px] font-black
                        {{ $num < $currentStep ? 'bg-indigo-600 text-white' : ($num === $currentStep ? 'bg-indigo-600 text-white ring-4 ring-indigo-100' : 'bg-slate-200 text-slate-500') }}">
                            {{ $num < $currentStep ? '✓' : $num }}
                        </div>
                        <span
                            class="mt-1.5 text-[10px] font-bold uppercase tracking-wide text-center
                        {{ $num === $currentStep ? 'text-indigo-600' : 'text-slate-400' }}">
                            {{ $info['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Active patient strip (shown from step 2 onward) --}}
        @if (isset($state) && !empty($state['patient']['name']))
            <div
                class="bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3 mb-6 flex items-center justify-between text-xs">
                <span class="font-bold text-indigo-900">
                    👤 {{ $state['patient']['name'] }}
                    <span class="font-medium text-indigo-500 ml-1">({{ $state['patient']['age'] }} yrs,
                        {{ $state['patient']['gender'] }})</span>
                </span>
                <a href="{{ route('prescriptions.wizard.patient') }}"
                    class="text-indigo-600 font-bold hover:underline">Change patient</a>
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-xl p-4 mb-6 text-sm font-semibold">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Status / flash message --}}
        @if (session('status'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 mb-6 text-sm font-semibold">
                {{ session('status') }}
            </div>
        @endif

        {{-- Page content --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl p-8 shadow-sm">
            {{ $slot }}
        </div>

    </div>
</body>

</html>
