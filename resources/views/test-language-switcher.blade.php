<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>Test Language Switcher</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans">
    <div class="bg-white shadow-md rounded-xl p-8 max-w-md w-full text-center">
        <h1 class="text-2xl font-bold mb-4">
            {{ app()->getLocale() === 'ar' ? 'مرحبا بكم' : 'Bienvenue' }}
        </h1>
        <p class="text-gray-500 mb-6">
            {{ app()->getLocale() === 'ar' ? 'اختبار تبديل اللغة والاتجاه' : 'Test du switch de langue et de direction' }}
        </p>

        <div class="flex justify-center">
            <livewire:language-switcher />
        </div>
    </div>

    @livewireScripts
</body>
</html>
