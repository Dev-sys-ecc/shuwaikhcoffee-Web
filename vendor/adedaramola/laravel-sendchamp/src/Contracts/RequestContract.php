<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Contracts;

interface RequestContract
{
    public function toArray(): array;
}
