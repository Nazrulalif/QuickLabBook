<?php

namespace App\Livewire\Home;

use App\Models\Lab;
use App\Models\Stock;
use Livewire\Component;

class Tempahan extends Component
{
    public $start_date;
    public $end_date;
    public $selectedLab = null; // Selected lab
    public $showLabs = false;   // Show labs after date selection
    public $showDate = true;    // Show date selection initially
    public $showItem = false;   // Show items after lab selection

    public $quantities = [];

    public function mount()
    {
        $this->dispatch('updatePageTitle', 'TEMPAHAN PINJAMAN BAGI PERALATAN MULTIMEDIA');


        // Initialize quantities for all stock items
        foreach (Stock::all() as $item) {
            $this->quantities[$item->id] = 0; // Default quantity set to 1
        }
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

    public function incrementQty($itemId)
    {
        // Retrieve the item from the database
        $item = Stock::find($itemId);

        if (!$item) {
            return;
        }

        // Check if the quantity is less than the stock quantity
        if (isset($this->quantities[$itemId]) && $this->quantities[$itemId] < $item->quantity) {
            $this->quantities[$itemId]++;
        }
    }

    public function decrementQty($itemId)
    {
        if (isset($this->quantities[$itemId]) && $this->quantities[$itemId] > 0) {
            $this->quantities[$itemId]--;
        }
    }

    public function hantar()
    {
        // Validate before proceeding
        if (!$this->start_date || !$this->end_date || !$this->selectedLab) {
            session()->flash('message', 'Sila lengkapkan semua pilihan sebelum hantar.');
            return;
        }

        // Prepare the data to send to the checkout page
        $selectedItems = collect($this->quantities)
            ->filter(fn($quantity) => $quantity > 0)
            ->map(function ($quantity, $itemId) {
                $item = Stock::find($itemId);
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'quantity' => $quantity,
                    'picture' => $item->picture,
                ];
            })->values()->toArray();

        session([
            'lab_id' => $this->selectedLab,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'items' => json_encode($selectedItems),
        ]);

        return redirect()->route('checkout');
    }

    public function render()
    {
        $lab = Lab::all();

        $stock = [];
        if ($this->selectedLab) {
            $stock = Stock::where('lab_id', $this->selectedLab)->get();
        }

        return view('livewire.home.tempahan', compact([
            'lab',
            'stock',
        ]));
    }
}
