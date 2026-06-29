<?php

use Livewire\Component;
use Laravel\Fortify\Http\Requests\TwoFactorLoginRequest;

new class extends Component
{
    public string $code = '';
    public string $recovery_code = '';
    public bool $useRecovery = false;

    public function loginChallenge()
    {
        $request = app(TwoFactorLoginRequest::class);

        if ($this->useRecovery) {
            $request->merge(['recovery_code' => $this->recovery_code]);
        } else {
            $request->merge(['code' => $this->code]);
        }

        $this->validate([
            'code' => $this->useRecovery ? 'nullable' : 'required',
            'recovery_code' => $this->useRecovery ? 'required' : 'nullable',
        ]);

        if ($request->hasChallengedUser()) {
            if ($request->validRecoveryCode()) {
                $request->loginWithRecoveryCode($request->validRecoveryCode());
            } elseif ($request->hasValidCode()) {
                $request->login();
            } else {
                $this->addError($this->useRecovery ? 'recovery_code' : 'code', 'Le code fourni est incorrect.');
                return;
            }
            
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect()->route('login');
    }
};
?>

<div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Double Authentification</h2>

    <form wire:submit="loginChallenge" class="space-y-4">
        @if (! $useRecovery)
            <div>
                <label class="block text-sm font-medium text-gray-700">Code d'authentification</label>
                <input type="text" wire:model="code" placeholder="000000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border text-center tracking-widest text-lg font-bold">
                @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="button" wire:click="$set('useRecovery', true)" class="text-xs text-indigo-600 hover:underline">Utiliser un code de récupération</button>
        @else
            <div>
                <label class="block text-sm font-medium text-gray-700">Code de récupération</label>
                <input type="text" wire:model="recovery_code" placeholder="abcdef-12345" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border font-mono">
                @error('recovery_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="button" wire:click="$set('useRecovery', false)" class="text-xs text-indigo-600 hover:underline">Utiliser l'application mobile</button>
        @endif

        <button type="submit" class="w-full py-2 px-4 border rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
            Confirmer et se connecter
        </button>
    </form>
</div>