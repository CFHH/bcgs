<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class ApiRegisterController extends Controller
{
    protected function create(Request $request)
    {
        $crc = \CRC::crc64($request->input('email'));
        /*
        return User::create([
                'id_crc64' => $crc,
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => bcrypt($request->input('password')),
            ]);
        */
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
            return 'email exists';
        }
        finally
        {
        }
        if ($result == NULL)
            return 'error';
        return 'success';
    }
}
