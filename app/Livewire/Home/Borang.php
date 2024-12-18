<?php

namespace App\Livewire\Home;

use App\Mail\AdminBookingNotification;
use App\Models\Booking;
use App\Models\Lab;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Borang extends Component
{
    use LivewireAlert;
    public $lab_id;
    public $start_date;
    public $end_date;
    public $items;
    public $lab;
    public $name;
    public $matric;
    public $emel;
    public $tahap_pengajian;
    public $tahun_pengajian;
    public $tujuan;

    public function mount()
    {
        // Retrieve and decode session data
        $this->lab_id = session('lab_id');
        $this->start_date = Carbon::parse(session('start_date'));
        $this->end_date =  Carbon::parse(session('end_date'));
        $this->items = json_decode(session('items'), true); // Decode JSON string to an array
        $this->lab = Lab::where('id', $this->lab_id)->first();

        if (!session('lab_id') || !session('start_date') || !session('end_date') || !json_decode(session('items'), true)) {
            return redirect('/tempahan');
        }
    }

    public function back()
    {
        session()->forget(['lab_id', 'start_date', 'end_date', 'items']);

        return redirect('/tempahan');
    }

    public function submitBorang(){
        $this->validate([
            'name'=> 'required',
            'matric'=> 'required',
            'emel'=> 'required|email',
            'tahap_pengajian'=> 'required',
            'tahun_pengajian'=> 'required',
            'tujuan'=> 'required',
        ]);

        $booking = Booking::create([
            'name'=>$this->name,
            'no_matric'=>$this->matric,
            'email'=>$this->emel,
            'level_study'=>$this->tahap_pengajian,
            'year_study'=>$this->tahun_pengajian,
            'start_at'=>$this->start_date,
            'end_at'=>$this->end_date,
            'purpose'=>$this->tujuan,
        ]);

          // Loop through the items and associate them with the booking
        foreach ($this->items as $item) {
            $booking->bookingItem()->create([
                'stock_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);

            $stock = Stock::find($item['id']);
            $items[] = [
                'name' => $stock->name,
                'quantity' => $item['quantity'],
            ];
        }
        $emails = User::pluck('email'); // Retrieve all user email addresses
        foreach ($emails as $email) {
            Mail::to($email)->send(new AdminBookingNotification($booking, $items));
        }
        session()->flash('success', 'Tempahan berjaya dihantar.');
        // Clear session after successful submission
        session()->forget(['lab_id', 'start_date', 'end_date', 'items']);

        // Redirect with a success message
        return redirect('/tempahan')->with('success', 'Tempahan berjaya dihantar.');
    }

    public function render()
    {
        return view('livewire.home.borang');
    }
}
