<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ApiAuthController extends Controller
{
    //use  AuthenticatesUsers;

    protected function register(Request $request)
    {
        $crc = \CRC::crc64($request->input('email'));
        $result = NULL;
        try
        {
            $result = User::create([
                'id_crc64' => $crc,
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => bcrypt($request->input('password')),
            ]);
        }
        catch (QueryException $e)
        {
            return 'email exists ' . $request->input('email');
        }
        finally
        {
        }
        if ($result == NULL)
            return 'error';
        return 'success';
    }

    public function login(Request $request)
    {
        $crc = \CRC::crc64($request->input('email'));

        $request->request->add([
            'grant_type' => env("PASSPORT_GRANT_TYPE"),
            'client_id' => env("PASSPORT_CLIENT_ID"),
            'client_secret' => env("PASSPORT_CLIENT_SECRET"),
            'username' => $crc,
            'password' => $request->input('password'),
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);

        return $response;
    }

    public function behave(Request $request)
    {
        return "behave";
    }
}
