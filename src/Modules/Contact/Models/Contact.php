<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Enums\ContactTypeEnum;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $contact
 * @property ContactTypeEnum $contact_type
 */
class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'name',
        'contact',
        'contact_type'
    ];

    protected $casts = [
        'contact_type' => ContactTypeEnum::class
    ];
}
