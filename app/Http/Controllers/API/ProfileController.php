<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $qrCodeLink = '';

        $userWithOffers = auth()->user()->offers()->exists();

        if ($userWithOffers) {
            $qrCodeLink = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . auth()->user()->username . " phone=" . auth()->user()->number . " offers=" . implode(', ', auth()->user()->offers()->pluck('title')->toArray());
        }

        return response([
            'message' => 'success',
            'user' => $user,
            'qr-code-link' => $qrCodeLink
        ]);
    }



    public function profileupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'old_password' => 'nullable|string|min:8',
            'new_password' => 'nullable|string|min:8|different:old_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()], 422);
        }

        $data = auth()->user();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path('assets/front/img/user/'), $name);
            if ($data->photo != null) {
                if (file_exists(public_path('/assets/front/img/user/' . $data->photo))) {
                    unlink(public_path('/assets/front/img/user/' . $data->photo));
                }
            }
            $data->photo = $name;
        }

        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->old_password, $data->password)) {
                $data->password = Hash::make($request->new_password);
            } else {
                return response()->json(['message' => 'error', 'error' => 'The old password is incorrect.'], 422);
            }
        }

        $data->address = $request->input('address');
        $data->save();

        return response()->json(['status' => 'success', 'message' => 'Profile updated successfully!'], 200);
    }

    public function billingupdate(Request $request)
    {

        $request->validate([
            "billing_fname" => 'required|string|max:255',
            "billing_lname" => 'required|string|max:255',
            "billing_email" => 'required|email|max:255',
            "billing_number" => 'required|numeric',
            "billing_city" => 'required|string|max:255',
            "billing_address" => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $user->update($request->only('billing_fname'  , 'billing_lname' , 'billing_email' , 'billing_number' , 'billing_city' , 'billing_address'));

        return response()->json(['status' => 'success', 'message' => 'Billing Address updated successfully!'], 200);
    }

    public function shippingupdate(Request $request)
    {

        $request->validate([
            "shpping_fname" => 'required|string|max:255',
            "shpping_lname" => 'required|string|max:255',
            "shpping_email" => 'required|email|max:255',
            "shpping_number" => 'required|numeric',
            "shpping_city" => 'required|string|max:255',
            "shpping_address" => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $user->update($request->only('shpping_fname'  , 'shpping_lname' , 'shpping_email' , 'shpping_number' , 'shpping_city' , 'shpping_address'));

        return response()->json(['status' => 'success', 'message' => 'Shipping Address updated successfully!'], 200);
    }

}
