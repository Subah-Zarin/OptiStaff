<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AdminRegistrationRequest extends Notification
{
    use Queueable;

    public function __construct(public User $newAdmin) {}

    public function via(object $notifiable): array
    {
        return ['database']; // stored in DB, shown in dashboard
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message'      => "New admin registration request from {$this->newAdmin->name}",
            'applicant_id' => $this->newAdmin->id,
            'applicant_name'  => $this->newAdmin->name,
            'applicant_email' => $this->newAdmin->email,
        ];
    }
}