<div class="lang-switch">
    <button wire:click="switchLanguage('fr')" type="button" class="{{ $currentLocale === 'fr' ? 'active' : '' }}">
        Français
    </button>
    <span style="color: var(--color-outline-variant);">|</span>
    <button wire:click="switchLanguage('ar')" type="button" class="ar-label {{ $currentLocale === 'ar' ? 'active' : '' }}">
        العربية
    </button>
</div>
