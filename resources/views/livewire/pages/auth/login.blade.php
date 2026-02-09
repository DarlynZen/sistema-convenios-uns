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

        $this->redirectIntended(default: route('admin.dashboard', absolute: false));
    }
}; ?>

<div class="w-full max-w-md">
    <div class="space-y-5">
        <div class="rounded border border-gray-200 bg-gray-100 px-6 py-4 text-center">
            <h1 class="text-lg font-semibold text-gray-800">Acceso Administrativo</h1>
            <p class="mt-1 text-sm text-gray-600 leading-snug">
                Dirección de Cooperación Técnica e Intercambio<br>
                Académico
            </p>
        </div>

        <div class="rounded border border-gray-200 bg-white px-6 py-6 shadow-sm">
            <div class="flex items-center gap-2 text-gray-800">
                <svg class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M7 10V8a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M7.5 10h9A2.5 2.5 0 0 1 19 12.5v6A2.5 2.5 0 0 1 16.5 21h-9A2.5 2.5 0 0 1 5 18.5v-6A2.5 2.5 0 0 1 7.5 10Z" stroke="currentColor" stroke-width="1.8"/>
                </svg>
                <h2 class="text-base font-semibold">Iniciar Sesión</h2>
            </div>

            <div class="mt-5">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form wire:submit.prevent="login" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico:</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M20 21v-1a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.8"/>
                                </svg>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                wire:model.defer="form.email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="202014037@uns.edu.pe"
                                class="block w-full rounded-md border-gray-200 bg-white pl-9 pr-3 py-2 text-sm text-gray-800 placeholder:text-gray-300 focus:border-neutral-400 focus:ring-neutral-600"
                            >
                        </div>
                        @error('form.email')
                            <span class="text-sm text-brand">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M7 10V8a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M7.5 10h9A2.5 2.5 0 0 1 19 12.5v6A2.5 2.5 0 0 1 16.5 21h-9A2.5 2.5 0 0 1 5 18.5v-6A2.5 2.5 0 0 1 7.5 10Z" stroke="currentColor" stroke-width="1.8"/>
                                </svg>
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                wire:model.defer="form.password"
                                required
                                placeholder="Contraseña"
                                class="block w-full rounded-md border-gray-200 bg-white pl-9 pr-3 py-2 text-sm text-gray-800 placeholder:text-gray-300 focus:border-neutral-400 focus:ring-neutral-600"
                            >
                        </div>
                        @error('form.password')
                            <span class="text-sm text-brand">{{ $message }}</span>
                        @enderror
                    </div>
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded bg-[#D82F4B] px-4 py-2 text-sm font-medium text-white hover:bg-[#D42340] focus:outline-none focus:ring-2 focus:ring-[#D82F4B] focus:ring-offset-2 transition"
                    >
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
