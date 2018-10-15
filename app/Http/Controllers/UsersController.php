<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $userRequest, User $user)
    {
        $user->update($userRequest->all());
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }

}
