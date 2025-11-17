<!-- Newsletter -->
<section class="py-20 bg-gradient-to-r from-emerald-500 via-green-600 to-green-700">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-12 shadow-2xl">
            <h2 class="text-4xl font-bold text-white mb-6">
                📬 Restez informé des dernières nouvelles
            </h2>
            <p class="text-xl text-green-50 mb-8">
                Recevez les innovations agricoles et les histoires inspirantes directement dans votre boîte mail.
            </p>

            <form wire:submit="subscribe" class="max-w-xl mx-auto">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                    type="text"
                    id="name"
                    wire:model="name"
                    class="flex-1 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-white focus:outline-none shadow-lg"
                    placeholder="Entrez votre nom complet"
                >
                    <input type="email" wire:model.debounce.300ms="email" placeholder="Votre adresse email"
                        class="flex-1 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-white focus:outline-none shadow-lg">
                    <button type="submit"
                        class="bg-[#1B5E20] text-green-50 px-8 py-4 rounded-xl font-bold hover:bg-earth-500 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        S'abonner
                    </button>
                </div>
                <p class="text-green-100 text-sm mt-4">
                    ✅ Aucune publicité • Désabonnement facile
                </p>
            </form>
        </div>
    </div>
</section>
