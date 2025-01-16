<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KNETService
{
    protected $tranportalId;
    protected $tranportalPassword;
    protected $resourceKey;
    protected $alias;

    public function __construct()
    {
        $this->tranportalId = env('KNET_TRANPORTAL_ID');
        $this->tranportalPassword = env('KNET_TRANPORTAL_PASSWORD');
        $this->resourceKey = env('KNET_RESOURCE_KEY');
        $this->alias = env('KNET_ALIAS');
    }

    public function initializePayment($amount, $trackId)
    {
        $response = Http::asForm()->post('https://www.kpay.com.kw/kpg/txn/initiate', [
            'id' => $this->tranportalId,
            'amt' => $amount,
            'trackid' => $trackId,
        ]);

        return $response->json();
    }

    public function handleResponse($request)
    {
        $response = $request->all();
        // تحقق من الاستجابة واحفظ البيانات في قاعدة البيانات
        return $response;
    }
}
