<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'contact_type'
    ];
}
