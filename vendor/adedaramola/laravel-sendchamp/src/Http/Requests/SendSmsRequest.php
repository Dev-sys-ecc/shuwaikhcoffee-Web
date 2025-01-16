<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Requests;

use Adedaramola\Sendchamp\Contracts\RequestContract;

class SendSmsRequest implements RequestContract
{
    public function __construct(
        protected string $to,
        protected string $message,
        protected string $sender_name,
        protected string $route
    ) {
    }

    public function toArray(): array
    {
        return [
            'to' => $this->to,
            'message' => $this->message,
            'sender_name' => $this->sender_name,
            'route' => $this->route
        ];
    }
}
