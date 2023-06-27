<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function initiators (){
        $result = UsersResource::collection(User::get()->where('role','=','1'));
        return $result;
    }

    public function employees (){
        $result = UsersResource::collection(User::get()->where('role','=','5'));
        return $result;
    }

    public function create(Request $request)
    {
        $request->password = Hash::make($request->password);
        $p = new User();
        $p->email = $request->email;
        $p->password = $request->password;
        $p->role = 1;
        $p->name = $request->name;

        $p->save();
    }
}
