<?php

namespace Modules\Contact\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property string id
 * @property string contact
 * @property string content
 * @property string channel
 * @property string status
 * @property Carbon created_at
 * @property Carbon schedule_time
 */
class ContactNotification extends Model
{
    protected $fillable = [
        'uuid',
        'contact',
        'content',
        'channel',
        'status',
        'schedule_time'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'schedule_time' => 'datetime'
    ];
}
