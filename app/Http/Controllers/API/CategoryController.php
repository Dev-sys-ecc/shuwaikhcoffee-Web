<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Pcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
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


        return response([
            'message' => 'success',
            'categories' => $categories,
        ], 200);

    }
}
