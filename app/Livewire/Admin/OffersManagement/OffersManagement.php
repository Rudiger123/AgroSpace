<?php

namespace App\Livewire\Admin\OffersManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout("layouts.app")]
#[Title("Offers Management")]
class OffersManagement extends Component
{
    public $title =  "Hello world";
    public function show()
    {
        dump($this->title);
    }

    public function render()
    {
        return view('livewire.admin.offers-management.offers-management');
    }
}
