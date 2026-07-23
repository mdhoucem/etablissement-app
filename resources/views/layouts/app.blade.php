@php
    $organisation = \App\Models\Organisation::where('status', 'actif')->first();
    $locale = app()->getLocale();
    $navItems = [
        ['route' => 'home', 'label_fr' => 'Accueil', 'label_ar' => 'الرئيسية'],
        ['route' => 'etablissement', 'label_fr' => 'La Fondation', 'label_ar' => 'المؤسسة'],
        ['route' => 'services.index', 'label_fr' => 'Services', 'label_ar' => 'الخدمات'],
        ['route' => 'actualites.index', 'label_fr' => 'Actualités', 'label_ar' => 'الأخبار'],
        ['route' => 'demande-assistance.form', 'label_fr' => 'Demande d\'assistance', 'label_ar' => 'طلب مساعدة'],
        ['route' => 'documentheque.index', 'label_fr' => 'Documenthèque', 'label_ar' => 'خزانة الوثائق'],
        ['route' => 'mediatheque.index', 'label_fr' => 'Médiathèque', 'label_ar' => 'المكتبة الوسائطية'],
        ['route' => 'contact.form', 'label_fr' => 'Contact', 'label_ar' => 'اتصل بنا'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $organisation ? ($locale === 'ar' ? $organisation->nom_ar : $organisation->nom_fr) : 'Établissement' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>

<header class="site-header" id="site-header">
    <div class="header-top">
        <div class="container header-top-inner">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-4">
                @if ($organisation?->logo)
                    <img src="{{ Storage::url($organisation->logo) }}" alt="Logo" class="header-logo">
                @endif
                <span class="header-brand">
                    {{ $organisation ? ($locale === 'ar' ? $organisation->nom_ar : $organisation->nom_fr) : '' }}
                </span>
            </a>

            <div class="flex items-center gap-6">
                <livewire:language-switcher />
                <a href="{{ route('demande-assistance.form') }}" wire:navigate class="btn btn-primary">
                    {{ $locale === 'ar' ? 'إيداع مطلب' : 'Déposer une demande' }}
                </a>
            </div>
        </div>
    </div>

    <nav class="main-nav">
        <div class="container main-nav-inner">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" wire:navigate class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    {{ $locale === 'ar' ? $item['label_ar'] : $item['label_fr'] }}
                </a>
            @endforeach
        </div>
    </nav>
</header>

<main>
    {{ $slot }}
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <div class="flex items-center gap-4 mb-6">
                @if ($organisation?->logo)
                    <img src="{{ Storage::url($organisation->logo) }}" alt="Logo" class="footer-logo">
                @endif
                <span class="h3" style="color:#fff;">{{ $organisation ? ($locale === 'ar' ? $organisation->nom_ar : $organisation->nom_fr) : '' }}</span>
            </div>
            <p class="footer-desc">
                {{ $locale === 'ar' ? ($organisation?->meta_description_ar_default ?? '') : ($organisation?->meta_description_fr_default ?? '') }}
            </p>
        </div>

        <div class="footer-nav">
            <p class="footer-title">{{ $locale === 'ar' ? 'التصفح' : 'Navigation' }}</p>
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" wire:navigate>{{ $locale === 'ar' ? $item['label_ar'] : $item['label_fr'] }}</a>
            @endforeach
        </div>

        <div>
            <p class="footer-title">{{ $locale === 'ar' ? 'اتصال رسمي' : 'Contact Officiel' }}</p>
            @if ($organisation?->adresse_fr)
                <div class="footer-contact-item">
                    <span class="material-symbols-outlined">location_on</span>
                    <span>{{ $locale === 'ar' ? $organisation->adresse_ar : $organisation->adresse_fr }}</span>
                </div>
            @endif
            @if ($organisation?->telephone)
                <div class="footer-contact-item">
                    <span class="material-symbols-outlined">call</span>
                    <span>{{ $organisation->telephone }}</span>
                </div>
            @endif
            @if ($organisation?->numero_vert)
                <div class="footer-contact-item text-secondary" style="color: var(--color-secondary-fixed);">
                    <span class="material-symbols-outlined">support_agent</span>
                    <span>{{ $locale === 'ar' ? 'الرقم الأخضر' : 'Numéro Vert' }}: {{ $organisation->numero_vert }}</span>
                </div>
            @endif
            @if ($organisation?->email)
                <div class="footer-contact-item">
                    <span class="material-symbols-outlined">mail</span>
                    <span>{{ $organisation->email }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} {{ $locale === 'ar' ? 'الجمهورية التونسية' : 'République Tunisienne' }} — {{ $locale === 'ar' ? 'جميع الحقوق محفوظة' : 'Tous droits réservés' }}
    </div>
</footer>

<script>
    window.addEventListener('scroll', () => {
        document.getElementById('site-header').classList.toggle('scrolled', window.scrollY > 20);
    });
</script>

@livewireScripts
</body>
</html>