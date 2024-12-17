<?php

namespace App\Livewire\Home;

use Livewire\Component;

class Tempahan extends Component
{
    public function mount()
    {
        // Dispatch an event to update the header title when the component is mounted
        $this->dispatch('updatePageTitle', 'TEMPAHAN PINJAMAN BAGI PERALATAN MULTIMEDIA');
    }

    public function render()
    {
        return view('livewire.home.tempahan');
    }
}
