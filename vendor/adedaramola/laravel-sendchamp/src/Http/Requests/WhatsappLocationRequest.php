<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Requests;

use Adedaramola\Sendchamp\Contracts\RequestContract;

class WhatsappLocationRequest implements RequestContract
{
    public function __construct(
        protected string $sender,
        protected string $recipient,
        protected string $type,
        protected int $longititude,
        protected int $latitude,
        protected string $name,
        protected string $address,
    ) {
    }

    public function toArray(): array
    {
        return [
            'sender' => $this->sender,
            'recipient' => $this->recipient,
            'type' => $this->type,
            'longititude' => $this->longititude,
            'latitude' => $this->latitude,
            'name' => $this->name,
            'address' => $this->address,
        ];
    }
}
