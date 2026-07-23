<div class="container py-section" style="max-width: 800px;">
    <a href="{{ route('actualites.index') }}" wire:navigate class="text-small mb-6" style="display:inline-block; color:var(--color-primary); font-weight:700;">
        {{ $locale === 'ar' ? '→ العودة إلى الأخبار' : '← Retour aux actualités' }}
    </a>

    <article class="card" style="padding:0; overflow:hidden;">
        @if ($actualite->image)
            <img src="{{ Storage::url($actualite->image) }}" alt="" style="width:100%; height:288px; object-fit:cover;">
        @endif

        <div style="padding: 32px;">
            <p class="text-small text-muted mb-2">
                {{ optional($actualite->date_publication)->format('d/m/Y') }}
                @if ($actualite->lieu_evenement) · {{ $actualite->lieu_evenement }} @endif
            </p>

            <h1 class="h2 mb-6">{{ $locale === 'ar' ? $actualite->titre_ar : $actualite->titre_fr }}</h1>

            <div>{!! $locale === 'ar' ? $actualite->contenu_ar : $actualite->contenu_fr !!}</div>

            @if ($actualite->galerie_photos && count($actualite->galerie_photos))
                <div class="grid grid-3 mt-8">
                    @foreach ($actualite->galerie_photos as $photo)
                        <img src="{{ Storage::url($photo) }}" alt="" style="width:100%; height:128px; object-fit:cover; border-radius:var(--radius);">
                    @endforeach
                </div>
            @endif
        </div>
    </article>
</div>
