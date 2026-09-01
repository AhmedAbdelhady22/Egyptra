<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Lead $lead) {}

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $lead = $this->lead->loadMissing('property');

        $mail = (new MailMessage)
            ->subject(__('New lead from :name', ['name' => $lead->name]))
            ->greeting(__('New contact inquiry'))
            ->line(__('Name: :name', ['name' => $lead->name]))
            ->line(__('Phone: :phone', ['phone' => $lead->phone]));

        if ($lead->email) {
            $mail->line(__('Email: :email', ['email' => $lead->email]));
        }

        if ($lead->message) {
            $mail->line(__('Message: :message', ['message' => $lead->message]));
        }

        if ($lead->property) {
            $mail->line(__('Property: :title', [
                'title' => $lead->property->getTranslation('title', app()->getLocale(), false)
                    ?: $lead->property->getTranslation('title', 'en', false),
            ]));
        }

        return $mail->salutation(__('Egyptra'));
    }
}
