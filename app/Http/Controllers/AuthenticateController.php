<?php

/**
 * Created by PhpStorm.
 * User: ardani
 * Date: 8/4/17
 * Time: 11:18 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

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

        $address = $this->jwt->user()->with(['ward:id,name', 'district:id,name', 'province:id,name'])->first();
        $user = $this->jwt->user()->only('id', 'name', 'total_rating', 'email', 'phone', 'role', 'birth_date');
        $user["address"] = [
            "street_name" => $address->street_name,
            "ward" => $address->ward,
            "district" => $address->district,
            "province" => $address->province,
        ];
        return response()->json([
            'token' => $token,
            'user_info' => $user,
            'token_type' => 'bearer',
            'expires_in' => $this->jwt->factory()->getTTL() * 60,
        ]);
    }
}
