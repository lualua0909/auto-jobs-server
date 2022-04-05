<?php

/**
 * Created by PhpStorm.
 * User: ardani
 * Date: 8/4/17
 * Time: 11:18 AM
 */
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;
use App\Models\Notification;

class AuthenticateController extends Controller
{
    private $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = $this->jwt->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $res = User::where('id', $this->jwt->user()->id)->with(['ward:id,name', 'district:id,name', 'province:id,name'])->first();
        $user = $res->only('id', 'name', 'total_rating', 'email', 'phone', 'role', 'birth_date', 'lat', 'long', 'lat_delta', 'long_delta');
        $user["address"] = [
            "street_name" => $res->street_name,
            "ward" => $res->ward,
            "district" => $res->district,
            "province" => $res->province,
        ];

        if ($user) {
            $notification = new Notification;
            $notification->fill([
                'templated_id' => 3,
                'user_id' => $user->id,
                'param_1' => date('Y-m-d H:i:s')
            ]);
            $notification->save();
        }

        return response()->json([
            'token' => $token,
            'user_info' => $user,
            'token_type' => 'bearer',
            'expires_in' => $this->jwt->factory()->getTTL() * 60,
        ]);
    }
}
