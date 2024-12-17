<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class Navbar extends Component
{
    public string $title;

    // Listen for title change events
    protected $listeners = ['updatePageTitle' => 'setTitle'];

    public function mount()
    {
        // Default title
        $this->title = 'SISTEM REKOD PEMINJAMAN PERALATAN MULTIMEDIA DI MAKMAL FPTV';
    }

    public function setTitle(string $newTitle)
    {
        $this->title = $newTitle;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
