<?php

use Livewire\Component;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;

new class extends Component {
    public bool $showingQrCode = false;
    public bool $showingRecoveryCodes = false; 
    public string $code = ''; 

    public function showRecoveryCodes()
    {
        // 1. Vérifier si la confirmation du mot de passe a expiré
        $confirmedAt = session()->get('auth.password_confirmed_at', 0);
        $timeout = config('auth.password_timeout', 10800);

        if ((time() - $confirmedAt) > $timeout) {
            // On stocke dans la session l'URL actuelle pour y revenir après confirmation
            session()->put('url.intended', url()->current());
            
            return redirect()->route('password.confirm');
        }

        // Afficher les codes
        $this->showingRecoveryCodes = true;
    }

    public function enable(EnableTwoFactorAuthentication $enable)
    {
        $enable(auth()->user());
        $this->showingQrCode = true;
        
        // Vérification du mot de passe
        $this->showRecoveryCodes();
    }

    public function confirm(ConfirmTwoFactorAuthentication $confirm)
    {
        $this->validate(['code' => 'required']);
        
        try {
            $confirm(auth()->user(), $this->code);
            $this->showingQrCode = false;
            $this->code = '';
        } catch (\Exception $e) {
            $this->addError('code', 'Le code de confirmation est invalide.');
        }
    }

    public function disable(DisableTwoFactorAuthentication $disable)
    {
        $disable(auth()->user());
        $this->showingQrCode = false;
        $this->showingRecoveryCodes = false;
    }
}; ?>

<div class="p-6 bg-white rounded-lg shadow-md border mt-6">
    <h3 class="text-lg font-bold text-gray-900 mb-2">Authentification à deux facteurs (2FA)</h3>

    @if (! auth()->user()->two_factor_secret)
        <p class="text-sm text-gray-600 mb-4">Augmentez la sécurité de votre compte en activant le 2FA.</p>
        <button wire:click="enable" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm font-semibold hover:bg-indigo-700">
            Activer le 2FA
        </button>
    @else
        @if (auth()->user()->two_factor_confirmed_at)
            <p class="text-sm text-green-600 font-semibold mb-4">✓ Le 2FA est actuellement actif et configuré.</p>
        @else
            <p class="text-sm text-yellow-600 font-semibold mb-4">⚠️ Terminez l'activation en scannant le QR Code et en insérant le code.</p>
        @endif

        <div class="flex space-x-3 mb-4">
            @if (!$showingRecoveryCodes)
                <button wire:click="showRecoveryCodes" class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm font-semibold hover:bg-gray-300">
                    Afficher les codes de récupération
                </button>
            @endif

            <button wire:click="disable" class="px-4 py-2 bg-red-600 text-white rounded text-sm font-semibold hover:bg-red-700">
                Désactiver le 2FA
            </button>
        </div>

        @if ($showingQrCode)
            <div class="mb-4 p-4 bg-gray-50 inline-block rounded">
                <p class="text-xs text-gray-500 mb-2">Scannez ce QR Code avec votre application :</p>
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                
                @if (! auth()->user()->two_factor_confirmed_at)
                    <div class="mt-4">
                        <input type="text" wire:model="code" placeholder="Code de l'app" class="border p-2 rounded text-sm w-32">
                        <button wire:click="confirm" class="ml-2 px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">Confirmer</button>
                        @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
        @endif

        @if ($showingRecoveryCodes)
            <div class="mb-4 p-4 bg-gray-900 text-green-400 rounded font-mono text-xs">
                <p class="text-white font-bold mb-2">Codes de récupération (Conservez-les précieusement) :</p>
                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <div>{{ $code }}</div>
                @endforeach
            </div>
        @endif
    @endif
</div>