<div class="container py-section">
    <div class="flex flex-col gap-4 mb-8" style="flex-direction: row; flex-wrap: wrap;">
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="{{ $locale === 'ar' ? 'ابحث عن خدمة...' : 'Rechercher un service...' }}"
            class="flex-1" style="border:1px solid var(--color-outline-variant); border-radius:var(--radius); padding:12px 16px;">

        <select wire:model.live="groupeServiceId" style="border:1px solid var(--color-outline-variant); border-radius:var(--radius); padding:12px 16px; min-width:220px;">
            <option value="">{{ $locale === 'ar' ? 'كل الفئات' : 'Tous les groupes' }}</option>
            @foreach ($groupes as $groupe)
                <option value="{{ $groupe->id }}">{{ $locale === 'ar' ? $groupe->titre_ar : $groupe->titre_fr }}</option>
            @endforeach
        </select>

        @if ($search || $groupeServiceId)
            <button wire:click="resetFilters" type="button" class="btn btn-ghost">
                {{ $locale === 'ar' ? 'إعادة تعيين' : 'Réinitialiser' }}
            </button>
        @endif
    </div>

    <div wire:loading.class="opacity-50">
        @if ($services->count())
            <div class="grid grid-3">
                @foreach ($services as $service)
                    <a href="{{ route('services.detail', $service->slug) }}" wire:navigate class="card">
                        @if ($service->featured)
                            <span class="badge badge-featured mb-4">{{ $locale === 'ar' ? 'مميز' : 'À la une' }}</span>
                        @endif
                        <p class="text-small text-secondary mb-2" style="font-weight:700;">
                            {{ $locale === 'ar' ? $service->groupeService?->titre_ar : $service->groupeService?->titre_fr }}
                        </p>
                        <h3 class="h3">{{ $locale === 'ar' ? $service->titre_ar : $service->titre_fr }}</h3>
                        @if ($service->type_service)
                            <p class="text-small text-muted mt-2">{{ $service->type_service }}</p>
                        @endif
                        <span class="text-small mt-4" style="display:inline-block; color:var(--color-primary); font-weight:700;">
                            {{ $locale === 'ar' ? 'اقرأ المزيد ←' : 'Voir le détail →' }}
                        </span>
                    </a>
                @endforeach
            </div>
            <div class="pagination">{{ $services->links() }}</div>
        @else
            <div class="empty-state">{{ $locale === 'ar' ? 'لا توجد خدمات مطابقة' : 'Aucun service ne correspond à votre recherche.' }}</div>
        @endif
    </div>
</div>
