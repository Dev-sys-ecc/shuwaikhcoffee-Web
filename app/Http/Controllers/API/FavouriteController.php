<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function getFavourites()
    {
        $user = Auth::user();

        $data = $user->favourites()->join('products', 'favourites.product_id', '=', 'products.id')
            ->select('favourites.id', 'favourites.product_id',  'products.feature_image', 'products.title', 'products.current_price')
            ->get();

        return response([
            'message' => 'success',
            'data' => $data,
        ], 200);
    }
    public function checkFavourite(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return response(['message' => 'Product not found.'], 404);
        }

        $favouriteExists = $product->favourites()->where('user_id', auth()->user()->id)->exists();

        if (!$favouriteExists) {
            Favourite::create([
                'product_id' => $request->product_id,
                'user_id' => auth()->user()->id
            ]);

            return response(['message' => 'Product added to favourites.'], 200);
        }

        $product->favourites()->where('user_id', auth()->user()->id)->delete();

        return response(['message' => 'Product removed from favourites.'], 200);
    }

}
