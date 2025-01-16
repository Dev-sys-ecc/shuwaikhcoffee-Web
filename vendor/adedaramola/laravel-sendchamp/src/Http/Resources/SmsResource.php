<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Resources;

use Adedaramola\Sendchamp\Http\Requests\CreateSenderIdRequest;
use Adedaramola\Sendchamp\Http\Requests\SendSmsRequest;

final class SmsResource extends Resource
{
    public function send(SendSmsRequest $request)
    {
        $response = $this->client->post('/sms/send', $request->toArray());

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function createSenderID(CreateSenderIdRequest $request)
    {
        $response = $this->client->post('/sms/create-sender-id', $request->toArray());

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function getDeliveryReport(string $sms_uid)
    {
        $response = $this->client->get(`/sms/status/{$sms_uid}`);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }

    public function getBulkDeliveryReport(string $bulksms_uid)
    {
        $response = $this->client->get(`/sms/bulk-sms-status/{$bulksms_uid}`);

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }
}
