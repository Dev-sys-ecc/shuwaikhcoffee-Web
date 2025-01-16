<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Requests;

use Adedaramola\Sendchamp\Contracts\RequestContract;

class WhatsappMessageRequest implements RequestContract
{
    public function __construct(
        protected string $recipient,
        protected string $sender,
        protected string $type,
        protected string|null $messgae,
        protected string|null $link,
    ) {
    }

    public function toArray(): array
    {
        return [
            'recipient' => $this->recipient,
            'sender' => $this->sender,
            'type' => $this->type,
            $this->message ?? 'message' => $this->message,
            $this->link ?? 'link' => $this->link,
        ];
    }
}
