<div class="container py-section" style="max-width: 800px;">
    <a href="{{ route('services.index') }}" wire:navigate class="text-small mb-6" style="display:inline-block; color:var(--color-primary); font-weight:700;">
        {{ $locale === 'ar' ? '→ العودة إلى الخدمات' : '← Retour aux services' }}
    </a>

    <div class="card">
        <p class="text-small text-secondary mb-2" style="font-weight:700;">
            {{ $locale === 'ar' ? $service->groupeService?->titre_ar : $service->groupeService?->titre_fr }}
        </p>
        <h1 class="h2 mb-4">{{ $locale === 'ar' ? $service->titre_ar : $service->titre_fr }}</h1>

        @if ($service->type_service)
            <span class="badge badge-info mb-6">{{ $service->type_service }}</span>
        @endif

        <div class="mb-8">{!! $locale === 'ar' ? $service->description_ar : $service->description_fr !!}</div>

        @if ($service->documents_requis_fr || $service->documents_requis_ar)
            <div style="border-top:1px solid var(--color-outline-variant); padding-top:24px; margin-top:24px;">
                <h2 class="h3 mb-4">{{ $locale === 'ar' ? 'الوثائق المطلوبة' : 'Documents requis' }}</h2>
                <div>{!! $locale === 'ar' ? $service->documents_requis_ar : $service->documents_requis_fr !!}</div>
            </div>
        @endif

        <a href="{{ url('/demande-assistance/' . $service->id) }}" class="btn btn-primary mt-8">
            {{ $locale === 'ar' ? 'تقديم طلب مساعدة' : 'Faire une demande d\'assistance' }}
        </a>
    </div>
</div>
