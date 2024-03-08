<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

trait UserControllerTrait
{
    public function userList(Request $request)
    {
        $accessLevel = Auth::user()->accessLevel;
        if (!in_array($accessLevel, ['1', '2'])) {
            throw new AccessDeniedException('');
        }


        $search = $request->get('search');

        $query = User::query();
        switch ($accessLevel) {
            case '1':
                if (!empty($search)) {
                    $query = $query->select('users.*', 'companies.companyName')
                        ->where('name','LIKE',"%$search%")
                        ->leftJoin('companies', 'users.companyId', '=', 'companies.id')
                        ->orwhere('companyName','LIKE',"%$search%")
                        ->orwhere('email','LIKE',"%$search%");
                }
                break;
            case '2':
                $query = $query->where('companyId','=', Auth::user()->companyId);
                if (!empty($search)) {
                    $query = $query->where('name','LIKE',"%$search%")
                        ->orwhere('email','LIKE',"%$search%");
                }
                break;
        }

        return [
            $query->orderBy('name', 'asc')
            ->paginate( empty($search) ? 25 : 1000),
            $search,
        ];
    }

    public function remove($id)
    {
        User::destroy($id);
    }

    public function updateStatus($id, $status)
    {
        User::where('id', $id)
            ->update(['disabled' => $status]);

        return User::find($id);
    }

    public function updateUser($id, Request $request)
    {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // 'password' => 'required|min:6|confirmed'
        ]);

        $editUser = User::findOrFail($id);

        $newPassword = $request->get('password');

        if (!empty($newPassword)) {
            $input['password'] = Hash::make($request['password']);
        }


        $editUser->fill($input);
        $editUser->save();

        return $editUser;
    }
}
