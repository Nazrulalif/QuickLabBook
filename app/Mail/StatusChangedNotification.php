<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusChangedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $newStatus;
    public $items;
    /**
     * Create a new message instance.
     */
    public function __construct($booking, $newStatus)
    {
        $this->booking = $booking;
        $this->newStatus = $newStatus;
        $this->items = $booking->bookingItem;
    }

    public function build()
    {
        return $this->subject('Booking Status Updated')
            ->markdown('emails.status-changed')
            ->with([
                'bookingName' => $this->booking->name,
                'status' => $this->newStatus,
                'startDate' => $this->booking->start_at,
                'endDate' => $this->booking->end_at,
                'items' => $this->items, 
                'comment' => $this->booking->comment, 
            ]);
    }
}
