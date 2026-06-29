<?php

use Livewire\Component;
use Illuminate\Support\Facades\Password;

new class extends Component
{
    public string $email = '';
    public ?string $status = null;

    public function sendResetLink()
    {
        $this->validate(['email' => 'required|email']);

        $status = Password::broker(config('fortify.broker'))->sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = __($status);
        } else {
            $this->addError('email', __($status));
        }
    }
};
?>

<div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Mot de passe oublié</h2>
    <p class="text-sm text-gray-600 mb-6 text-center">Saisissez votre email pour recevoir un lien de réinitialisation.</p>

    @if ($status || session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded border border-green-200">
            {{ $status ?? session('status') }}
        </div>
    @endif

    <form wire:submit="sendResetLink" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Adresse Email</label>
            <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full py-2 px-4 border rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
            Envoyer le lien
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la connexion
        </a>
    </div>
</div>