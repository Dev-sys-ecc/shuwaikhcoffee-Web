<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Requests;

use Adedaramola\Sendchamp\Contracts\RequestContract;

class TextToSpeechRequest implements RequestContract
{
    public function __construct(
        protected array $customer_mobile_number,
        protected string $message,
        protected string $type,
        protected int $repeat
    ) {
    }

    public function toArray(): array
    {
        return [
            'customer_mobile_number' => $this->customer_mobile_number,
            'message' => $this->message,
            'type' => $this->type,
            'repeat' => $this->repeat
        ];
    }
}
