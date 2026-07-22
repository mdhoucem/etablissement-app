<div class="max-w-4xl mx-auto px-4 py-10" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    <a href="{{ route('services.index') }}" wire:navigate
       class="inline-flex items-center text-sm text-blue-600 hover:underline mb-6">
        {{ $locale === 'ar' ? '→ العودة إلى الخدمات' : '← Retour aux services' }}
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-start">

        <p class="text-sm font-medium text-blue-600 mb-2">
            {{ $locale === 'ar' ? $service->groupeService?->titre_ar : $service->groupeService?->titre_fr }}
        </p>

        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
            {{ $locale === 'ar' ? $service->titre_ar : $service->titre_fr }}
        </h1>

        @if ($service->type_service)
            <span class="inline-block mb-6 px-3 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-700">
                {{ $service->type_service }}
            </span>
        @endif

        <div class="prose max-w-none mb-8">
            {!! $locale === 'ar' ? $service->description_ar : $service->description_fr !!}
        </div>

        @if ($service->documents_requis_fr || $service->documents_requis_ar)
            <div class="border-t border-gray-100 pt-6 mt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">
                    {{ $locale === 'ar' ? 'الوثائق المطلوبة' : 'Documents requis' }}
                </h2>
                <div class="prose max-w-none">
                    {!! $locale === 'ar' ? $service->documents_requis_ar : $service->documents_requis_fr !!}
                </div>
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ url('/demande-assistance/' . $service->id) }}"
               class="inline-block px-6 py-3 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition-colors">
                {{ $locale === 'ar' ? 'تقديم طلب مساعدة' : 'Faire une demande d\'assistance' }}
            </a>
        </div>
    </div>
</div>
