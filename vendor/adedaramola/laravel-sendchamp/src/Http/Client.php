<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http;

use Closure;
use Adedaramola\Sendchamp\Concerns\CanBuildRequests;
use Adedaramola\Sendchamp\Http\Resources\EmailResource;
use Adedaramola\Sendchamp\Http\Resources\SmsResource;
use Adedaramola\Sendchamp\Http\Resources\VerificationResource;
use Adedaramola\Sendchamp\Http\Resources\VoiceResource;
use Adedaramola\Sendchamp\Http\Resources\WalletResource;
use Adedaramola\Sendchamp\Http\Resources\WhatsappResource;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;

class Client
{
    use CanBuildRequests;

    public function __construct(
        public string $url,
        public string $publicKey,
        public string $timeout,
    ) {
    }

    public static function fake(Closure|array $callback): Factory
    {
        return Http::fake($callback);
    }

    public function sms(): SmsResource
    {
        return new SmsResource($this);
    }

    public function whatsapp(): WhatsappResource
    {
        return new WhatsappResource($this);
    }

    public function voice(): VoiceResource
    {
        return new VoiceResource($this);
    }

    public function verification(): VerificationResource
    {
        return new VerificationResource($this);
    }

    public function email(): EmailResource
    {
        return new EmailResource($this);
    }

    public function wallet(): WalletResource
    {
        return new WalletResource($this);
    }

    private function url(): string
    {
        $mode = (string) config('services.sendchamp.mode');

        return match ($mode) {
            'sandbox' => (string) config('services.sendchamp.sandbox_url'),
            'live' => (string) config('services.sendchamp.live_url'),
        };
    }

    private function publicKey(): string
    {
        return (string) config('services.sendchamp.public_key');
    }

    private function timeout(): int
    {
        return (int) config('services.sendchamp.timeout');
    }
}
