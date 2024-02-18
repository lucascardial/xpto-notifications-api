<?php

namespace Core\Error;

enum ErrorUiActionEnum: string
{
    case SHOW_DIALOG_ERROR = 'show_dialog_error';
    case SHOW_TOAST_ERROR = 'show_toast_error';
}
