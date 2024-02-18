<?php

namespace Modules\Contact\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Enums\ContactFileImportStatusEnum;

/**
 * @property int $id
 * @property string $uuid
 * @property string $file_name
 * @property int $total_lines
 * @property ContactFileImportStatusEnum $status
 * @property Carbon $created_at
 */
class ContactFileImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'file_name',
        'total_lines',
        'status'
    ];

    protected $casts = [
        'status' => ContactFileImportStatusEnum::class,
        'created_at' => 'datetime'
    ];
}
