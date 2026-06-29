<?php

use Livewire\Component;

new class extends Component
{
    public ?string $status = null;

    public function sendVerificationEmail()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        
        auth()->user()->sendEmailVerificationNotification();

        $this->status = 'verification-link-sent';
    }
};
?>

<div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Vérifiez votre adresse email</h2>
    
    <p class="text-sm text-gray-600 mb-6 text-center">
        Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'email, nous vous en enverrons un autre avec plaisir.
    </p>

    @if ($status === 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded border border-green-200">
            Un nouveau lien de vérification a été envoyé à l'adresse email fournie lors de votre inscription.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form wire:submit="sendVerificationEmail">
            <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                Renvoyer l'email de vérification
            </button>
        </form>

        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-900 underline transition duration-150">
                Déconnexion
            </button>
        </form>
    </div>
</div>