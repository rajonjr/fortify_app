<?php

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

new class extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function resetPassword(ResetsUserPasswords $resetter)
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker(config('fortify.broker'))->reset(
            [
                'token' => $this->token, 
                'email' => $this->email, 
                'password' => $this->password, 
                'password_confirmation' => $this->password_confirmation
            ],
            function ($user, $password) use ($resetter) {
                $resetter->reset($user, [
                    'password' => $password, 
                    'password_confirmation' => $this->password_confirmation
                ]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            return redirect()->route('login');
        }

        $this->addError('email', __($status));
    }
};
?>

<div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Choisir un nouveau mot de passe</h2>

    <form wire:submit="resetPassword" class="space-y-4">
        <input type="hidden" wire:model="token">

        <div>
            <label class="block text-sm font-medium text-gray-700">Adresse Email</label>
            <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
            <input type="password" wire:model="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
            <input type="password" wire:model="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
            Réinitialiser le mot de passe
        </button>
    </form>
</div>