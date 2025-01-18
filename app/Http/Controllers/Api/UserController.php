<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'     => 'required',
            'password'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create post
        $user = User::create([
            'name'     => $request->name,
            'email'     => $request->email,
            'password'   => $request->password,
        ]);

        //return response
        return new UserResource(true, 'Registrasi Berhasil!', $user);
    }
}
