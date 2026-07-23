<div class="container py-section" style="max-width: 700px;">
    <h1 class="h1 mb-6">{{ $locale === 'ar' ? 'طلب مساعدة' : 'Demande d\'assistance' }}</h1>

    @if ($numeroSuiviGenere)
        <div class="card text-center" style="border-color: var(--color-success); background:#f0fbf3;">
            <p style="color: var(--color-success); font-weight:700; font-size:1.2rem;" class="mb-2">
                {{ $locale === 'ar' ? 'تم تسجيل طلبك بنجاح!' : 'Votre demande a été enregistrée avec succès !' }}
            </p>
            <p class="text-muted mb-2">{{ $locale === 'ar' ? 'رقم المتابعة الخاص بك:' : 'Votre numéro de suivi :' }}</p>
            <p style="font-size:1.75rem; font-weight:700; color:var(--color-success); font-family:monospace;" class="mb-4">{{ $numeroSuiviGenere }}</p>
            <p class="text-small text-muted mb-6">
                {{ $locale === 'ar' ? 'يرجى الاحتفاظ بهذا الرقم لمتابعة طلبك.' : 'Conservez précieusement ce numéro pour suivre votre dossier.' }}
            </p>
            <a href="{{ route('suivi-demande') }}" wire:navigate class="btn btn-primary">
                {{ $locale === 'ar' ? 'تتبع طلبي' : 'Suivre ma demande' }}
            </a>
        </div>
    @else
        <form wire:submit="submit" class="card">
            <div class="field">
                <label>{{ $locale === 'ar' ? 'الخدمة المعنية' : 'Service concerné' }}</label>
                <select wire:model="service_id">
                    <option value="">{{ $locale === 'ar' ? '-- اختر خدمة --' : '-- Choisir un service --' }}</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $locale === 'ar' ? $service->titre_ar : $service->titre_fr }}</option>
                    @endforeach
                </select>
                @error('service_id') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="field-row">
                <div class="field">
                    <label>{{ $locale === 'ar' ? 'الاسم الكامل' : 'Nom complet' }} *</label>
                    <input type="text" wire:model="nom_complet">
                    @error('nom_complet') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label>{{ $locale === 'ar' ? 'رقم بطاقة التعريف' : 'N° CIN' }} *</label>
                    <input type="text" wire:model="cin">
                    @error('cin') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label>{{ $locale === 'ar' ? 'الهاتف' : 'Téléphone' }} *</label>
                    <input type="tel" wire:model="telephone">
                    @error('telephone') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label>{{ $locale === 'ar' ? 'البريد الإلكتروني' : 'E-mail' }}</label>
                    <input type="email" wire:model="email">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="field">
                <label>{{ $locale === 'ar' ? 'وصف الحاجة' : 'Description du besoin' }} *</label>
                <textarea wire:model="description" rows="4"></textarea>
                @error('description') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label>{{ $locale === 'ar' ? 'الوثائق الثبوتية (PDF, JPG, PNG - 5 م.و)' : 'Pièces justificatives (PDF, JPG, PNG - 5 Mo max)' }}</label>
                <input type="file" wire:model="pieces_justificatives" multiple>
                <div wire:loading wire:target="pieces_justificatives" class="text-small mt-2" style="color:var(--color-primary);">
                    {{ $locale === 'ar' ? 'جارٍ الرفع...' : 'Téléversement en cours...' }}
                </div>
                @error('pieces_justificatives.*') <p class="field-error">{{ $message }}</p> @enderror
                @if ($pieces_justificatives)
                    <ul class="text-small text-muted mt-2">
                        @foreach ($pieces_justificatives as $file)
                            <li>{{ $file->getClientOriginalName() }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="btn btn-primary w-full mt-4">
                <span wire:loading.remove wire:target="submit">{{ $locale === 'ar' ? 'إرسال الطلب' : 'Envoyer la demande' }}</span>
                <span wire:loading wire:target="submit">{{ $locale === 'ar' ? 'جارٍ الإرسال...' : 'Envoi en cours...' }}</span>
            </button>
        </form>
    @endif
</div>
