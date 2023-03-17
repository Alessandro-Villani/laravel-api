<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublishedProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected Project $project;

    /**
     * Create a new message instance.
     */
    public function __construct($_project)
    {
        $this->project = $_project;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuovo progetto ' . $this->project->name . ' pubblicato',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $project = $this->project;
        $url =  env('APP_FRONTEND_URL') . 'projects/' . $project->id;

        return new Content(
            markdown: 'mails.projects.published',
            with: compact('project', 'url')
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
