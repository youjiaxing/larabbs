<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }


    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('own', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UserRequest $request, ImageUploadHandler $handler)
    {
        $this->authorize('own', $user);
        $data = $request->all();

        if ($request->has('avatar')) {
            $ret = $handler->save($request->file('avatar'), "avatars", $user->id, 416);
            if ($ret) {
                \Log::info($ret['path']);
                $data['avatar'] = $ret['path'];
            }
        }
        $user->update($data);

        return redirect()->route('users.show', $user->id)->with("success", "修改成功");
    }
}
