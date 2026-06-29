<x-layouts.app>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 font-semibold transition">
                    Déconnexion
                </button>
            </form>
        </div>

        <p class="text-gray-600">Bienvenue, {{ auth()->user()->name }} ! Vous êtes connecté.</p>
    </div>
</x-layouts.app>