<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit.prevent="login">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" wire:model.defer="form.email" value="{{ old('email') }}"
                required autofocus
                class="mt-1 w-full rounded-md bg-white appearance-none focus:bg-white border-gray-300 focus:border-neutral-400 focus:ring-neutral-600 sm:text-sm py-1 px-3">
            @error('form.email')
                <span class="text-sm text-brand">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" wire:model.defer="form.password" required
                class="mt-1 w-full rounded-md border-gray-300 focus:border-neutral-400 focus:ring-neutral-600 sm:text-sm">
            @error('form.password')
                <span class="text-sm text-brand">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button>
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
    </form>
</div>
