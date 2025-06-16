<?php
namespace App\Listeners;

use App\Events\NewServiceRequested;
use App\Models\User;
use App\Notifications\NewServiceRequest;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendServiceNotification implements ShouldQueue
{
    public function handle(NewServiceRequested $event)
    {
        $workers = User::where('role', 'worker')
            ->where('service_category', $event->order->category)
            ->get();

        foreach ($workers as $worker) {
            $worker->notify(new NewServiceRequest($event->order));
        }
    }
}
