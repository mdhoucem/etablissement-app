<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Bouton Retour -->
    <div class="mb-6">
        <a href="/actualites" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
            ← Retour aux actualités
        </a>
    </div>

    <!-- Article principal -->
    <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
        @if(isset($actualite->image))
            <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->title }}" class="w-full h-80 sm:h-96 object-cover">
        @else
            <div class="w-full h-64 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl">
                Établissement
            </div>
        @endif

        <div class="p-6 sm:p-10">
            <div class="flex items-center space-x-4 mb-4">
                <span class="text-xs font-semibold px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full uppercase tracking-wider">
                    {{ $actualite->category ?? 'Général' }}
                </span>
                <span class="text-xs text-gray-500">
                    Publié le {{ $actualite->created_at->format('d/m/Y') }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-6">
                {{ $actualite->title }}
            </h1>

            <div class="prose max-w-none text-gray-700 leading-relaxed text-lg space-y-4">
                {!! nl2br(e($actualite->content ?? $actualite->description ?? '')) !!}
            </div>
        </div>
    </article>

    <!-- Articles suggérés -->
    @if($recentes->count() > 0)
        <div class="border-t border-gray-200 pt-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">À lire également</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentes as $item)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                        <div class="p-4">
                            <span class="text-xs text-indigo-600 font-semibold block mb-1">
                                {{ $item->created_at->format('d/m/Y') }}
                            </span>
                            <h3 class="font-bold text-gray-900 line-clamp-2 mb-2">
                                {{ $item->title }}
                            </h3>
                            <a href="/actualites/{{ $item->id }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                                Lire l'article →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
