<div class="container py-section">

    <div class="card mb-8" style="background: var(--color-primary); color: #fff; border: none;">
        <h1 class="h1 mb-2" style="color: #fff;">{{ $locale === 'ar' ? 'اتصل بنا' : 'Contactez-nous' }}</h1>
        <p style="opacity: .9; max-width: 640px;">
            {{ $locale === 'ar' ? 'نحن في استماعكم للرد على استفساراتكم ومرافقتكم في إجراءاتكم.' : 'Nous sommes à votre écoute pour répondre à vos questions et vous accompagner dans vos démarches.' }}
        </p>
    </div>

    <div class="grid" style="grid-template-columns: 320px 1fr; gap: var(--gutter); align-items: start;">

        {{-- Infos --}}
        <div class="flex flex-col gap-4">
            <div class="card">
                <h3 class="h3 mb-4" style="font-size: 1.1rem;">{{ $locale === 'ar' ? 'معلومات' : 'Informations' }}</h3>
                <div class="footer-contact-item" style="color: var(--color-on-surface-variant);">
                    <span class="material-symbols-outlined" style="color: var(--color-secondary);">call</span>
                    <span>{{ $locale === 'ar' ? 'الرقم الأخضر: 80 100 000' : 'Numéro Vert : 80 100 000' }}</span>
                </div>
                <div class="footer-contact-item" style="color: var(--color-on-surface-variant);">
                    <span class="material-symbols-outlined" style="color: var(--color-secondary);">mail</span>
                    <span>contact@etablissement.gov.tn</span>
                </div>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="card">
            @if ($envoye)
                <div class="text-center" style="padding: 32px 0;">
                    <div style="width:80px; height:80px; border-radius:50%; background:var(--color-tertiary-fixed, #d4f4de); display:flex; align-items:center; justify-content:center; margin: 0 auto 24px;">
                        <span class="material-symbols-outlined" style="font-size:40px; color: var(--color-success);">check_circle</span>
                    </div>
                    <h2 class="h2 mb-4">{{ $locale === 'ar' ? 'تم إرسال رسالتكم!' : 'Message envoyé !' }}</h2>
                    <p class="text-muted" style="max-width: 400px; margin: 0 auto;">
                        {{ $locale === 'ar' ? 'شكراً لتواصلكم معنا. سيقوم فريقنا بالرد عليكم في أقرب الآجال.' : 'Merci de nous avoir contactés. Notre équipe reviendra vers vous dans les plus brefs délais.' }}
                    </p>
                </div>
            @else
                <h2 class="h2 mb-6">{{ $locale === 'ar' ? 'استمارة الاتصال' : 'Formulaire de contact' }}</h2>

                <form wire:submit="submit">
                    <div class="field-row">
                        <div class="field">
                            <label>{{ $locale === 'ar' ? 'الاسم الكامل' : 'Nom complet' }} *</label>
                            <input type="text" wire:model="nom">
                            @error('nom') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="field">
                            <label>{{ $locale === 'ar' ? 'البريد الإلكتروني' : 'Adresse Email' }} *</label>
                            <input type="email" wire:model="email">
                            @error('email') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label>{{ $locale === 'ar' ? 'الهاتف' : 'Téléphone' }}</label>
                        <input type="tel" wire:model="telephone">
                        @error('telephone') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label>{{ $locale === 'ar' ? 'موضوع الطلب' : 'Objet de votre demande' }} *</label>
                        <input type="text" wire:model="sujet" placeholder="{{ $locale === 'ar' ? 'مثال: طلب معلومات' : 'Ex: Demande d\'information' }}">
                        @error('sujet') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label>{{ $locale === 'ar' ? 'رسالتكم' : 'Votre message' }} *</label>
                        <textarea wire:model="message" rows="6"></textarea>
                        @error('message') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2 mb-6">
                        <input type="checkbox" wire:model="consent" id="consent" style="width:auto;">
                        <label for="consent" class="text-small text-muted" style="margin:0; font-weight:400;">
                            {{ $locale === 'ar' ? 'أوافق على معالجة بياناتي الشخصية وفقاً لسياسة الخصوصية.' : 'J\'accepte le traitement de mes données personnelles conformément à la politique de confidentialité.' }}
                        </label>
                    </div>
                    @error('consent') <p class="field-error mb-4">{{ $message }}</p> @enderror

                    <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="submit">{{ $locale === 'ar' ? 'إرسال الرسالة' : 'Envoyer le message' }}</span>
                        <span wire:loading wire:target="submit">{{ $locale === 'ar' ? 'جارٍ الإرسال...' : 'Envoi en cours...' }}</span>
                        <span class="material-symbols-outlined" style="font-size:18px;">send</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
