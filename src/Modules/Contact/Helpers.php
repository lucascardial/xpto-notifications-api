<?php

namespace Modules\Contact;

use Modules\Contact\Enums\ContactTypeEnum;

final class Helpers
{
    public static function checkContactType(string $contact): ContactTypeEnum
    {
        if(filter_var($contact, FILTER_VALIDATE_EMAIL))
            return ContactTypeEnum::EMAIL;

        if(preg_match('/^\(?[0-9]{2}\)?\s?[0-9]{4,5}-?[0-9]{4}$/', $contact))
            return ContactTypeEnum::PHONE;

        return ContactTypeEnum::UNKNOWN;
    }
}
