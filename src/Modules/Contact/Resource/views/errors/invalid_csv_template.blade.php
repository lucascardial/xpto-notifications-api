@php
    $filePath = 'contatos_template.csv';
    $routeLink = route('download', ['file' => $filePath]);
@endphp
<h1 style="color: #d32f2f">{{ trans('contact::errors.invalid_sheets_template.title') }}</h1>
<p>{{ trans('contact::errors.invalid_sheets_template.detail') }}</p>
<p>{{ trans('contact::errors.invalid_sheets_template.helper_text') }}</p>
<a target="_blank" href="{{ $routeLink }}">Baixar</a>
