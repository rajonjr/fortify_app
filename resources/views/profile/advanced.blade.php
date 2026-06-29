<x-layouts.app>
    <div class="max-w-4xl mx-auto my-10 px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded uppercase tracking-wider">Haute Sécurité</span>
                    <h1 class="text-3xl font-extrabold text-gray-900">Paramètres Avancés</h1>
                </div>
                <p class="text-sm text-gray-500 mt-1">Ces options nécessitent une confirmation de mot de passe active.</p>
            </div>
            <a href="{{ route('profile') }}" class="inline-flex items-center text-sm font-medium text-gray-700 bg-white px-3 py-2 rounded-md shadow-sm border border-gray-300 hover:bg-gray-50 transition">
                Annuler / Retour
            </a>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Clés API & Intégrations</h3>
                        <p class="text-sm text-gray-600 mt-1">Générez des jetons d'accès pour connecter vos outils externes à notre API.</p>
                    </div>
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded text-sm shadow transition">
                        Générer un jeton
                    </button>
                </div>
                
                <div class="mt-4 p-3 bg-gray-50 rounded border border-dashed border-gray-300 text-center text-sm text-gray-500">
                    Aucun jeton actif pour le moment.
                </div>
            </div>

            <div class="bg-red-50 p-6 rounded-lg shadow-md border border-red-200">
                <h3 class="text-lg font-bold text-red-900">Zone de danger</h3>
                <p class="text-sm text-red-700 mt-1 mb-4">Une fois votre compte supprimé, toutes vos données seront définitivement perdues. Cette action est irréversible.</p>
                
                <div class="flex justify-between items-center">
                    <span class="text-xs text-red-600 italic">Validé par confirmation de mot de passe de moins de 3 heures.</span>
                    <button onclick="confirm('Êtes-vous absolument sûr de vouloir supprimer définitivement votre compte ? Cette action est irréversible.')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded text-sm shadow transition">
                        Supprimer le compte définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>