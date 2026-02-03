<?php

namespace App\Mail;

use App\Models\User;
use App\Services\DTO\EarthquakeDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EarthquakeThresholdExceeded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param EarthquakeDTO[] $earthquakes
     */
    public function __construct(
        public array $earthquakes,
        public User $user,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: new Address($this->user->email, $this->user->name),
            subject: 'Earthquake Threshold Exceeded',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.earthquake-threshold-exceeded',
        );
    }
}
