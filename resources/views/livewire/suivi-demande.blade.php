<div class="max-w-xl mx-auto px-4 py-10" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-900 mb-6 text-start">
        {{ $locale === 'ar' ? 'تتبع طلبي' : 'Suivre ma demande' }}
    </h1>

    <form wire:submit="rechercher" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4 text-start">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ $locale === 'ar' ? 'رقم المتابعة' : 'Numéro de suivi' }}
            </label>
            <input type="text" wire:model="numero_suivi" placeholder="DEM-2026-0001"
                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            @error('numero_suivi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ $locale === 'ar' ? 'رقم بطاقة التعريف' : 'N° CIN' }}
            </label>
            <input type="text" wire:model="cin"
                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            @error('cin') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors">
            {{ $locale === 'ar' ? 'بحث' : 'Rechercher' }}
        </button>
    </form>

    @if ($recherche_effectuee)
        <div class="mt-6">
            @if ($demande)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-start">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-mono font-bold text-gray-900">{{ $demande->numero_suivi }}</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @class([
                                'bg-amber-100 text-amber-700' => $demande->statut === 'en_attente',
                                'bg-blue-100 text-blue-700' => $demande->statut === 'en_cours',
                                'bg-green-100 text-green-700' => $demande->statut === 'traitee',
                                'bg-red-100 text-red-700' => $demande->statut === 'rejetee',
                            ])">
                            @switch($demande->statut)
                                @case('en_attente') {{ $locale === 'ar' ? 'قيد الانتظار' : 'En attente' }} @break
                                @case('en_cours') {{ $locale === 'ar' ? 'قيد المعالجة' : 'En cours de traitement' }} @break
                                @case('traitee') {{ $locale === 'ar' ? 'تمت المعالجة' : 'Traitée' }} @break
                                @case('rejetee') {{ $locale === 'ar' ? 'مرفوضة' : 'Rejetée' }} @break
                            @endswitch
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 mb-1">
                        {{ $locale === 'ar' ? 'الخدمة:' : 'Service :' }}
                        <span class="text-gray-800">
                            {{ $locale === 'ar' ? $demande->service?->titre_ar : $demande->service?->titre_fr }}
                        </span>
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $locale === 'ar' ? 'تاريخ الإرسال:' : 'Date de soumission :' }}
                        <span class="text-gray-800">{{ $demande->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                </div>
            @else
                <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-center text-red-700">
                    {{ $locale === 'ar' ? 'لم يتم العثور على أي طلب بهذه المعلومات.' : 'Aucune demande trouvée avec ces informations.' }}
                </div>
            @endif
        </div>
    @endif
</div>
