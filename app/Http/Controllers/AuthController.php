<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:4'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth()->attempt($credentials, false)) {
            $client = new Client(['verify' => false]);
            try {
                $response = $client->post("http://wifi.loc/oauth/token", [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => 2,
                        'client_secret' => "uhnefP8B3kJqqjt6XeXtUl4kKG73aGTLyIgUKocB",
                        'username' => $request->email,
                        'password' => $request->password,
                        'scope' => '*'
                    ]
                ]);
                return json_decode($response->getBody());
            } catch (Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ]);
            }
        } else {
            return response()->json(['errors' => 'password or login xato'], 401);
        }
    }


    public function refreshToken(Request $request)
    {
        $validator = $request->validate( [
            'refresh_token' => 'required|string'
        ]);
        $client = new Client();
        try {
            $response = $client->post("http://wifi.loc/oauth/token", [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $request->refresh_token,
                    'client_id' => 2,
                    'client_secret' => "uhnefP8B3kJqqjt6XeXtUl4kKG73aGTLyIgUKocB",
                    'scope' => '',
                ]
            ]);
            return $response->getBody();
        } catch (Exception $e) {
            return response()->json(['message'=>$e->getMessage()]);
        }
    }
    
  
    public function logOut(Request $request){

        $request->user()->tokens()->delete();
        
        return response([
            'logged out'
        ]);
    }


















}
