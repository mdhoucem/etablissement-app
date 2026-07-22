<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Établissement App' }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        @livewireStyles
    </head>
    <body class="bg-gray-50 min-h-screen text-gray-800">
        <nav class="bg-white shadow-sm border-b mb-8 p-4">
            <div class="max-w-7xl mx-auto flex space-x-6 font-medium">
                <a href="/contact" class="text-indigo-600 hover:underline">Page Contact</a>
                <a href="/actualites" class="text-indigo-600 hover:underline">Page Actualités</a>
                <a href="/admin" class="text-gray-500 hover:underline">Panneau Admin Filament</a>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
