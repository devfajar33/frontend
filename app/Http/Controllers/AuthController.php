<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        try
        {
            $client = new Client();
            $guzzleResponse = $client->request('POST', 'http://localhost:5097/api/Account/Login', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            if ($guzzleResponse->getStatusCode() == 200) 
            {
                $response = json_decode($guzzleResponse->getBody(),true);

                Session::put('token', $response['token']);
                alert()->success('Success','Login success !');
                return redirect()->route('employee');
            }
        } 
        catch(\GuzzleHttp\Exception\RequestException $e) {
            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::forget('token');
        alert()->success('Success','Logout success !');
        return redirect('/');
    }
}
