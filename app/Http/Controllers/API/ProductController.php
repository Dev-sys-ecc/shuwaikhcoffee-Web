<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Language;
use App\Models\Offer;
use App\Models\Pcategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function items(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:ar,en',
        ]);

        $languageCode = $request->filled('lang') ? $request->input('lang') : 'ar';

        $language = Language::where('code', $languageCode)->firstOrFail();

        $categories = Pcategory::where('status', 1)
            ->where('language_id', $language->id)
            ->orderByDesc('id')
            ->get(['id' , 'slug' , 'name' , 'image']);

        $products = Product::where(['status' => 1 , 'language_id' => $language->id ])->get(['id', 'title', 'slug', 'category_id' ,'feature_image', 'current_price', 'previous_price', 'addons', 'variations']);

        return response([
            'message' => 'success',
            'categories' => $categories,
            'products' => $products
        ], 200);
    }
    public function show($id)
    {

        $data = [];
            $product = Product::with(['category', 'product_images'])
                ->where(['id' => $id, 'status' => 1])
                ->orderBy('created_at', 'asc')
                ->first();

        if ($product) {
            $product->load('product_images');
            $data = [
                'product' => [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'previous_price' => $product->previous_price,
                    'current_price' => $product->current_price,
                    'summary' => $product->summary,
                    'description' => $product->description,
                    'feature_image' => $product->feature_image,
                    'variations' => $product->variations,
                    'addons' => $product->addons,
                    'category' => $product->category ? $product->category->name : null,
                    'product_images' => $product->product_images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'product_id' => $image->product_id,
                            'image' => $image->image,
                        ];
                    }),
                ],
            ];
        }
        else {
                return response([
                    'message' => 'error',
                ], 404);
            }

        return response([
            'message' => 'success',
            'data' => $data,
        ], 200);
    }
}
