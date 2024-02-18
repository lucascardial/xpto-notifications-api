<?php

namespace Modules\Contact\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Contact\Enums\ContactNotificationStatusEnum;
use Modules\Contact\Models\ContactNotification;


class ExecuteScheduledNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        ContactNotification::query()
            ->where('schedule_time', '<=', now())
            ->where('status', ContactNotificationStatusEnum::PENDING)
            ->chunk(1000, function ($notifications) {
                foreach ($notifications as $notification) {
                    $notification->update(['status' => ContactNotificationStatusEnum::PROCESSING]);
                    // Send notification
                    $notification->update(['status' => ContactNotificationStatusEnum::SENT]);
                }
            });
    }
}
