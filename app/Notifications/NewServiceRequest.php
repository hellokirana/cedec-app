<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewServiceRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ada Permintaan Service Baru!')
            ->line('Ada pelanggan yang mencari jasa:')
            ->line('Kategori: '.$this->order->category)
            ->line('Lokasi: '.$this->order->location)
            ->action('Lihat Detail', url('/orders/'.$this->order->id))
            ->line('Segera respon permintaan ini!');
    }
}
