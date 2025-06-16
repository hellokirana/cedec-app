<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\NewServiceRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotificationToWorkers implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        // Ambil kategori service dari order
        $serviceCategory = $event->order->category;

        // Cari worker dengan kategori yang sesuai
        $workers = User::where('role', 'worker')
            ->where('service_category', $serviceCategory)
            ->get();

        // Kirim notifikasi ke setiap worker
        foreach ($workers as $worker) {
            // Pastikan worker memiliki email
            if ($worker->email) {
                $worker->notify(new NewServiceRequest($event->order));
            }
        }
    }
}
