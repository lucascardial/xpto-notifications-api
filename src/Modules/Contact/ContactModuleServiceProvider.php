<?php

namespace Modules\Contact;

use Illuminate\Support\ServiceProvider;

class ContactModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/Resource/views/', 'contact');
    }
}
