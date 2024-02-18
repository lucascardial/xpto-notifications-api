<?php

namespace App\Http\Requests\Contacts;

use DateTime;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EditContactNotificationRequest
 * @property string $contact
 * @property string $content
 * @property DateTime $schedule_date
 */
class EditContactNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact' => 'required|string',
            'content' => 'required|string',
            'schedule_date' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
