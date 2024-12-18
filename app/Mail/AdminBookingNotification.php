<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $items;

    /**
     * Create a new message instance.
     */
    public function __construct($booking, $items)
    {
        $this->booking = $booking;
        $this->items = $items;
    }

    public function build()
    {
        return $this->subject('Tempahan Baharu Dihantar')
                    ->markdown('emails.booking.notification')
                    ->with([
                        'booking' => $this->booking,
                        'items' => $this->items,
                    ]);
    }
}
