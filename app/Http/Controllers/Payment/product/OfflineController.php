<?php

namespace App\Http\Controllers\Payment\product;

use App\Events\OrderPlaced;
use App\Models\Offer;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Payment\product\PaymentController;
use App\Models\BasicSetting;
use App\Models\PostalCode;
use App\Models\ShippingCharge;
use Session;
use Str;


class OfflineController extends PaymentController
{

    public function store(Request $request)
    {
        if($this->orderValidation($request)) {
            return $this->orderValidation($request);
        }

        $bs = BasicSetting::select('postal_code')->firstOrFail();

        if ($request->serving_method == 'home_delivery') {
            if ($bs->postal_code == 0) {
                if ($request->has('shipping_charge')) {
                    $shipping = ShippingCharge::findOrFail($request->shipping_charge);
                    $shippig_charge = $shipping->charge;
                } else {
                    $shipping = NULL;
                    $shippig_charge = 0;
                }
            } else {
                $shipping = PostalCode::findOrFail($request->postal_code);
                $shippig_charge = $shipping->charge;
            }
            if (!empty($shipping) && !empty($shipping->free_delivery_amount) && cartTotal() >= $shipping->free_delivery_amount) {
                $shippig_charge = 0;
            } else {
                $shippig_charge = $shippig_charge;
            }
        } else {
            $shipping = NULL;
            $shippig_charge = 0;
        }
        $total = $this->orderTotal($shippig_charge);

        $txnId = 'txn_' . Str::random(8) . time();
        $chargeId = 'ch_' . Str::random(9) . time();
        $order = $this->saveOrder($request, $shipping, $total, $txnId, $chargeId, 'offline');
        $order_id = $order->id;

        $this->saveOrderItem($order_id);

        if ($order->gateway_type == 'online by knet') {
            $TranTrackid = mt_rand();

            $TranportalId = "501801";
            $ReqTranportalId = "id=" . $TranportalId;
            $ReqTranportalPassword = "password=501801pg";

            $ReqAmount = "amt=" . $total;
            $ReqTrackId = "trackid=" . $TranTrackid;
            $ReqCurrency = "currencycode=414";
            $ReqLangid = "langid=USA";
            $ReqAction = "action=1";

            $ResponseUrl = "https://shuwaikhcoffee.com/payment-response";
            $ReqResponseUrl = "responseURL=" . $ResponseUrl;

            $ErrorUrl = "https://shuwaikhcoffee.com/payment-error";
            $ReqErrorUrl = "errorURL=" . $ErrorUrl;

            $ReqUdf1 = "udf1=Test1";
            $ReqUdf2 = "udf2=Test2";
            $ReqUdf3 = "udf3=Test3";
            $ReqUdf4 = "udf4=Test4";
            $ReqUdf5 = "udf5=Test5";

            $param = $ReqTranportalId . "&" . $ReqTranportalPassword . "&" . $ReqAction . "&" . $ReqLangid . "&" . $ReqCurrency . "&" . $ReqAmount . "&" . $ReqResponseUrl . "&" . $ReqErrorUrl . "&" . $ReqTrackId . "&" . $ReqUdf1 . "&" . $ReqUdf2 . "&" . $ReqUdf3 . "&" . $ReqUdf4 . "&" . $ReqUdf5;

            $termResourceKey = "52Z7YBXS832YHA05";
            $param = $this->encryptAES($param, $termResourceKey) . "&tranportalId=" . $TranportalId . "&responseURL=" . $ResponseUrl . "&errorURL=" . $ErrorUrl;

            $url = "https://kpaytest.com.kw/kpg/PaymentHTTP.htm?param=paymentInit" . "&trandata=" . $param;

            session('order_id' , $order->id);
            return redirect()->away($url);
        }


        Session::forget('coupon');
        Session::forget('my-cart');


        return redirect()->route('front.index')->with('success' , 'Placed Order Successfully ');

    }
    private function encryptAES($str, $key) {
        $str = $this->pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', $encrypted);
        $encrypted = $this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }

    private function pkcs5_pad($text) {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private function byteArray2Hex($byteArray) {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }

    public function ErrorKentUrl(Request $request)
    {
        $errorData = $request->all();

        Session::forget('coupon');
        Session::forget('my-cart');
        Session::forget('order_id');

        return view('front.payment.error', compact('errorData'));
    }
    public function responseKentUrl(Request $request)
    {
        $responseData = $request->all();

        $order_id = session()->get('order_id');
        $offer = session()->get('offer_id');
        $user = auth('web')->user();
        if ($order_id)
        {
        $order = ProductOrder::where('id' , $order_id)->first();
        $order->payment_status = 'Paid';
        Session::forget('coupon');
        Session::forget('my-cart');
        Session::forget('order_id');
            return view('front.payment.success', compact('responseData'));
        }else{
            Session::forget('coupon');
            Session::forget('my-cart');
            Session::forget('offer_id');
            $user->offers()->attach($offer);
            return view('front.payment.success', compact('responseData'));
        }

    }
}
