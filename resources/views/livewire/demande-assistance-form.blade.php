<div class="max-w-2xl mx-auto px-4 py-10" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-900 mb-6 text-start">
        {{ $locale === 'ar' ? 'طلب مساعدة' : 'Demande d\'assistance' }}
    </h1>

    @if ($numeroSuiviGenere)
        <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
            <p class="text-green-800 font-semibold text-lg mb-1">
                {{ $locale === 'ar' ? 'تم تسجيل طلبك بنجاح!' : 'Votre demande a été enregistrée avec succès !' }}
            </p>
            <p class="text-gray-600 mb-3">
                {{ $locale === 'ar' ? 'رقم المتابعة الخاص بك:' : 'Votre numéro de suivi :' }}
            </p>
            <p class="text-2xl font-mono font-bold text-green-700 mb-4">{{ $numeroSuiviGenere }}</p>
            <p class="text-sm text-gray-500">
                {{ $locale === 'ar' ? 'يرجى الاحتفاظ بهذا الرقم لمتابعة طلبك.' : 'Conservez précieusement ce numéro pour suivre votre dossier.' }}
            </p>
            <a href="{{ route('suivi-demande') }}" wire:navigate
               class="inline-block mt-5 px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
                {{ $locale === 'ar' ? 'تتبع طلبي' : 'Suivre ma demande' }}
            </a>
        </div>
    @else
        <form wire:submit="submit" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-5 text-start">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $locale === 'ar' ? 'الخدمة المعنية' : 'Service concerné' }}
                </label>
                <select wire:model="service_id" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">{{ $locale === 'ar' ? '-- اختر خدمة --' : '-- Choisir un service --' }}</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">
                            {{ $locale === 'ar' ? $service->titre_ar : $service->titre_fr }}
                        </option>
                    @endforeach
                </select>
                @error('service_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $locale === 'ar' ? 'الاسم الكامل' : 'Nom complet' }} *
                    </label>
                    <input type="text" wire:model="nom_complet" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('nom_complet') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $locale === 'ar' ? 'رقم بطاقة التعريف' : 'N° CIN' }} *
                    </label>
                    <input type="text" wire:model="cin" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('cin') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $locale === 'ar' ? 'الهاتف' : 'Téléphone' }} *
                    </label>
                    <input type="tel" wire:model="telephone" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('telephone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $locale === 'ar' ? 'البريد الإلكتروني' : 'E-mail' }}
                    </label>
                    <input type="email" wire:model="email" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $locale === 'ar' ? 'وصف الحاجة' : 'Description du besoin' }} *
                </label>
                <textarea wire:model="description" rows="4" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $locale === 'ar' ? 'الوثائق الثبوتية (PDF, JPG, PNG - 5 م.و كحد أقصى)' : 'Pièces justificatives (PDF, JPG, PNG - 5 Mo max)' }}
                </label>
                <input type="file" wire:model="pieces_justificatives" multiple class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                <div wire:loading wire:target="pieces_justificatives" class="text-sm text-blue-600 mt-1">
                    {{ $locale === 'ar' ? 'جارٍ الرفع...' : 'Téléversement en cours...' }}
                </div>
                @error('pieces_justificatives.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                @if ($pieces_justificatives)
                    <ul class="mt-2 text-sm text-gray-500 list-disc list-inside">
                        @foreach ($pieces_justificatives as $file)
                            <li>{{ $file->getClientOriginalName() }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
                class="w-full py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 disabled:opacity-50 transition-colors"
            >
                <span wire:loading.remove wire:target="submit">
                    {{ $locale === 'ar' ? 'إرسال الطلب' : 'Envoyer la demande' }}
                </span>
                <span wire:loading wire:target="submit">
                    {{ $locale === 'ar' ? 'جارٍ الإرسال...' : 'Envoi en cours...' }}
                </span>
            </button>
        </form>
    @endif
</div>
