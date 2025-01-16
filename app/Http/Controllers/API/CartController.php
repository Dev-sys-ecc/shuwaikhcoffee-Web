<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'title' => 'required|string',
            'qty' => 'required|integer',
            'variations' => 'nullable|json',
            'addons' => 'nullable|json',
            'variations_price' => 'nullable|numeric',
            'addons_price' => 'nullable|numeric',
            'product_price' => 'required|numeric',
        ]);

        $existingCartItem = Cart::where(['product_id'=> $request->product_id , 'user_id' => auth()->user()->id])->first();

        if ($existingCartItem) {
            return response()->json(['message' => 'Product  already in the cart'], 422);
        }

        $variations_price = $request->has('variations_price') ? $request->variations_price : 0;
        $addons_price = $request->has('addons_price') ? $request->addons_price : 0;

        $cartItem = new Cart([
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'qty' => $request->qty,
            'variations' => $request->variations,
            'addons' => $request->addons,
            'variations_price' => $variations_price,
            'addons_price' => $addons_price,
            'product_price' => $request->product_price,
            'total' => $request->total,
        ]);

        $cartItem->save();

        return response()->json(['message' => 'Item added to cart successfully'], 201);
    }
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $existingCartItem = Cart::where('product_id', $request->product_id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if (!$existingCartItem) {
            return response()->json(['message' => 'Product not found in the cart'], 404);
        }

        $existingCartItem->delete();

        return response()->json(['message' => 'Item removed from cart successfully'], 200);
    }

    public function getCart()
    {
        $cartItems = Cart::where('user_id', auth()->user()->id)
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.*', 'products.feature_image as product_image')
            ->get();

        return response()->json([
            'message' => 'success',
            'cart' => $cartItems,
        ], 200);
    }

}
