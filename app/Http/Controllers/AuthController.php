<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'clientid'    => 'required',
            'clientkey' => 'required',
        ]);

        try {
            $req_creds = $request->only('clientid', 'clientkey');
            $creds = [ 'clientid' => $req_creds['clientid'], 'password' => $req_creds['clientkey'] ];

            if (! $token = $this->auth->attempt($creds)) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], $e->getStatusCode());
        }

        return response()->json(compact('token'));
    }
}