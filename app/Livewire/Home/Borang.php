<?php

namespace App\Livewire\Home;

use App\Models\Lab;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Borang extends Component
{
    public $lab_id;
    public $start_date;
    public $end_date;
    public $items;
    public $lab;

    public function mount()
    {
        // Retrieve and decode session data
        $this->lab_id = session('lab_id');
        $this->start_date = Carbon::parse(session('start_date'));
        $this->end_date =  Carbon::parse(session('end_date'));
        $this->items = json_decode(session('items'), true); // Decode JSON string to an array

        $this->lab = Lab::where('id', $this->lab_id)->first();

        // Optional: Clear the session data after retrieving it
        // session()->forget(['lab_id', 'start_date', 'end_date', 'items']);
        if (!session('lab_id') || !session('start_date') || !session('end_date') || !json_decode(session('items'), true)) {
            return redirect('/tempahan');
        }
    }

    public function back()
    {
        session()->forget(['lab_id', 'start_date', 'end_date', 'items']);

        return redirect('/tempahan');
    }

    public function render()
    {
        return view('livewire.home.borang');
    }
}
