<?php

declare(strict_types=1);

use Adedaramola\Sendchamp\Http\Client;
use Illuminate\Support\Facades\Facade;

final class Sendchamp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}
