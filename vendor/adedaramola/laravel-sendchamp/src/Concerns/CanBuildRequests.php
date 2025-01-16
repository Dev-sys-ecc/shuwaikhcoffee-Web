<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Concerns;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait CanBuildRequests
{
    public function buildRequest(): PendingRequest
    {
        return Http::baseUrl($this->url())
            ->acceptJson()
            ->withToken($this->publicKey())
            ->timeout($this->timeout());
    }

    public function get(string $url, array|string|null $query = null): Response
    {
        return $this->buildRequest()->get($url, $query);
    }

    public function post(string $url, array $data = []): Response
    {
        return $this->buildRequest()->post($url, $data);
    }
}
