<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class ApiAuthController extends Controller
{
    protected function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:50',
            'name' => 'required|string|max:20|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
            return "参数错误";

        $crc = \CRC::crc64($data['email']);
        $result = NULL;
        try
        {
            $result = User::create([
                'id_crc64' => $crc,
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => bcrypt($data['password']),
            ]);
        }
        catch (QueryException $e)
        {
            return 'email exists ' . $data['email'];
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

    public function logout(Request $request)
    {
        $user = \Auth::guard('api')->user();
        if ($user == NULL)
            return "logout fail: no user";
        $user->token()->delete();
        return response()->json(['message' => '登出成功', 'status_code' => 200, 'data' => null]);
    }

    public function behave(Request $request)
    {
        return "behave";
    }
}
