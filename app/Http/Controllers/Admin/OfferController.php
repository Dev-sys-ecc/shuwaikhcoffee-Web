<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product;
use Purifier;
use Validator;
use Session;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['offers'] = Offer::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;

        return view('admin.offers.index', $data);
    }


    public function create(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        return view('admin.offers.create');
    }

    public function FeatureCheck(Request $request)
    {
        $id = $request->offer_id;
        $value = $request->status;

        $offer = Offer::findOrFail($id);
        $offer->status = $value;
        $offer->save();

        Session::flash('success', 'Offer updated successfully!');
        return back();
    }
    public function store(Request $request)
    {
        $img = $request->file('feature_image');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:255',
            'price' => 'required',
            'description' => 'required',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'feature_image' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $messages = [
            'language_id.required' => 'The language field is required',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        if ($request->hasFile('feature_image')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('feature_image')->move(public_path('assets/front/img/offer/featured/'), $filename);
            $in['image'] = $filename;
        }

        $in['title'] = $request->title;
        $in['language_id'] = $request->language_id;
        $in['start_date'] = $request->start_date;
        $in['end_date'] = $request->end_date;
        $in['price'] = $request->price;
        $in['description'] = Purifier::clean($request->description);
        $in['status'] = $request->status;
        $offer = Offer::create($in);

        Session::flash('success', 'Offer added successfully!');
        return "success";
    }


    public function edit(Request $request, $id)
    {
        $lang = Language::where('code', $request->language)->first();
        $data['data'] = Offer::findOrFail($id);
        return view('admin.offers.edit', $data);
    }


    public function update(Request $request)
    {
        $img = $request->file('feature_image');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'title' => 'required|max:255',
            'price' => 'required',
            'description' => 'required',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'feature_image' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];



        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $offer = Offer::findOrFail($request->offer_id);

        if ($request->hasFile('feature_image')) {
            @unlink(public_path('assets/front/img/offer/featured/' . $offer->image));
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('feature_image')->move(public_path('assets/front/img/offer/featured/'), $filename);
            $in['image'] = $filename;
        }

        $in['title'] = $request->title;
        $in['start_date'] = $request->start_date;
        $in['end_date'] = $request->end_date;
        $in['price'] = $request->price;
        $in['description'] = Purifier::clean($request->description);
        $in['status'] = $request->status;
        $offer = $offer->fill($in)->save();

        Session::flash('success', 'Offer updated successfully!');
        return "success";
    }


    public function delete(Request $request)
    {

        $offer = Offer::findOrFail($request->offer_id);

        @unlink(public_path('assets/front/img/offer/featured/' . $offer->image));
        $offer->delete();

        Session::flash('success', 'Offer deleted successfully');
        return back();
    }
    public function unsubscribe( $id,$user_id)
    {
        $user = User::find($user_id);

        $offer = $user->offers()->find($id);

        if ($offer) {
            $offer->delete();
            Session::flash('success', 'تم إلغاء الاشتراك بنجاح.');
            return back();
        }

        return redirect()->back()->with('error', 'لم يتم العثور على العرض.');
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $offer = Offer::findOrFail($id);
            @unlink(public_path('assets/front/img/offer/featured/' . $offer->image));
            $offer->delete();
        }

        Session::flash('success', 'Offer deleted successfully!');
        return "success";
    }


    public function SpecialCheck(Request $request)
    {
        $id = $request->product_id;
        $value = $request->special;

        $offer = Product::findOrFail($id);
        $offer->is_special = $value;
        $offer->save();

        Session::flash('success', 'Product updated successfully!');
        return back();
    }
}
