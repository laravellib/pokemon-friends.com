<?php namespace obsession\App\Notifications\Channels;

use obsession\Infrastructure\{
    Contracts\Notifications\Notification,
    Interfaces\App\Notifications\Channels\MailableChannelInterface
};

class AdministratorMailableChannel implements MailableChannelInterface
{

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  Notification $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $notification
            ->toAdministrator($notifiable)
            ->to(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->send(app('mailer'));
    }
}
