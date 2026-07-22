<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Contactez-nous</h2>

    @if ($successMessage)
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r">
            <p class="font-medium">Message envoyé avec succès !</p>
            <p class="text-sm">Nous vous répondrons dans les plus brefs délais.</p>
        </div>
    @endif

    <form wire:submit.prevent="sendMessage" class="space-y-5">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
            <input type="text" id="name" wire:model.blur="name"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('name') border-red-500 @enderror"
                placeholder="Votre nom">
            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse E-mail *</label>
            <input type="email" id="email" wire:model.blur="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('email') border-red-500 @enderror"
                placeholder="nom@exemple.com">
            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
            <input type="text" id="subject" wire:model.blur="subject"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                placeholder="Objet de votre demande">
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
            <textarea id="message" wire:model.blur="message" rows="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('message') border-red-500 @enderror"
                placeholder="Écrivez votre message ici..."></textarea>
            @error('message') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center space-x-2">
            <span wire:loading.remove>Envoyer le message</span>
            <span wire:loading>Envoi en cours...</span>
        </button>
    </form>
</div>
