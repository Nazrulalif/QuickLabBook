<?php

namespace App\Livewire\Home;

use Livewire\Component;

class SoalanLazim extends Component
{
    public function mount()
    {
        // Dispatch an event to update the header title when the component is mounted
        $this->dispatch('updatePageTitle', 'SOALAN LAZIM');
    }

    public function render()
    {
        return view('livewire.home.soalan-lazim');
    }
}
