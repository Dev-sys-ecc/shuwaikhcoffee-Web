<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Hesabe\Payment\Payment;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function initiatePayment($id)
    {
        $offer = Offer::find($id);
        $user = auth('web')->user();

        if (!$offer) {
            return redirect()->back()->with('error', 'Offer not found.');
        }

        if (!$user) {
            return redirect()->back()->with('error', 'Please login first');
        }

        if (!$user->number || !$user->address) {
            session(['previous_url' => url()->current()]);

            return redirect()->route('edite-user-profile')->with('error', 'Please enter the phone number and address.');
        }

        if ($user->offers()->where('offer_id', $offer->id)->exists()) {
            return redirect()->back()->with('error', 'You are already subscribed to this offer.');
        }

        $TranTrackid = mt_rand();
        $TranportalId = "501801";
        $ReqTranportalId = "id=" . $TranportalId;
        $ReqTranportalPassword = "password=501801pg";
        $ReqAmount = "amt=" . $offer->price;
        $ReqTrackId = "trackid=" . $TranTrackid;
        $ReqCurrency = "currencycode=414";
        $ReqLangid = "langid=USA";
        $ReqAction = "action=1";
        $ResponseUrl = route('payment.response');
        $ReqResponseUrl = "responseURL=" . $ResponseUrl;
        $ErrorUrl = route('payment.error');
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

        session(['offer_id' => $offer->id]);
        return redirect()->away($url);
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
}
