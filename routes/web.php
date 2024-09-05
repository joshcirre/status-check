<?php

use Livewire\Volt\Volt;

Volt::route('/', 'queue-runner');
Volt::route('/before', 'before-queue-runner');

require __DIR__.'/auth.php';
