<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Actualités & Événements</h1>
            <p class="text-gray-600 mt-1">Restez informé des dernières nouvelles de l'établissement.</p>
        </div>

        <!-- Barre de recherche en temps réel -->
        <div class="w-full md:w-80">
            <input type="text" wire:model.live.debounce.300ms="search"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                placeholder="Rechercher une actualité...">
        </div>
    </div>

    <!-- Grille des cartes -->
    @if($actualites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($actualites as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200 flex flex-col">
                    @if(isset($item->image))
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-48 w-full object-cover">
                    @else
                        <div class="h-48 w-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                            Établissement
                        </div>
                    @endif

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider block mb-2">
                                {{ $item->created_at->format('d/m/Y') }}
                            </span>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                {{ $item->title }}
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($item->content ?? $item->description ?? ''), 120) }}
                            </p>
                        </div>

                        <a href="{{ route('actualites.show', $item->id ?? $item->slug) }}"
                           class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                            Lire la suite →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Livewire -->
        <div class="mt-8">
            {{ $actualites->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500 text-lg">Aucune actualité ne correspond à votre recherche.</p>
        </div>
    @endif
</div>
