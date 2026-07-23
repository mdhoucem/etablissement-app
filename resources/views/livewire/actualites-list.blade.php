<div class="container py-section">
    <div class="flex flex-wrap gap-2 mb-8">
        @foreach ([
            '' => $locale === 'ar' ? 'الكل' : 'Tout',
            'actualite' => $locale === 'ar' ? 'أخبار' : 'Actualités',
            'evenement' => $locale === 'ar' ? 'أحداث' : 'Événements',
            'annonce' => $locale === 'ar' ? 'إعلانات' : 'Annonces',
        ] as $value => $label)
            <button wire:click="$set('typeFiltre', '{{ $value }}')" type="button"
                class="btn {{ $typeFiltre === $value ? 'btn-primary' : 'btn-ghost' }}" style="border-radius: var(--radius-full); padding: 8px 20px;">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div wire:loading.class="opacity-50">
        @if ($actualites->count())
            <div class="grid grid-3">
                @foreach ($actualites as $actu)
                    <a href="{{ route('actualites.detail', $actu->id) }}" wire:navigate class="card" style="padding: 0; overflow: hidden;">
                        @if ($actu->image)
                            <img src="{{ Storage::url($actu->image) }}" alt="" style="width:100%; height:176px; object-fit:cover;">
                        @endif
                        <div style="padding: 20px;">
                            @if ($actu->featured)
                                <span class="badge badge-featured mb-2">{{ $locale === 'ar' ? 'مميز' : 'À la une' }}</span>
                            @endif
                            <p class="text-small text-muted mb-2">{{ optional($actu->date_publication)->format('d/m/Y') }}</p>
                            <h3 class="h3" style="font-size: 1.1rem;">{{ $locale === 'ar' ? $actu->titre_ar : $actu->titre_fr }}</h3>
                            <p class="text-small text-muted mt-2">{{ Str::limit($locale === 'ar' ? $actu->resume_ar : $actu->resume_fr, 100) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="pagination">{{ $actualites->links() }}</div>
        @else
            <div class="empty-state">{{ $locale === 'ar' ? 'لا توجد أخبار متاحة حاليا' : 'Aucune actualité disponible pour le moment.' }}</div>
        @endif
    </div>
</div>
