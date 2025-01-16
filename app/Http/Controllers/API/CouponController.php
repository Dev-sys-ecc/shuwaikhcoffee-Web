<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function getCoupons()
    {
        $coupons = Coupon::where(function ($query) {
            $query->where('end_date', '>', now())
                ->orWhereNull('end_date');
        })
            ->where(function ($query) {
                $query->where('start_date', '<=', now())
                    ->orWhereNull('start_date');
            })
            ->orderByDesc('id')
            ->get(['id' , 'code' , 'name' , 'type' , 'value' , 'end_date' , 'minimum_spend']);

        return response([
            'message' => 'success',
            'coupons' => $coupons,
        ], 200);
    }
    public function coupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|numeric',
            'cart_total' => 'required|numeric',
        ]);

        $coupon = Coupon::where('code', $request->coupon);

        if ($coupon->count() == 0) {
            return response()->json(['message' => 'error', 'error' => "Coupon is not valid"]);
        } else {
            $coupon = $coupon->first();
            if ($request->cart_total < $coupon->minimum_spend) {
                return response()->json(['message' => 'error', 'error' => "Cart Total must be minimum " . $coupon->minimum_spend ]);
            }
            $start = Carbon::parse($coupon->start_date);
            $end = Carbon::parse($coupon->end_date);
            $today = Carbon::now();

            if ($today->greaterThanOrEqualTo($start) && $today->lessThan($end)) {
                $value = $coupon->value;
                $type = $coupon->type;

                if ($type == 'fixed') {
                    if ($value > $request->cart_total) {
                        return response()->json(['message' => 'error', 'error' => "Coupon discount is greater than cart total"]);
                    }
                    $couponAmount = $value;
                } else {
                    $couponAmount = ($request->cart_total * $value) / 100;
                }

                return response()->json(['message' => 'success', 'couponAmount' => $couponAmount]);
            } else {
                return response()->json(['message' => 'error', 'error' => "Coupon is not valid"]);
            }
        }
    }

}
