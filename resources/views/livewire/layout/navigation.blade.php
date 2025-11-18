<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div x-data="{ open: false }" class="relative">
    <!-- User Dropdown Trigger -->
    <button 
        @click="open = !open"
        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors"
    >
        <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div 
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
        style="display: none;"
    >
        <a 
            href="{{ route('profile') }}" 
            wire:navigate
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        >
            {{ __('Profile') }}
        </a>
        <button 
            wire:click="logout" 
            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        >
            {{ __('Log Out') }}
        </button>
    </div>
</div>
