<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BasicExtended;
use App\Models\BasicSetting;
use App\Models\Language;
use App\Models\OrderItem;
use App\Models\OrderTime;
use App\Models\ProductOrder;
use App\Models\ShippingCharge;
use App\Models\TimeFrame;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function GetshippingCharge(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:ar,en',
        ]);

        $languageCode = $request->filled('lang') ? $request->input('lang') : 'ar';

        $language = Language::where('code', $languageCode)->firstOrFail();

        $shipping = ShippingCharge::where('language_id', $language->id)->get(['id' , 'title' , 'text' , 'charge' , 'free_delivery_amount']);

        return response([
            'message' => 'success',
            'shipping' => $shipping,
        ], 200);

    }
    public function MyOrders()
    {
        $orders = ProductOrder::where('user_id',auth()->user()->id)->orderBy('id', 'DESC')->get();

        if(count($orders) > 0)
        {
            return response([
                'message' => 'success',
                'orders' => $orders
            ], 200);
        }else{
            return response([
                'message' => 'error',
                'error' => 'No Orders Found',
            ], 400);
        }
    }




    public function orderValidation(Request $request)
    {
        $be = BasicExtended::first();
        $bs = BasicSetting::firstOrFail();

        if ($be->order_close == 1) {
            return response()->json(['error' => $be->order_close_message], 400);
        }

        if (auth()->user()->carts()->count() == 0) {
            return response()->json(['error' => 'No item added to cart!'], 400);
        }


        $now = Carbon::now();
        $todaysDay = strtolower($now->format('l'));
        $currentTime = strtotime($now->toTimeString());

        $orderTime = OrderTime::where('day', $todaysDay)->first();
        $start = strtotime($orderTime->start_time);
        $end = strtotime($orderTime->end_time);


        if (empty($start) || empty($end)) {
            return response()->json(['error' => "We are closed on " . $todaysDay], 400);
        }


        if (str_contains($orderTime->start_time, 'PM') && str_contains($orderTime->end_time, 'AM')) {
            $start = strtotime($now->toDateString() . ' ' . $orderTime->start_time);
            $end = strtotime(Carbon::now()->addDays(1)->toDateString() . ' ' . $orderTime->end_time);
            if ($currentTime < $start || $currentTime > $end) {
                return response()->json(['error' => "We take orders from " . $orderTime->start_time . " to " . $orderTime->end_time . " on " . $todaysDay], 400);
            }
        } elseif ((str_contains($orderTime->start_time, 'AM') && str_contains($orderTime->end_time, 'AM')) && ($end < $start)) {
            $start = strtotime($now->toDateString() . ' ' . $orderTime->start_time);
            $end = strtotime(Carbon::now()->addDays(1)->toDateString() . ' ' . $orderTime->end_time);
            if ($currentTime < $start || $currentTime > $end) {
                return response()->json(['error' => "We take orders from " . $orderTime->start_time . " to " . $orderTime->end_time . " on " . $todaysDay], 400);
            }
        } else {
            if ($currentTime < $start || $currentTime > $end) {
                return response()->json(['error' => "We take orders from " . $orderTime->start_time . " to " . $orderTime->end_time . " on " . $todaysDay], 400);
            }
        }

        $messages = [
            'gateway.required' => 'The gateway  field is required',
            'billing_fname.required' => 'The billing first name field is required',
            'billing_lname.required' => 'The billing last name field is required',
            'shipping_fname.required' => 'The shipping first name field is required',
            'shipping_lname.required' => 'The shipping last name field is required',
            'shipping_address.required' => 'The shipping address field is required',
            'shipping_city.required' => 'The shipping country field is required',
            'shipping_number.required' => 'The shipping phone number field is required',
            'shipping_email.required' => 'The shipping email field is required',
        ];

        $rules = [
            'gateway' => 'required|in:offline,Knet',
            'shipping_fname' => 'required',
            'shipping_lname' => 'required',
            'shipping_address' => 'required',
            'shipping_city' => 'required',
            'shipping_number' => 'required',
            'shipping_email' => 'required',
            'shipping_charge' => 'required',
            'discount' => 'nullable|numeric'
        ];

        if (!$request->has('same_as_shipping') || $request->same_as_shipping != 1) {
            $rules['billing_fname'] = 'required';
            $rules['billing_lname'] = 'required';
            $rules['billing_address'] = 'required';
            $rules['billing_city'] = 'required';
            $rules['billing_number'] = 'required';
            $rules['billing_email'] = 'required';
        }

        $request->validate($rules, $messages);
    }


    public function orderTotal($scharge , $discount) {
        $cart = Cart::where('user_id' , auth()->user()->id)->get();
        $total = 0.00;

        foreach ($cart as $key => $cartItem) {

            $total += $cartItem["total"];
        }

        $total = ($total + $scharge) - $discount;
        $total = round($total, 2);

        return $total;
    }
    public function saveOrderItem($orderId) {
        $userId = auth()->user()->id;
        $cartItems = Cart::where('user_id', $userId)->get();

        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);


            $quantity = $cartItem->qty ?: 1;


            $productPrice = (float)$cartItem->product_price * $quantity;

            $orderItem = new OrderItem();
            $orderItem->product_order_id = $orderId;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->user_id = $userId;
            $orderItem->title = $cartItem->title;
            $orderItem->variations = $cartItem->variations;
            $orderItem->addons = $cartItem->addons;
            $orderItem->variations_price = $cartItem->variations_price;
            $orderItem->addons_price = $cartItem->addons_price;
            $orderItem->product_price = $productPrice;
            $orderItem->total = $productPrice + $cartItem->variations_price + $cartItem->addons_price;
            $orderItem->qty = $quantity;
            $orderItem->image = $product->feature_image;
            $orderItem->created_at = Carbon::now();
            $orderItem->updated_at = Carbon::now();
            $orderItem->save();

        }
    }


    public function saveOrder($request, $shipping, $total, $txnId=NULL, $chargeId=NULL, $gtype = 'online')
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;


        $order = new ProductOrder;

        if ($request->has('same_as_shipping') && $request['same_as_shipping'] == 1) {
            $order->billing_fname = $request['shipping_fname'];
            $order->billing_lname = $request['shipping_lname'];
            $order->billing_email = $request['shipping_email'];
            $order->billing_address = $request['shipping_address'];
            $order->billing_city = $request['shipping_city'];
            $order->billing_country = 'Kuwait';
            $order->billing_number = $request['shipping_number'];
            $order->billing_country_code = '+965';
        } else {
            $order->billing_fname = $request['billing_fname'];
            $order->billing_email = $request['billing_email'];
            $order->billing_number = $request['billing_number'];
            $order->billing_country_code = '+965';

            $order->billing_lname = $request['billing_lname'];
            $order->billing_address = $request['billing_address'];
            $order->billing_city = $request['billing_city'];
        }

        $order->shipping_fname = $request['shipping_fname'];
        $order->shipping_lname = $request['shipping_lname'];
        $order->shipping_email = $request['shipping_email'];
        $order->shipping_address = $request['shipping_address'];
        $order->shipping_city = $request['shipping_city'];
        $order->shipping_country = 'Kuwait';
        $order->shipping_number = $request['shipping_number'];
        $order->shipping_country_code = '+965';
        $order->delivery_date = $request['delivery_date'];

        if ($request->has('shipping_charge')) {
            $order->shipping_method = $shipping->title;

            if (!empty($shipping->free_delivery_amount) && cartTotalMobile() >= $shipping->free_delivery_amount) {
                $order->shipping_charge = 0;
            } else {
                $order->shipping_charge = $shipping->charge;
            }
        }
        $order->order_notes = $request['order_notes'];

        $order->total = round($total, 2);

        $order->serving_method = 'home_delivery';

        if($request['gateway'] == 'offline')
        {
        $order->method = 'Cash On Delivery';
        }else{
        $order->method = 'Knet';
        }
        $order->gateway_type = $request['gateway'];
        $order->currency_code = $be->base_currency_text;
        $order->currency_code_position = $be->base_currency_text_position;
        $order->currency_symbol = $be->base_currency_symbol;
        $order->currency_symbol_position = $be->base_currency_symbol_position;
        $order->tax = tax();
        $discount = $request->discount ? $request->discount : 0;
        $order->coupon = $discount;

        $order['order_number'] = Str::random(4) . '-' . time();
        $order['payment_status'] = "Pending";
        $order['txnid'] = $txnId;
        $order['charge_id'] = $chargeId;
        $order['user_id'] = Auth::check() ? auth()->user()->id : NULL;



        $order->save();

        return $order;

    }
    public function store(Request $request){
        if($this->orderValidation($request)) {
            return $this->orderValidation($request);
        }

        if ($request->has('shipping_charge')) {
            $shipping = ShippingCharge::findOrFail($request->shipping_charge);
            $shippig_charge = $shipping->charge;
        } else {
            $shipping = NULL;
            $shippig_charge = 0;
        }

        if (!empty($shipping) && !empty($shipping->free_delivery_amount) && cartTotalMobile() >= $shipping->free_delivery_amount) {
            $shippig_charge = 0;
        } else {
            $shippig_charge = $shippig_charge;
        }

        $discount = $request->discount ? $request->discount : 0;
        $total = $this->orderTotal($shippig_charge , $discount);

        $txnId = 'txn_' . Str::random(8) . time();
        $chargeId = 'ch_' . Str::random(9) . time();
        $order = $this->saveOrder($request, $shipping, $total, $txnId, $chargeId, 'offline');
        $order_id = $order->id;

        $this->saveOrderItem($order_id);

        auth()->user()->carts()->delete();

        if($order->method == 'Knet')
        {
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

            return response([
                'status' => 'success',
                'url' => $url
            ], 200);
        }
        return response([
            'status' => 'success',
            'message' => 'Order Placed Successfully'
        ], 200);
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
