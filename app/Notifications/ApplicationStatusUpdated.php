<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public string $jobTitle,
        public string $newStatus,
        public ?string $note = null
    ) {}

    public function via($notifiable): array
    {
        return ['database']; // in-app database notification
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Status Lamaran Diperbarui',
            'message' => "Lamaran untuk '{$this->jobTitle}' sekarang: {$this->newStatus}.",
            'status' => $this->newStatus,
            'note' => $this->note,
        ];
    }
}
