<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'L\'Établissement' }}</title>

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <!-- Navbar simple avec sélecteur de langue -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="font-bold text-xl text-primary-600">
                L'Établissement
            </div>

            <!-- Sélecteur de langue -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('lang.switch', 'fr') }}" class="{{ app()->getLocale() == 'fr' ? 'font-bold text-blue-600' : 'text-gray-500' }}">FR</a>
                <span>|</span>
                <a href="{{ route('lang.switch', 'ar') }}" class="{{ app()->getLocale() == 'ar' ? 'font-bold text-blue-600' : 'text-gray-500' }}">العربية</a>
            </div>
        </div>
    </header>

    <!-- Contenu de la page -->
    <main class="py-8">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
