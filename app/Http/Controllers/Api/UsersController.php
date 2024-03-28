<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{

    public function store(Request $request)
    { 

        if(empty($request->except(['_token']))){
            return response()->json(['Verique os dados informados.'], 400);
        }

        $data = $request->except(['_token']);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if (!Auth::attempt($request->only(['email', 'password'])))
        {
            return response()->json('Erro ao realizar Autenticação', 401);
        }

        $token = Auth::user();
        $token = $token->createToken('token');

        return response()->json(['user'=> $user, 'token'=>$token->plainTextToken], 201);
    }
    
}
