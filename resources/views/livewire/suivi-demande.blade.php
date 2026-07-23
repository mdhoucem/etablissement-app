<div class="container py-section" style="max-width: 550px;">
    <h1 class="h1 mb-6">{{ $locale === 'ar' ? 'تتبع طلبي' : 'Suivre ma demande' }}</h1>

    <form wire:submit="rechercher" class="card">
        <div class="field">
            <label>{{ $locale === 'ar' ? 'رقم المتابعة' : 'Numéro de suivi' }}</label>
            <input type="text" wire:model="numero_suivi" placeholder="DEM-2026-0001">
            @error('numero_suivi') <p class="field-error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
            <label>{{ $locale === 'ar' ? 'رقم بطاقة التعريف' : 'N° CIN' }}</label>
            <input type="text" wire:model="cin">
            @error('cin') <p class="field-error">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn btn-primary w-full">{{ $locale === 'ar' ? 'بحث' : 'Rechercher' }}</button>
    </form>

    @if ($recherche_effectuee)
        <div class="mt-6">
            @if ($demande)
                <div class="card">
                    <div class="flex justify-between items-center mb-4">
                        <span style="font-family:monospace; font-weight:700;">{{ $demande->numero_suivi }}</span>
                        <span class="badge {{ match($demande->statut) {
                            'en_attente' => 'badge-warning',
                            'en_cours' => 'badge-info',
                            'traitee' => 'badge-success',
                            'rejetee' => 'badge-error',
                            default => 'badge-info',
                        } }}">
                            @switch($demande->statut)
                                @case('en_attente') {{ $locale === 'ar' ? 'قيد الانتظار' : 'En attente' }} @break
                                @case('en_cours') {{ $locale === 'ar' ? 'قيد المعالجة' : 'En cours de traitement' }} @break
                                @case('traitee') {{ $locale === 'ar' ? 'تمت المعالجة' : 'Traitée' }} @break
                                @case('rejetee') {{ $locale === 'ar' ? 'مرفوضة' : 'Rejetée' }} @break
                            @endswitch
                        </span>
                    </div>
                    <p class="text-small text-muted mb-2">
                        {{ $locale === 'ar' ? 'الخدمة:' : 'Service :' }}
                        <span style="color:var(--color-on-surface);">{{ $locale === 'ar' ? $demande->service?->titre_ar : $demande->service?->titre_fr }}</span>
                    </p>
                    <p class="text-small text-muted">
                        {{ $locale === 'ar' ? 'تاريخ الإرسال:' : 'Date de soumission :' }}
                        <span style="color:var(--color-on-surface);">{{ $demande->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                </div>
            @else
                <div class="card text-center" style="border-color:var(--color-error); background:#fdecea; color:var(--color-error);">
                    {{ $locale === 'ar' ? 'لم يتم العثور على أي طلب بهذه المعلومات.' : 'Aucune demande trouvée avec ces informations.' }}
                </div>
            @endif
        </div>
    @endif
</div>
