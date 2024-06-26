<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\Company;
use App\Models\Notification;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class NotificationController extends Controller
{

  public function addNotification(AccessCheckInterface $accessCheck)
  {

    if (!$accessCheck->check(Permission::NOTIFICATION_MANAGE_ALL)) {
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

  public function showNotification(AccessCheckInterface $accessCheck)
  {

      // $companies = Company::all();
      $notifications = Notification::orderBy('id', 'desc')->paginate(25);

      if (!$accessCheck->check(Permission::NOTIFICATION_MANAGE_ALL)) {
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
