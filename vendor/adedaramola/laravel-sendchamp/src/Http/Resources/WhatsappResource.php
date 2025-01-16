<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Resources;

use Adedaramola\Sendchamp\Http\Requests\WhatsappLocationRequest;

final class WhatsappResource extends Resource
{
    public function sendText(string $recipient, string $sender, string $type, string $message)
    {
        $response = $this->client->post('/whatsapp/message/send', [
            'recipient' => $recipient,
            'sender' => $sender,
            'type' => $type,
            'message' => $message
        ]);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function sendVideo(string $recipient, string $sender, string $type, string $link)
    {
        $response = $this->client->post('/whatsapp/message/send', [
            'recipient' => $recipient,
            'sender' => $sender,
            'type' => $type,
            'link' => $link
        ]);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function sendAudio(string $recipient, string $sender, string $type, string $link)
    {
        $response = $this->client->post('/whatsapp/message/send', [
            'recipient' => $recipient,
            'sender' => $sender,
            'type' => $type,
            'link' => $link
        ]);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function sendSticker(string $recipient, string $sender, string $type, string $link)
    {
        $response = $this->client->post('/whatsapp/message/send', [
            'recipient' => $recipient,
            'sender' => $sender,
            'type' => $type,
            'link' => $link
        ]);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function sendLocation(WhatsappLocationRequest $request)
    {
        $response = $this->client->post('/whatsapp/message/send', $request->toArray());

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }
}
