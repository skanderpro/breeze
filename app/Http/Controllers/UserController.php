<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Company;
use Redirect;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Po;

class UserController extends Controller
{
  public function showUserList(Request $search)
  {

    $search = \Request::get('search');


    if (Auth::user()->accessLevel == '1') {



      if ($search != "") {
        $users = User::select('users.*', 'companies.companyName')

        ->where('name','LIKE',"%$search%")
        ->leftJoin('companies', 'users.companyId', '=', 'companies.id')
        ->orwhere('companyName','LIKE',"%$search%")
        ->orwhere('email','LIKE',"%$search%")
        ->orderBy('name', 'asc')
        ->paginate(1000);


      } else {
        // $users = User::all();
        $users = DB::table('users')->paginate(25);
      }


    } elseif (Auth::user()->accessLevel == '2') {


      if ($search != "") {
        $users = DB::table('users')
        ->where('companyId','=', Auth::user()->companyId)
        ->where('name','LIKE',"%$search%")
        ->orwhere('email','LIKE',"%$search%")
        ->orderBy('name', 'asc')
        ->orderBy('name', 'asc')
        ->paginate(1000);
      } else {
        // show users that have the same companyID as loggedin user
        $users = User::where('companyId','=', Auth::user()->companyId)->paginate(25);
      }





    } else {
      return Redirect::to('/');
    }
    // return view('userlist', compact('users', 'compName', 'search'));
      return view('userlist', compact('users', 'search'));
  }


  public function searchUser(Request $search)
  {





      // Merchant::all()->paginate(25);

      if (Auth::user()->accessLevel != '1') {
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

      $user = User::find($id);

      $user->delete();

      return Redirect::to('userlist')->with('message', 'User removed');
  }

  public function disableUser($id)
  {

      User::where('id', $id)
      ->update(['disabled' => '1']);

      return Redirect::to('userlist')->with('message', 'User disabled');
  }

  public function enableUser($id)
  {

      User::where('id', $id)
      ->update(['disabled' => '']);

      return Redirect::to('userlist')->with('message', 'User enabled');
  }



  public function edit($id)
    {


      $companies = Company::all();


        if (Auth::user()->accessLevel == '1') {
          // $users = User::all();
          $user = User::where('id','=',$id)->firstOrFail();

        } elseif (Auth::user()->accessLevel == '2') {


          $user = User::where('id','=',$id)->where('companyId','=', Auth::user()->companyId)->firstOrFail();


        } else {

          return Redirect::to('/');

        }


        return view('auth.edit', compact('user', 'companies'));
    }

  public function update($id, Request $request)
  {

      $this->validate(request(), [
          'name' => 'required',
          'email' => 'required|email',
          // 'password' => 'required|min:6|confirmed'
      ]);

      $editUser = User::findOrFail($id);

      $newPassword = $request->get('password');

      if(empty($newPassword)){
        $input = $request->except('password');
      } else {

        $request['password'] = Hash::make($request['password']);
        $input = $request->all();

      }



      $editUser->fill($input)->save();

      return Redirect::to("/users/$id")
      ->with('message', 'User successfully edited');
  }



}
