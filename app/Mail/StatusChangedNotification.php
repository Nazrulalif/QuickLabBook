<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusChangedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public Booking $booking;

    
    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Booking Status Updated')
            ->markdown('emails.status-changed')
            ->with([
                'bookingName' => $this->booking->name,
                'status' => $this->booking->status,
                'startDate' => $this->booking->start_at,
                'endDate' => $this->booking->end_at,
                'items' => $this->booking->bookingItem, // Assuming a relationship exists
                'comment' => $this->booking->comment,
            ]);
    }
}
