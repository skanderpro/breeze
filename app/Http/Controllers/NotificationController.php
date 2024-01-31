<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notification;
use Redirect;
use Illuminate\Support\Facades\Input;
use Auth;
use Validator;
use DB;

class NotificationController extends Controller
{

  public function addNotification()
  {

    if (Auth::user()->accessLevel != '1') {
    return Redirect::to('/');
    } else {
      return view('notification-create');
    }


  }

  public function createNotification(Request $request)
  {

    $this->validate($request, [
        'title' => 'required|max:255',
        'content' => 'required'
        ]);

    Notification::create($request->toArray());

    return Redirect::to('notification-list')->with('message', 'Notification successfully added');

  }

  public function showNotification()
  {

      // $companies = Company::all();
      $notifications = Notification::orderBy('id', 'desc')->paginate(25);

      if (Auth::user()->accessLevel != '1') {
      return Redirect::to('/');
      } else {
        return view('notification-list', compact('notifications'));
      }


  }


  public function detailsNotification($id)
  {

    $notificationedit = Notification::where('id','=',$id)->firstOrFail();


      return view('notification-edit', compact('notificationedit'));

  }

  public function editNotification($id, Request $request)
  {

    $this->validate($request, [
        'title' => 'required|max:255',
        'content' => 'required'
        ]);

    $editNotification = Notification::findOrFail($id);
    $input = $request->all();

    $editNotification->fill($input)->save();

    return Redirect::to("/notification-edit/$id")
    ->with('message', 'Notification successfully edited');

  }

  public function disableCompany($id)
  {

      Company::where('id', $id)
      ->update(['disabled' => '1']);

      return Redirect::to('company-list')->with('message', 'Company disabled');
  }

  public function enableCompany($id)
  {

      Company::where('id', $id)
      ->update(['disabled' => '']);

      return Redirect::to('company-list')->with('message', 'Company enabled');
  }

  public function removeCompany($id)
  {

      $company = Company::find($id);

      $company->delete();

      return Redirect::to('company-list')->with('message', 'Company removed');
  }

}
