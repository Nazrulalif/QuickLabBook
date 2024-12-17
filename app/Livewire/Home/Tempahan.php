<?php

namespace App\Livewire\Home;

use Livewire\Component;

class Tempahan extends Component
{
    public $start_date;
    public $end_date;
    public $selectedLab = null; // Selected lab
    public $showLabs = false;   // Show labs after date selection
    public $showDate = true;    // Show date selection initially
    public $showItem = false;   // Show items after lab selection

    // To simulate item quantities
    public $items = [
        ['name' => 'Canon', 'stock' => 5, 'selectedQty' => 0],
        ['name' => 'Nikon', 'stock' => 3, 'selectedQty' => 0],
        ['name' => 'Sony', 'stock' => 4, 'selectedQty' => 0],
        ['name' => 'Fujifilm', 'stock' => 2, 'selectedQty' => 0],
    ];

    public function mount()
    {
        $this->dispatch('updatePageTitle', 'TEMPAHAN PINJAMAN BAGI PERALATAN MULTIMEDIA');
    }
    public function goBack($step)
    {
        $this->resetSteps();

        if ($step === 'showDate') {
            $this->showDate = true;
        } elseif ($step === 'showLabs') {
            $this->showLabs = true;
        }
    }
    private function resetSteps()
    {
        $this->showDate = false;
        $this->showLabs = false;
        $this->showItem = false;
    }
    public function sendDate()
    {
        $this->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $this->showDate = false;
        $this->showLabs = true;
    }

    public function submitLabChoice()
    {
        if (!$this->selectedLab) {
            session()->flash('message', 'Sila pilih makmal sebelum submit.');
            return;
        }

        $this->showLabs = false;
        $this->showItem = true;
    }

    public function incrementQty($index)
    {
        if ($this->items[$index]['selectedQty'] < $this->items[$index]['stock']) {
            $this->items[$index]['selectedQty']++;
        }
    }

    public function decrementQty($index)
    {
        if ($this->items[$index]['selectedQty'] > 0) {
            $this->items[$index]['selectedQty']--;
        }
    }

    public function render()
    {
        return view('livewire.home.tempahan');
    }
}
