<?php

namespace App\Livewire\Home;

use Livewire\Component;

class Hubungi extends Component
{
    public function mount()
    {
        // Dispatch an event to update the header title when the component is mounted
        $this->dispatch('updatePageTitle', 'HUBUNGI');
    }
    public function render()
    {
        return view('livewire.home.hubungi');
    }
}
