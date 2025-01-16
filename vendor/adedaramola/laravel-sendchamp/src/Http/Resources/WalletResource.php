<?php

declare(strict_types=1);

namespace Adedaramola\Sendchamp\Http\Resources;

final class WalletResource extends Resource
{
    public function getBalance()
    {
        $response = $this->client->post('/wallet/wallet_balance');

        $this->throwFailedErrorResponse($response);

        return $response->object();
    }
}
