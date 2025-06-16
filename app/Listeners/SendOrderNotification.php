<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        // Pastikan mitra sudah ditentukan sebelum mengirim notifikasi
        if (!$order->mitra_id) {
            return;
        }

        // Kirim notifikasi ke mitra
        Notification::create([
            'user_id' => $order->mitra_id,
            'message' => "Pesanan baru dari {$order->user->name}",
            'is_read' => false,
        ]);
    }
}
