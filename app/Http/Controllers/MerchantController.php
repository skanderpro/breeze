<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Exports\MerchantExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;


class MerchantController extends Controller
{

  public function addMerchant()
  {

    if (Auth::user()->accessLevel != '1') {
    return Redirect::to('/');
    } else {
      return view('merchant-create');
    }


  }

  public function createMerchant(Request $request)
  {

    $payload = $this->validate($request, [
        'merchantName' => 'required|max:255',
        'merchantId' => 'required|max:255',
        'merchantAddress1' => 'required|max:255',
        'merchantAddress2' => 'required|max:255',
        'merchantCounty' => 'required|max:255',
        'merchantPostcode' => 'required|max:10',
        'merchantPhone' => 'required|max:22',
        'merchantEmail' => 'required|max:255',

        'lng' => 'required|max:12',
        'lat' => 'required|max:12',
        ]);

    $payload['green_supplier'] = $request->input('green_supplier', false);

    Merchant::create($payload);

    return Redirect::to('merchant-list')->with('message', 'Merchant successfully added');

  }

  public function findMerchant()
  {

    Excel::store(new MerchantExport, 'public/em.csv');

    // return view('merchant-find', compact('results', 'content'));
    return view('merchant-find');
    // return view('merchant-find');



  }

  public function resultsMerchant()
  {

    return view('merchant-find');

  }

  public function showMerchant(Request $request)
  {

      $search = $request->get('search');


          if ($search != "") {
            $merchants = DB::table('merchants')
            ->where('merchantName','LIKE',"%$search%")
            ->orwhere('merchantId','LIKE',"%$search%")
            ->orwhere('merchantAddress1','LIKE',"%$search%")
            ->orwhere('merchantAddress2','LIKE',"%$search%")
            ->orwhere('merchantPostcode','LIKE',"%$search%")
            ->orwhere('merchantEmail','LIKE',"%$search%")
            ->orderBy('merchantName', 'asc')
            ->paginate(1000);
          } else {
            $merchants = DB::table('merchants')->paginate(25);
          }



      // Merchant::all()->paginate(25);

      if (Auth::user()->accessLevel != '1') {
        return Redirect::to('/');
      } else {
        return view('merchant-list', compact('merchants', 'search'));
      }


  }

  public function detailsMerchant($id)
  {

    $merchants = Merchant::where('id','=',$id)->firstOrFail();


      return view('merchant-edit', compact('merchants'));

  }

  public function editMerchant($id, Request $request)
  {

    $this->validate($request, [
        'merchantName' => 'required|max:255',
        'merchantId' => 'required|max:255',
        'merchantAddress1' => 'required|max:255',
        'merchantAddress2' => 'required|max:255',
        'merchantCounty' => 'required|max:255',
        'merchantPostcode' => 'required|max:10',
        'merchantPhone' => 'required|max:22',
        'merchantEmail' => 'required|max:255',
        'lng' => 'required|max:12',
        'lat' => 'required|max:12',
        ]);

    $editMerchant = Merchant::findOrFail($id);
      $input = $request->all();
      $input['green_supplier'] = $request->input('green_supplier', false);

      $editMerchant->fill($input)->save();

    return Redirect::to("/merchant-edit/$id")
    ->with('message', 'Merchant successfully edited');

  }

  public function removeMerchant($id)
  {

      $merchants = Merchant::find($id);

      $merchants->delete();

      return Redirect::to('merchant-list')->with('message', 'Merchant removed');
  }

}
