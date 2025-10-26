<?php

use Livewire\Volt\Component;

new class extends Component {
    public function open()
    {
        dump('hello world');
    }
}; ?>

<div>
    <button wire:click='open'>
        tester
    </button>
</div>
