<?php

use Livewire\Volt\Component;
use App\Models\Podcast;

new class extends Component {
    public $isProcessing = false;
    public $status = 'Not started';
    public $title = '';

    public function createPodcast()
    {
        $this->validate([
            'title' => 'required|min:3',
        ]);

        $this->isProcessing = true;
        $this->status = 'Processing';

        // Simulate processing time
        sleep(5);

        Podcast::create([
            'title' => $this->title,
            'status' => 'published',
        ]);

        $this->isProcessing = false;
        $this->status = 'Not started';
        $this->title = '';
    }

    public function with()
    {
        return [
            'podcasts' => Podcast::all(),
        ];
    }
}; ?>

<div class="flex flex-col justify-center items-center px-6 py-8 min-h-screen bg-gray-100">
    <div class="w-full max-w-md">
        <h1 class="mb-6 text-2xl font-bold text-center text-gray-800">Podcast Generator (Before)</h1>

        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="mb-4">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Podcast Title</label>
                <input type="text" id="title" wire:model="title"
                    class="px-3 py-2 w-full text-gray-700 rounded-md border focus:outline-none focus:border-blue-500">
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <x-primary-button wire:click="createPodcast" wire:loading.attr="disabled" class="justify-center w-full"
                :disabled="$isProcessing">
                {{ $isProcessing ? 'Processing...' : 'Create Podcast' }}
            </x-primary-button>
        </div>

        <div class="flex justify-center">
            <x-spinner wire:loading wire:target='createPodcast' class="mt-4" />
        </div>

        @if ($isProcessing)
            <div class="p-4 mt-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-2 text-lg font-semibold text-gray-800">Processing Status</h2>
                <div class="flex items-center">
                    <div class="mr-2 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-gray-600">{{ ucfirst($status) }}</span>
                </div>
            </div>
        @endif

        <div class="p-6 mt-8 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-semibold text-gray-800">All Podcasts</h2>
            @if ($podcasts->count() > 0)
                <ul class="space-y-2">
                    @foreach ($podcasts as $podcast)
                        <li class="flex items-center">
                            <svg class="mr-2 w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">{{ $podcast->title }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">No podcasts yet.</p>
            @endif
        </div>
    </div>
</div>
