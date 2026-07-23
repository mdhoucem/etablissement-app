<div class="container py-section">

    <div class="mb-8" style="border-inline-start: 4px solid var(--color-secondary); padding-inline-start: 20px;">
        <h1 class="h1 mb-2">{{ $locale === 'ar' ? 'المكتبة الوسائطية' : 'Médiathèque' }}</h1>
        <p class="text-muted" style="max-width: 640px;">
            {{ $locale === 'ar' ? 'استرجع أبرز اللحظات من خلال الصور والفيديوهات.' : 'Revivez les moments forts à travers notre sélection de photos et vidéos.' }}
        </p>
    </div>

    <div class="flex flex-wrap gap-4 mb-8" style="justify-content: space-between; align-items: center;">
        <div class="flex flex-wrap gap-2">
            @foreach ([
                '' => $locale === 'ar' ? 'الكل' : 'Tous',
                'photo' => $locale === 'ar' ? 'صور' : 'Photos',
                'video' => $locale === 'ar' ? 'فيديوهات' : 'Vidéos',
            ] as $value => $label)
                <button wire:click="$set('typeFiltre', '{{ $value }}')" type="button"
                    class="btn {{ $typeFiltre === $value ? 'btn-primary' : 'btn-ghost' }}"
                    style="border-radius: var(--radius-full); padding: 10px 24px;">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="field" style="margin: 0; max-width: 320px; width: 100%;">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="{{ $locale === 'ar' ? 'البحث عن حدث...' : 'Rechercher un événement...' }}">
        </div>
    </div>

    <div wire:loading.class="opacity-50">
        @if ($medias->count())
            <div class="grid grid-4">
                @foreach ($medias as $media)
                    <div wire:click="openLightbox({{ $media->id }})" class="card"
                        style="padding:0; overflow:hidden; cursor:pointer; aspect-ratio: 1; position:relative;">
                        @if ($media->type === 'photo')
                            <img src="{{ Storage::url($media->fichier) }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div style="width:100%; height:100%; background:#000; display:flex; align-items:center; justify-content:center; position:relative;">
                                @php
                                    preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=)([a-zA-Z0-9_-]+)/', $media->url_video ?? '', $m);
                                    $ytId = $m[1] ?? null;
                                @endphp
                                @if ($ytId)
                                    <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" alt="" style="width:100%; height:100%; object-fit:cover; opacity:.6;">
                                @endif
                                <div style="position:absolute; width:56px; height:56px; border-radius:50%; background:var(--color-secondary); display:flex; align-items:center; justify-content:center;">
                                    <span class="material-symbols-outlined" style="color:#fff; font-size:28px;">play_arrow</span>
                                </div>
                            </div>
                        @endif

                        <div style="position:absolute; bottom:0; inset-inline:0; background:linear-gradient(to top, rgba(0,38,63,.85), transparent); padding: 16px; color:#fff;">
                            <p style="font-weight:700; font-size:.9rem; margin:0;">
                                {{ Str::limit($locale === 'ar' ? $media->titre_ar : $media->titre_fr, 40) }}
                            </p>
                        </div>

                        @if ($media->featured)
                            <span class="badge badge-featured" style="position:absolute; top:12px; inset-inline-start:12px;">
                                {{ $locale === 'ar' ? 'مميز' : 'À la une' }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="pagination">{{ $medias->links() }}</div>
        @else
            <div class="empty-state">{{ $locale === 'ar' ? 'لا توجد وسائط مطابقة' : 'Aucun média ne correspond à votre recherche.' }}</div>
        @endif
    </div>

    {{-- Lightbox --}}
    @if ($this->activeMedia)
        <div style="position:fixed; inset:0; background:rgba(0,0,0,.95); z-index:100; display:flex; flex-direction:column;"
             wire:key="lightbox-{{ $this->activeMedia->id }}">
            <div class="flex justify-between items-center" style="padding: 20px;">
                <span style="color:#fff; font-size:.9rem;">
                    {{ $locale === 'ar' ? $this->activeMedia->titre_ar : $this->activeMedia->titre_fr }}
                </span>
                <button wire:click="closeLightbox" type="button" style="background:none; border:none; color:#fff;">
                    <span class="material-symbols-outlined" style="font-size:32px;">close</span>
                </button>
            </div>

            <div class="flex items-center justify-between" style="flex:1; padding: 0 48px;">
                <button wire:click="prevMedia" type="button" style="background:none; border:none; color:rgba(255,255,255,.5);">
                    <span class="material-symbols-outlined" style="font-size:56px;">chevron_left</span>
                </button>

                <div style="max-width:900px; max-height:70vh; width:100%; display:flex; align-items:center; justify-content:center;">
                    @if ($this->activeMedia->type === 'photo')
                        <img src="{{ Storage::url($this->activeMedia->fichier) }}" alt="" style="max-width:100%; max-height:70vh; object-fit:contain;">
                    @else
                        @php
                            preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=)([a-zA-Z0-9_-]+)/', $this->activeMedia->url_video ?? '', $m2);
                            $ytId2 = $m2[1] ?? null;
                        @endphp
                        @if ($ytId2)
                            <iframe width="800" height="450" src="https://www.youtube.com/embed/{{ $ytId2 }}" style="max-width:100%; border:none;" allowfullscreen></iframe>
                        @endif
                    @endif
                </div>

                <button wire:click="nextMedia" type="button" style="background:none; border:none; color:rgba(255,255,255,.5);">
                    <span class="material-symbols-outlined" style="font-size:56px;">chevron_right</span>
                </button>
            </div>

            @if ($this->activeMedia->description_fr || $this->activeMedia->description_ar)
                <p style="color:rgba(255,255,255,.7); text-align:center; padding: 20px; max-width:700px; margin:0 auto;">
                    {{ $locale === 'ar' ? $this->activeMedia->description_ar : $this->activeMedia->description_fr }}
                </p>
            @endif
        </div>
    @endif
</div>
