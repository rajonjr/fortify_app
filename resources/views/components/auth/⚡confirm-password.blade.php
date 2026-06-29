<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

new class extends Component
{
    public string $password = '';

    public function confirmPassword()
    {
        $this->validate([
            'password' => 'required',
        ]);

        // Vérification du mot de passe avec le guard par défaut
        if (! Auth::guard('web')->validate([
            'email' => auth()->user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => [__('auth.password')],
            ]);
        }

        // On enregistre le timestamp de confirmation en session
        session()->put('auth.password_confirmed_at', time());

        // Redirection vers la page initialement demandée
        return redirect()->intended('/dashboard');
    }
};
?>

<div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Zone Sécurisée</h2>
    
    <p class="text-sm text-gray-600 mb-6 text-center">
        Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
    </p>

    <form wire:submit="confirmPassword" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
            <input type="password" wire:model="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500" required autocomplete="current-password" autofocus>
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                Confirmer le mot de passe
            </button>
        </div>
    </form>
</div>