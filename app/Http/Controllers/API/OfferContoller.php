<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferContoller extends Controller
{
    public function getOffers(Request $request)
    {
      $request->validate([
          'lang' => 'required|in:ar,en',
      ]);

      $languageCode = $request->filled('lang') ? $request->input('lang') : 'ar';

      $language = Language::where('code', $languageCode)->firstOrFail();

      $offers = Offer::where('language_id', $language->id)
          ->where('status' , 1)
          ->where(function ($query) {
            $query->where('end_date', '>', now())
                ->orWhereNull('end_date');
                })
            ->where(function ($query) {
                $query->where('start_date', '<=', now())
                    ->orWhereNull('start_date');
            })
            ->orderByDesc('id')
      ->get(['id' , 'title', 'price'  , 'image' ]);


        return response([
            'message' => 'success',
            'offers' => $offers
        ], 200);
    }
    public function offer_details($id)
    {
        $offer = Offer::where('id', $id)
            ->where(function ($query) {
                $query->where('end_date', '>', now())
                    ->orWhereNull('end_date');
            })
            ->where(function ($query) {
                $query->where('start_date', '<=', now())
                    ->orWhereNull('start_date');
            })
            ->first(['id', 'title', 'price', 'end_date', 'image', 'description']);

        if (!$offer) {
            return response([
                'message' => 'error',
                'error' => 'Offer not found',
            ], 404);
        }

        return response([
            'message' => 'success',
            'data' => $offer,
        ], 200);
    }
}
