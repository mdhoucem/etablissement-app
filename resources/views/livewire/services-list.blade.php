<div class="max-w-7xl mx-auto px-4 py-10" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Barre de filtres --}}
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="flex-1">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="{{ $locale === 'ar' ? 'ابحث عن خدمة...' : 'Rechercher un service...' }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-start"
            >
        </div>

        <div class="w-full md:w-72">
            <select
                wire:model.live="groupeServiceId"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="">
                    {{ $locale === 'ar' ? 'كل الفئات' : 'Tous les groupes' }}
                </option>
                @foreach ($groupes as $groupe)
                    <option value="{{ $groupe->id }}">
                        {{ $locale === 'ar' ? $groupe->titre_ar : $groupe->titre_fr }}
                    </option>
                @endforeach
            </select>
        </div>

        @if ($search || $groupeServiceId)
            <button
                wire:click="resetFilters"
                type="button"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm font-medium whitespace-nowrap"
            >
                {{ $locale === 'ar' ? 'إعادة تعيين' : 'Réinitialiser' }}
            </button>
        @endif
    </div>

    {{-- Grille des services --}}
    <div wire:loading.class="opacity-50" class="transition-opacity">
        @if ($services->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)

                        href="{{ route('services.detail', $service->slug) }}"
                        wire:navigate
                        class="group block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all p-6 text-start"
                    >
                        @if ($service->featured)
                            <span class="inline-block mb-3 px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">
                                {{ $locale === 'ar' ? 'مميز' : 'À la une' }}
                            </span>
                        @endif

                        <p class="text-xs font-medium text-blue-600 mb-1">
                            {{ $locale === 'ar' ? $service->groupeService?->titre_ar : $service->groupeService?->titre_fr }}
                        </p>

                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                            {{ $locale === 'ar' ? $service->titre_ar : $service->titre_fr }}
                        </h3>

                        @if ($service->type_service)
                            <p class="text-sm text-gray-500 mt-2">{{ $service->type_service }}</p>
                        @endif

                        <span class="inline-block mt-4 text-sm font-medium text-blue-600">
                            {{ $locale === 'ar' ? 'اقرأ المزيد ←' : 'Voir le détail →' }}
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $services->links() }}
            </div>
        @else
            <div class="text-center py-16 text-gray-400">
                {{ $locale === 'ar' ? 'لا توجد خدمات مطابقة' : 'Aucun service ne correspond à votre recherche.' }}
            </div>
        @endif
    </div>
</div>
