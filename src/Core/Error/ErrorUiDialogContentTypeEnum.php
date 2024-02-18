<?php

namespace Core\Error;

enum ErrorUiDialogContentTypeEnum: string
{
    case SERVER_RENDERED = 'server_rendered';
    case CLIENT_RENDERED = 'client_rendered';
}
