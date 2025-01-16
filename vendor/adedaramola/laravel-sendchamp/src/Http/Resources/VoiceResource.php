<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Resources;

use Adedaramola\Sendchamp\Http\Requests\FileToVoiceRequest;
use Adedaramola\Sendchamp\Http\Requests\TextToSpeechRequest;

final class VoiceResource extends Resource
{
    public function textToSpeech(TextToSpeechRequest $request)
    {
        $response = $this->client->post('/voice/send', $request->toArray());

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function fileToVoice(FileToVoiceRequest $request)
    {
        $response = $this->client->post('/voice/send', $request->toArray());

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function getDeliveryReport(string $voice_uid)
    {
        $response = $this->client->get(`/voice/status/{$voice_uid}`);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }
}
