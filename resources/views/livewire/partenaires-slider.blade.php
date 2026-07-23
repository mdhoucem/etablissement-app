<div class="py-section" style="overflow:hidden;">
    <h2 class="h2 text-center mb-8">{{ app()->getLocale() === 'ar' ? 'شركاؤنا' : 'Nos partenaires' }}</h2>
    @if ($partenaires->count())
        <div style="overflow-x:auto;">
            <div class="partners-track flex items-center gap-6" style="padding:0 16px;">
                @foreach ($partenaires as $partenaire)
                    <a href="{{ $partenaire->site_web ?: '#' }}" target="_blank" rel="noopener"
                       style="flex-shrink:0; filter:grayscale(1); opacity:.7; transition:all .2s;"
                       onmouseover="this.style.filter='grayscale(0)';this.style.opacity=1"
                       onmouseout="this.style.filter='grayscale(1)';this.style.opacity=.7"
                       title="{{ $partenaire->nom }}">
                        <img src="{{ Storage::url($partenaire->logo) }}" alt="{{ $partenaire->nom }}" style="height:56px; object-fit:contain;">
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center text-muted">{{ app()->getLocale() === 'ar' ? 'لا يوجد شركاء حاليا' : 'Aucun partenaire pour le moment.' }}</p>
    @endif
</div>
