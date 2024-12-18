<?php

namespace App\Livewire\Home;

use App\Models\BookingItem;
use App\Models\Lab;
use App\Models\Stock;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Tempahan extends Component
{
    use LivewireAlert;
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
        // Retrieve the item and its available quantity
        $item = Stock::find($itemId);
    
        if (!$item) {
            return;
        }
    
        // Calculate the reserved quantity for overlapping bookings
        $reservedQuantity = BookingItem::where('stock_id', $itemId)
            ->whereHas('booking', function ($query) {
                $query->where('status', 'approved') // Only approved bookings
                      ->where(function ($q) {
                          $q->whereBetween('start_at', [$this->start_date, $this->end_date])
                            ->orWhereBetween('end_at', [$this->start_date, $this->end_date])
                            ->orWhere(function ($subQuery) {
                                $subQuery->where('start_at', '<=', $this->start_date)
                                         ->where('end_at', '>=', $this->end_date);
                            });
                      });
            })
            ->sum('quantity');
    
        // Calculate available quantity
        $availableQuantity = $item->quantity - $reservedQuantity;
    
        // Check if current quantity is less than available quantity
        if (isset($this->quantities[$itemId]) && $this->quantities[$itemId] < $availableQuantity) {
            $this->quantities[$itemId]++;
        } elseif (!isset($this->quantities[$itemId]) && $availableQuantity > 0) {
            $this->quantities[$itemId] = 1; // Initialize to 1 if not set
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
            // Get all stocks for the selected lab
            $allStock = Stock::where('lab_id', $this->selectedLab)->where('is_available', true)->get();
    
            // Calculate available stock by checking approved bookings
            $stock = $allStock->map(function ($item) {
                // Calculate total reserved quantity for the current item
                $reservedQuantity = BookingItem::where('stock_id', $item->id)
                    ->whereHas('booking', function ($query) {
                        $query->where('status', 'approved') // Only approved bookings
                              ->where(function ($q) {
                                  $q->whereBetween('start_at', [$this->start_date, $this->end_date])
                                    ->orWhereBetween('end_at', [$this->start_date, $this->end_date])
                                    ->orWhere(function ($subQuery) {
                                        $subQuery->where('start_at', '<=', $this->start_date)
                                                 ->where('end_at', '>=', $this->end_date);
                                    });
                              });
                    })
                    ->sum('quantity');
    
                // Calculate the available quantity
                $availableQuantity = $item->quantity - $reservedQuantity;
    
                // Attach available quantity to the stock item
                $item->available_quantity = max($availableQuantity, 0); // Prevent negative values
    
                return $item;
            })->filter(function ($item) {
                // Filter out items with zero or negative available quantities
                return $item->available_quantity > 0;
            });

            // dd($stock);
        }
    
        // Display success message if it exists in the session
        $message = session('success');
        if ($message) {
            $this->alert('success', $message, [
                'position' => 'top-right',
                'time' => 300,
                'toast' => true,
            ]);
        }
    
        return view('livewire.home.tempahan', [
            'lab' => $lab,
            'stock' => $stock,
        ]);
    }
}
