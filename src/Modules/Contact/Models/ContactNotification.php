<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class ContactNotification extends Model
{
    protected $fillable = [
        'contact_id',
        'message',
        'status',
        'notify_at',
    ];
}
