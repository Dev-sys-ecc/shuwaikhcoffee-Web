<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Requests;

use Adedaramola\Sendchamp\Contracts\RequestContract;

class CreateSenderIdRequest implements RequestContract
{
    public function __construct(
        protected string $name,
        protected string $sample,
        protected string $use_case,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sample' => $this->sample,
            'use_case' => $this->use_case,
        ];
    }
}
