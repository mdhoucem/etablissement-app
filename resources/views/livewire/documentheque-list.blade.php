<div class="container py-section">

    <div class="mb-8" style="border-inline-start: 4px solid var(--color-secondary); padding-inline-start: 20px;">
        <h1 class="h1 mb-2">{{ $locale === 'ar' ? 'خزانة الوثائق' : 'Documenthèque' }}</h1>
        <p class="text-muted" style="max-width: 640px;">
            {{ $locale === 'ar' ? 'الوصول إلى جميع الوثائق الإدارية والنماذج والأدلة الرسمية.' : 'Accédez à l\'ensemble des documents administratifs, formulaires et guides officiels.' }}
        </p>
    </div>

    <div class="field mb-8" style="max-width: 500px;">
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="{{ $locale === 'ar' ? 'بحث عن وثيقة...' : 'Rechercher un document (nom, mot-clé...)' }}">
    </div>

    <div class="grid" style="grid-template-columns: 280px 1fr; gap: var(--gutter); align-items: start;">

        {{-- Sidebar catégories --}}
        <aside class="card" style="padding: 20px;">
            <h3 class="h3 mb-4" style="font-size: 1.1rem;">{{ $locale === 'ar' ? 'الأصناف' : 'Catégories' }}</h3>
            <div class="flex flex-col gap-2">
                <button wire:click="selectCategorie('')" type="button"
                    class="flex justify-between items-center"
                    style="width:100%; text-align: start; padding: 10px 14px; border-radius: var(--radius); border: none; font-weight: 700;
                        background: {{ $categorieFiltre === '' ? 'var(--color-primary)' : 'transparent' }};
                        color: {{ $categorieFiltre === '' ? '#fff' : 'var(--color-on-surface)' }};">
                    <span>{{ $locale === 'ar' ? 'جميع الوثائق' : 'Tous les documents' }}</span>
                    <span class="text-small">{{ $totalAll }}</span>
                </button>

                @foreach ($categories as $key => $labels)
                    <button wire:click="selectCategorie('{{ $key }}')" type="button"
                        class="flex justify-between items-center"
                        style="width:100%; text-align: start; padding: 10px 14px; border-radius: var(--radius); border: none; font-weight: 600;
                            background: {{ $categorieFiltre === $key ? 'var(--color-primary)' : 'transparent' }};
                            color: {{ $categorieFiltre === $key ? '#fff' : 'var(--color-on-surface)' }};">
                        <span>{{ $locale === 'ar' ? $labels['ar'] : $labels['fr'] }}</span>
                        <span class="text-small">{{ $counts[$key] ?? 0 }}</span>
                    </button>
                @endforeach
            </div>
        </aside>

        {{-- Liste des documents --}}
        <div wire:loading.class="opacity-50">
            @if ($documents->count())
                <div class="flex flex-col gap-4">
                    @foreach ($documents as $doc)
                        <div class="card" style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:16px;">
                            <div class="flex items-center gap-4">
                                <div style="width:48px; height:48px; border-radius: var(--radius); background: var(--color-secondary-fixed); color: var(--color-secondary); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <span class="material-symbols-outlined" style="font-size:28px;">description</span>
                                </div>
                                <div>
                                    <h4 style="font-weight:700; color:var(--color-primary); margin:0 0 4px;">
                                        {{ $locale === 'ar' ? $doc->titre_ar : $doc->titre_fr }}
                                    </h4>
                                    <p class="text-small text-muted">
                                        {{ $doc->format }}
                                        @if ($doc->taille) · {{ $doc->taille }} @endif
                                        · {{ optional($doc->date_publication)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ Storage::url($doc->fichier) }}" target="_blank" class="btn btn-outline">
                                    <span class="material-symbols-outlined" style="font-size:18px;">visibility</span>
                                    {{ $locale === 'ar' ? 'معاينة' : 'Consulter' }}
                                </a>
                                <a href="{{ Storage::url($doc->fichier) }}" download class="btn btn-primary">
                                    <span class="material-symbols-outlined" style="font-size:18px;">download</span>
                                    {{ $locale === 'ar' ? 'تحميل' : 'Télécharger' }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination">{{ $documents->links() }}</div>
            @else
                <div class="empty-state">{{ $locale === 'ar' ? 'لا توجد وثائق مطابقة' : 'Aucun document ne correspond à votre recherche.' }}</div>
            @endif
        </div>
    </div>
</div>
