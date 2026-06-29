<x-layouts.app>
    <div class="max-w-4xl mx-auto my-10 px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Paramètres du compte</h1>
                <p class="text-sm text-gray-500 mt-1">Gérez vos options de sécurité et vos préférences.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 bg-white px-3 py-2 rounded-md shadow-sm border border-gray-300 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour au Dashboard
            </a>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informations personnelles</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Nom complet</span>
                        <span class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Adresse Email</span>
                        <span class="text-base font-medium text-gray-800">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>

            <livewire:profile.two-factor-authentication />

            <div class="text-right mt-4">
                <a href="{{ route('profile.advanced') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 underline inline-flex items-center">
                    Accéder aux paramètres avancés (Zone sécurisée)
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>