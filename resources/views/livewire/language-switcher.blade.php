<div class="flex items-center gap-2">
    <button
        wire:click="switchLanguage('fr')"
        type="button"
        class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
            {{ $currentLocale === 'fr' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
    >
        FR
    </button>

    <button
        wire:click="switchLanguage('ar')"
        type="button"
        class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
            {{ $currentLocale === 'ar' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
    >
        عربي
    </button>
</div>
