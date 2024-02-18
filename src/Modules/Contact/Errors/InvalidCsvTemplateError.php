<?php

namespace Modules\Contact\Errors;

use Core\Error\ErrorBase;
use Core\Error\ErrorUiActionEnum;
use Core\Error\ErrorUiDialogContentTypeEnum;
use Core\Error\HttpClientErrorCodeEnum;

class InvalidCsvTemplateError extends ErrorBase
{
    public function __construct()
    {
        $message = trans('contact::errors.invalid_sheets_template.title');
        $detail = trans('contact::errors.invalid_sheets_template.detail');

        $extra = [
            'ui_action' => ErrorUiActionEnum::SHOW_DIALOG_ERROR,
            'ui_dialog_content_type' => ErrorUiDialogContentTypeEnum::SERVER_RENDERED,
            'ui_view' => 'contact::errors.invalid_csv_template'
        ];

        parent::__construct(
            message: $message,
            detail: $detail,
            statusCode: HttpClientErrorCodeEnum::UNPROCESSABLE_ENTITY,
            errorCode: 'invalid_csv_template',
            extra: $extra);
    }
}
