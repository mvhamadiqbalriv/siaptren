<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendaftaranNotification extends Notification
{
    use Queueable;

    protected $kode_santri, $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($kode_santri, $message)
    {
        $this->kode_santri = $kode_santri;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase()
    {
        return [
            'kode' => $this->kode_santri,
            'message' => $this->message,
            'url' => 'master/civitas/santri?notif='
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
