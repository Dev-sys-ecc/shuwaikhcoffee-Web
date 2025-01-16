<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Requests;

use Adedaramola\Sendchamp\Contracts\RequestContract;

class SendOtpRequest implements RequestContract
{
    public function __construct(
        protected string $channel,
        protected string $sender,
        protected string $token_type,
        protected int $token_length,

    ) {
    }

    public function toArray(): array
    {
        return [
            'channel' => $this->channel,
            'sender' => $this->sender,
            'token_type' => $this->token_type,
            'token_length' => $this->token_length
        ];
    }
}
