<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Validation failed. Please check the input.',
                'errors' => $validator->errors()
            ], 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();

        if ($user->status == 0) {
            auth()->logout();
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'number'    => 'required|unique:users|regex:/^(\+)?[0-9]+$/',
            'password' => 'required|confirmed',
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Validation failed. Please check the input.',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password) , 'status' => 1]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile() {
        return response()->json(auth()->user());
    }

    public function unactive()
    {
        $user = auth()->user();

        $user->status = 0;
        $user->save();

        auth()->logout();
        return response()->json(['message' => 'Account Banned']);
    }
    public function authUserViaProvider(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'photo' => 'required|string|max:255',
            'provider_id' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
        ]);

        $email = $validatedData['email'];

        $user = User::where('email', $email)->first();

        if (empty($user)) {
            $user = new User;
            $user->email = $email;
            $user->username = $validatedData['username'];
            $user->photo = $validatedData['photo'];
            $user->provider_id = $validatedData['provider_id'];
            $user->provider = $validatedData['provider'];
            $user->status = 1;
            $user->email_verified = 'Yes';
            $user->save();
        }

        if ($user->status == 0) {
            return $this->logout();
        }

        $token = auth()->login($user);

        return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
