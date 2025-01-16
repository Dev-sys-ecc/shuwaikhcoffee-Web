<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Providers;

use Illuminate\Support\ServiceProvider;

class SendchampServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/services.php',
            'services'
        );
    }
}
