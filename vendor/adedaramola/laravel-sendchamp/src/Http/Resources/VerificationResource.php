<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Resources;

use Adedaramola\Sendchamp\Http\Requests\SendOtpRequest;

final class VerificationResource extends Resource
{
    public function sendOtp(SendOtpRequest $request)
    {
        $response = $this->client->post(
            '/verification/create',
            $request->toArray()
        );

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function confirmOtp(string $verification_reference, string $verification_code)
    {
        $response = $this->client->post('/verification/confirm', [
            'verification_reference' => $verification_reference,
            'verification_code' => $verification_code
        ]);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }
}
