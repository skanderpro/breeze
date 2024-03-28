<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Http\Controllers\Traits\UserControllerTrait;
use App\Models\Company;
use App\Models\User;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;


class UserController extends Controller
{
    use UserControllerTrait;

    public function showUserList(Request $request)
    {
        try {
            list($users, $search) = $this->userList($request);

            return view('userlist', compact('users', 'search'));
        } catch (AccessDeniedException $e) {
            return Redirect::to('/');
        }
    }

    public function searchUser(Request $search, AccessCheckInterface $accessCheck)
    {
        if (!$accessCheck->check(Permission::USERS_READ_ALL)) {
            return Redirect::to('/');
        } else {
            return view('userlist', compact('merchants', 'search'));
        }
    }

    public function account()
    {
        return view('account');
    }

    public function removeUser($id)
    {
        $this->remove($id);

        return Redirect::to('userlist')->with('message', 'User removed');
    }

    public function disableUser($id)
    {
        $this->updateStatus($id, '1');

        return Redirect::to('userlist')->with('message', 'User disabled');
    }

    public function enableUser($id)
    {
        $this->updateStatus($id, '');

        return Redirect::to('userlist')->with('message', 'User enabled');
    }


    public function edit($id, AccessCheckInterface $accessCheck)
    {


        $companies = Company::all();


        if ($accessCheck->check(Permission::USERS_READ_ALL)) {
            // $users = User::all();
            $user = User::where('id', '=', $id)->firstOrFail();

        } elseif ($accessCheck->check(Permission::USERS_READ_COMPANY)) {


            $user = User::where('id', '=', $id)->where('companyId', '=', Auth::user()->companyId)->firstOrFail();


        } else {

            return Redirect::to('/');

        }


        return view('auth.edit', compact('user', 'companies'));
    }

    public function update($id, Request $request)
    {
        $this->updateUser($id,$request);

        return Redirect::to("/users/$id")
            ->with('message', 'User successfully edited');
    }
}
