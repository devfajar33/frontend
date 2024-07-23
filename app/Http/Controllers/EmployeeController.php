<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index()
    {
        if(Session::get('token'))
        {
            try
            {
                $param = '0';
                $action = 'insert.employee';

                $client = new \GuzzleHttp\Client();
                $guzzleResponse = $client->get(
                    'http://localhost:5097/api/Employee', [
                    'headers' => [
                        'Content-Type'=>'application/json',
                        'Authorization'=>'Bearer '.Session::get('token')
                    ],
                ]);
                if ($guzzleResponse->getStatusCode() == 200) {
                    $response = json_decode($guzzleResponse->getBody(),true);
                }
                // dd($response);
                return view('employee', compact('response', 'param', 'action'));
            } 
            catch(\GuzzleHttp\Exception\RequestException $e) {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->route('index');
        }
    }

    public function store(Request $request)
    {
        if(Session::get('token'))
        {
            try
            {
                $credentials = Session::get('token');
                
                $client = new \GuzzleHttp\Client();
                $guzzleResponse = $client->post(
                    'http://localhost:5097/api/Employee', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.$credentials,
                    ],
                    'json' => [
                        'name' => $request->nama,
                        'identityNumber' => $request->noktp,
                        'address' => $request->alamat,
                        'created_At'=>Carbon::now(),
                        'updated_At'=>Carbon::now(),
                    ]
                ]);
                if ($guzzleResponse->getStatusCode() == 200) 
                {
                    $response = json_decode($guzzleResponse->getBody(),true);
                }
                alert()->success('Success','Data has been saved');
                return redirect()->route('employee');
            } 
            catch(\GuzzleHttp\Exception\RequestException $e) {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->route('index');
        }
    }

    public function edit($id)
    {
        if(Session::get('token'))
        {
            try
            {
                $param = '1';
                $action = 'update.employee';

                $credentials = Session::get('token');
                $client = new \GuzzleHttp\Client();
                $guzzleResponse = $client->get(
                    'http://localhost:5097/api/Employee', [
                    'headers' => [
                        'Content-Type'=>'application/json',
                        'Authorization'=>'Bearer '.$credentials
                    ],
                ]);
                if ($guzzleResponse->getStatusCode() == 200) {
                    $response = json_decode($guzzleResponse->getBody(),true);
                }

                $client_edit = new \GuzzleHttp\Client();
                $guzzleResponse_edit = $client_edit->get(
                    'http://localhost:5097/api/Employee/'.$id, [
                    'headers' => [
                        'Content-Type'=>'application/json',
                        'Authorization'=>'Bearer '.$credentials
                    ],
                ]);
                if ($guzzleResponse_edit->getStatusCode() == 200) {
                    $response_edit = json_decode($guzzleResponse_edit->getBody(),true);
                }
                return view('employee', compact('response', 'response_edit', 'param', 'action'));
            } 
            catch(\GuzzleHttp\Exception\RequestException $e) {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->route('index');
        }
    }

    public function update(Request $request)
    {
        if(Session::get('token'))
        {
            try
            {
                $credentials = Session::get('token');

                $client = new \GuzzleHttp\Client();
                $guzzleResponse = $client->put(
                    'http://localhost:5097/api/Employee/'.$request->id_hdn, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.$credentials,
                    ],
                    'json' => [
                        'id' => $request->id_hdn,
                        'name' => $request->nama,
                        'identityNumber' => $request->noktp,
                        'address' => $request->alamat,
                        'created_At'=>Carbon::now(),
                        'updated_At'=>Carbon::now(),
                    ]
                ]);
                if ($guzzleResponse->getStatusCode() == 200) 
                {
                    $response = json_decode($guzzleResponse->getBody(),true);
                }
                alert()->success('Success','Data has been saved');
                return redirect()->route('employee');
            } 
            catch(\GuzzleHttp\Exception\RequestException $e) {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->route('index');
        }
    }

    public function delete($id)
    {
        try
        {
            
            $credentials = Session::get('token');
            
            $client = new \GuzzleHttp\Client();
            $guzzleResponse = $client->delete(
                'http://localhost:5097/api/Employee/'.$id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$credentials,
                ],
            ]);
            if ($guzzleResponse->getStatusCode() == 200) {
                $response = json_decode($guzzleResponse->getBody(),true);
            }
            alert()->success('Success','Data has been saved');
            return redirect()->route('employee');
        } 
        catch(\GuzzleHttp\Exception\RequestException $e) {
            return redirect()->back();
        }
    }
}
