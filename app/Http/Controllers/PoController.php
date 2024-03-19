<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Merchant;
use App\Models\Po;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\PoExport;
use App\Exports\PoExportEngineer;
use App\Exports\PoExportSite;
use App\Exports\PoExportTask;
use App\Exports\PoExportMerchant;
use App\Exports\PoExportFinance;
use App\Exports\PoExportNoDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class PoController extends Controller
{

  public function export(Request $request)
  {

      // Excel::store(new PoExport, 'public/po_export.xlsx');
      // return Excel::download(new PoExport, 'po_export.xlsx');

      $exportDate = $request->get('exportDate');
      $month = date("m",strtotime($exportDate));

      $exportDateFrom = $request->get('exportDateFrom');
      $exportDateTo = $request->get('exportDateTo');

      $exportCompany_id = $request->get('exportCompany_id');
      $exportMerchant_id = $request->get('exportMerchant_id');


      // return Excel::download(new PoExport($month), 'po_export.xlsx');

      return (new PoExport($exportDateFrom, $exportDateTo, $exportCompany_id))
      ->download('po_export.xlsx');

  }

  public function exportEngineer(Request $request)
  {

      // Excel::store(new PoExport, 'public/po_export.xlsx');
      // return Excel::download(new PoExport, 'po_export.xlsx');

      $exportDate = $request->get('exportDate');
      $month = date("m",strtotime($exportDate));

      $exportDateFrom = $request->get('exportDateFrom');
      $exportDateTo = $request->get('exportDateTo');

      $exportu_id = $request->get('exportu_id');


      // return Excel::download(new PoExport($month), 'po_export.xlsx');

      return (new PoExportEngineer($exportDateFrom, $exportDateTo, $exportu_id))
      ->download('po_export-engineer.xlsx');

  }

  public function exportSite(Request $request)
  {

      // Excel::store(new PoExport, 'public/po_export.xlsx');
      // return Excel::download(new PoExport, 'po_export.xlsx');

      $exportDate = $request->get('exportDate');
      $month = date("m",strtotime($exportDate));

      $exportDateFrom = $request->get('exportDateFrom');
      $exportDateTo = $request->get('exportDateTo');

      $exportpoProjectLocation = $request->get('exportpoProjectLocation');


      // return Excel::download(new PoExport($month), 'po_export.xlsx');

      return (new PoExportSite($exportDateFrom, $exportDateTo, $exportpoProjectLocation))
      ->download('po_export-site.xlsx');

  }

  public function exportTask(Request $request)
  {

      // Excel::store(new PoExport, 'public/po_export.xlsx');
      // return Excel::download(new PoExport, 'po_export.xlsx');

      $exportDate = $request->get('exportDate');
      $month = date("m",strtotime($exportDate));

      $exportDateFrom = $request->get('exportDateFrom');
      $exportDateTo = $request->get('exportDateTo');

      $exportpoProject = $request->get('exportpoProject');


      // return Excel::download(new PoExport($month), 'po_export.xlsx');

      return (new PoExportTask($exportDateFrom, $exportDateTo, $exportpoProject))
      ->download('po_export-task.xlsx');

  }

  public function exportMerchant(Request $request)
  {

      // Excel::store(new PoExport, 'public/po_export.xlsx');
      // return Excel::download(new PoExport, 'po_export.xlsx');

      $exportDate = $request->get('exportDate');
      $month = date("m",strtotime($exportDate));

      $exportDateFrom = $request->get('exportDateFrom');
      $exportDateTo = $request->get('exportDateTo');

      $exportmerchant_id = $request->get('exportmerchant_id');


      // return Excel::download(new PoExport($month), 'po_export.xlsx');

      return (new PoExportMerchant($exportDateFrom, $exportDateTo, $exportmerchant_id))
      ->download('po_export-merchant.xlsx');

  }

  public function exportFinance(Request $request)
  {

      // Excel::store(new PoExport, 'public/po_export.xlsx');
      // return Excel::download(new PoExport, 'po_export.xlsx');

      $exportDate = $request->get('exportDate');
      $month = date("m",strtotime($exportDate));

      $exportDateFrom = $request->get('exportDateFrom');
      $exportDateTo = $request->get('exportDateTo');

      $exportFinanceStatus = $request->get('poFinanceStatus');
      $exportFinanceCompany = $request->get('poFinanceCompany');


      // return Excel::download(new PoExport($month), 'po_export.xlsx');

      return (new PoExportFinance($exportDateFrom, $exportDateTo, $exportFinanceStatus, $exportFinanceCompany))
      ->download('po_export-finance.xlsx');

  }

  public function exportNoDate()
  {

      // Excel::store(new PoExport, 'public/po_export.xlsx');
      return Excel::download(new PoExportNoDate, 'po_export.xlsx');
  }

  public function addPo(Request $request)
  {
    $companies = Company::all();
    // $users = User::all();
    $merchants = Merchant::all();

    $companyId = $request->get('companyId');

    if (Auth::user()->accessLevel == '1') {

      // if ($companyId) {
        $users = User::select('users.*', 'companies.companyName')
        ->leftJoin('companies', 'users.companyId', '=', 'companies.id')
        ->where('companyId', '=', $companyId)
        ->get();
      // } else {
      //   $users = User::select('users.*', 'companies.companyName')
      //   ->leftJoin('companies', 'users.companyId', '=', 'companies.id')
      //   ->get();
      // }

    } else {

      $users = User::where('companyId', Auth::user()->companyId)
      ->get();

    }

    return view('po-create', compact('merchants', 'companies', 'users'));

  }

  public function createPo(Request $request)
  {
	// dd($request->toArray());
    if ( $request->input('poType') == "alternate" ) {

      $this->validate($request, [
          'companyId' => 'required',
          'u_id' => 'required',
          'poType' => 'required|max:255',
          'poPurpose' => 'required|max:255',
          'inputMerchant' => 'required',
          'poProjectLocation' => 'required|max:255',
          ]);

    }

    if ( $request->input('poType') == "Pre Approved" ) {

      $this->validate($request, [
          'companyId' => 'required',
          'u_id' => 'required',
          'poType' => 'required|max:255',
          'poPurpose' => 'required|max:255',
          'selectMerchant' => 'required',
          'poProjectLocation' => 'required|max:255',
          ]);

    }



    $creatPO = Po::create($request->toArray());

    $poUser = User::all()->where('id', $request->input('u_id'))->first();

    $poCompany = Company::select('companyContactEmail')->where('id', $request->input('companyId'))->first();

    $poAdminCompany = User::select('email')->where('companyId', $request->input('companyId'))->where('accessLevel', '2')->where('emailNotify', '!=',  '1')->get();

    $creatPOmechant = Merchant::all()->where('id', $request->input('selectMerchant'))->first();

    $creatPOinputmechant = $request->input('inputMerchant');


    // email function to come, if validation above it met
    Mail::send( 'emails.po', compact('creatPO', 'creatPOmechant', 'creatPOinputmechant', 'poUser', 'poCompany', 'poAdminCompany'), function( $message ) use ($request, $poAdminCompany, $poCompany)
        {

          if($_SERVER["REMOTE_ADDR"]=='127.0.0.1') {

            $message->from('webtools@cornellstudios.com', $name = 'Express Merchants | Local');

          } else {

            $message->from('helpdesk@express-merchants.co.uk', $name = 'Express Merchants Helpdesk');

          }

          if($_SERVER["REMOTE_ADDR"]=='127.0.0.1') {

            $message->to( 'webtools@cornellstudios.com' )->subject( 'A Purchase Order has been created | Local' );

          } else {

            $message->to( 'helpdesk@express-merchants.co.uk' )->subject( 'A Purchase Order has been created' );

          }

          if ($poAdminCompany) {

            foreach ($poAdminCompany as $poAdminComp) {
              $message->cc( $poAdminComp->email )->subject( 'A Purchase Order has been created' );
            }

          }

          if ($poCompany) {

            $message->cc( $poCompany->companyContactEmail )->subject( 'A Purchase Order has been created' );

          }

          // $message->bcc( 'webtools@cornellstudios.com' )->subject( 'A Purchase Order has been created' );

        });

    return Redirect::to('po-created')->with('message', $creatPO->id )->with('selectMerchant', $creatPO->selectMerchant )->with('poType', $creatPO->poType );

  }

  public function createdPo()
  {

    $selectedMerchantId = session('selectMerchant');

    $selectedMerchant = Merchant::where('id', '=', $selectedMerchantId)->first();

    return view('po-created', compact('selectedMerchant'));

  }

  public function listPo_bkup(Request $request)
  {

    $adminusr = User::where('accessLevel', '2')->where('companyId', Auth::user()->companyId)->first();

    $search = $request->get('search');

    if (Auth::user()->accessLevel == '1') {


      if ($search != "") {
        $pos = Po::select('pos.*', 'companies.companyName', 'users.name')
        ->where('pos.id','LIKE',"%$search%")
        ->orwhere('pos.poType','LIKE',"%$search%")
        ->orwhere('pos.poPurpose','LIKE',"%$search%")
        ->orwhere('pos.poProject','LIKE',"%$search%")
        ->orwhere('pos.poProjectLocation','LIKE',"%$search%")
        ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
        ->leftJoin('users', 'pos.u_id', '=', 'users.id')
        ->orWhere('companies.companyName','LIKE',"%$search%")
        ->orWhere('users.name','LIKE',"%$search%")
        ->orderBy('id', 'desc')
        ->paginate(1000);
      } else {
        $pos = DB::table('pos')
        ->join('companies', 'pos.companyId', '=', 'companies.id')
        ->select('pos.*', 'companies.companyName')
        ->orderBy('id', 'desc')
        ->paginate(15);
      }


      } elseif (Auth::user()->accessLevel == '2') {


        if ($search != "") {
          $pos = Po::select('pos.*', 'companies.companyName', 'users.name')
          ->where('pos.companyId', '=', Auth::user()->companyId)
          ->where('pos.id','LIKE',"%$search%")
          ->orwhere('pos.poType','LIKE',"%$search%")
          ->orwhere('pos.poPurpose','LIKE',"%$search%")
          ->orwhere('pos.poProject','LIKE',"%$search%")
          ->orwhere('pos.poProjectLocation','LIKE',"%$search%")
          ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
          ->leftJoin('users', 'pos.u_id', '=', 'users.id')
          ->orWhere('companies.companyName','LIKE',"%$search%")
          ->orWhere('users.name','LIKE',"%$search%")
          ->orderBy('id', 'desc')
          ->paginate(1000);
        } else {
          $pos = DB::table('pos')
          ->join('companies', 'pos.companyId', '=', 'companies.id')
          ->select('pos.*', 'companies.companyName')
          ->where('companyId', '=', Auth::user()->companyId)
          ->orderBy('id', 'desc')
          ->paginate(15);
          // ->get();
        }

      } else {

        if ($search != "") {
          $pos = Po::select('pos.*', 'companies.companyName', 'users.name')
          ->where('u_id', '=', Auth::user()->id)
          ->where('pos.id','LIKE',"%$search%")
          ->orwhere('pos.poType','LIKE',"%$search%")
          ->orwhere('pos.poPurpose','LIKE',"%$search%")
          ->orwhere('pos.poProject','LIKE',"%$search%")
          ->orwhere('pos.poProjectLocation','LIKE',"%$search%")
          ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
          ->leftJoin('users', 'pos.u_id', '=', 'users.id')
          ->orWhere('companies.companyName','LIKE',"%$search%")
          ->orWhere('users.name','LIKE',"%$search%")
          ->orderBy('id', 'desc')
          ->paginate(1000);
        } else {
          $pos = DB::table('pos')
          ->where('u_id', '=', Auth::user()->id)
          ->orderBy('id', 'desc')
          ->paginate(15);
          // ->get();
        }


      }

      return view('po-list', compact('pos', 'search', 'adminusr'));
  }

  public function listPo(Request $request)
  {

    $adminusr = User::where('accessLevel', '2')->where('companyId', Auth::user()->companyId)->first();

    $merchants = Merchant::all();

        // Sets the parameters from the get request to the variables.
        $u_id = $request->get('u_id');
        $poPod = $request->get('poPod');
        $poId = $request->get('poId');
        $poJobStatus = $request->get('poJobStatus');
        $poFinanceStatus = $request->get('poFinanceStatus');
        $company_id = $request->get('company_id');
        $merchant_id = $request->get('merchant_id');
        $poProject = $request->get('poProject');
        $poLocation = $request->get('poLocation');
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');
        $date = $request->get('date');
        $poPod = $request->get('poPod');

        $query = Po::query();

        // $pos = DB::table('pos')
        // ->join('companies', 'pos.companyId', '=', 'companies.id')
        // ->select('pos.*', 'companies.companyName')
        // ->orderBy('id', 'desc')
        // ->paginate(15);

        $companies = Company::all();

        if (Auth::user()->accessLevel == '1') {


          $users = User::all();


          if ($u_id) {
            $query->where('u_id', '=', $u_id);
          }

          if ($poId) {
            $query->where('id', '=', $poId);
          }

          if($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
          }

          if($date) {
            $query->where('created_at', 'LIKE', "%$date%");
          }

          if ($company_id) {
            $query->where('companyId', '=', $company_id);
          }

          if ($merchant_id) {
            $query->where('selectMerchant', '=', $merchant_id);
          }

          if ($poPod) {
            $query->where('poPod', '=', "");
          }

          if ($poJobStatus) {
            $query->where('poJobStatus', '=', $poJobStatus);
          }

          if ($poFinanceStatus) {
            $query->where('poFinanceStatus', '=', $poFinanceStatus);
          }

          if ($poProject) {
            $query->where('poProject', '=', "$poProject");
          }

          if ($poLocation) {
            $query->where('poProjectLocation', 'LIKE', "%$poLocation%");
          }

        }

        if (Auth::user()->accessLevel == '2') {


          $users = User::where('companyId', Auth::user()->companyId)->get();



          if ($u_id) {
            $query->where('u_id', '=', $u_id);
          }

          if ($poId) {
            $query->where('id', '=', $poId);
          }

          if($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
          }

          if($date) {
            $query->where('created_at', 'LIKE', "%$date%");
          }

          if ($poProject) {
            $query->where('poProject', '=', "$poProject");
          }

          if ($poPod) {
            $query->where('poPod', '=', "");
          }

          if ($poLocation) {
            $query->where('poProjectLocation', 'LIKE', "%$poLocation%");
          }

          $query->where('companyId', '=', Auth::user()->companyId);


        }

        if (Auth::user()->accessLevel == '3') {

          if ($u_id) {
            $query->where('u_id', '=', $u_id);
          }

          if ($poId) {
            $query->where('id', '=', $poId);
          }

          if($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
          }

          if($date) {
            $query->where('created_at', 'LIKE', "%$date%");
          }

          if ($poPod) {
            $query->where('poPod', '=', "");

          }

          if ($poLocation) {
            $query->where('poProjectLocation', 'LIKE', "%$poLocation%");
          }

          $query->where('companyId', '=', Auth::user()->companyId);
          $query->where('u_id', '=', Auth::user()->id);

          // $query->where('poInvoice', '=', "");
          // $query->where('poPod', '=', "");
          // $query->where('poCompanyPo', '=', "");


        }

        $query->orderBy('id', 'desc');

        if ($u_id || $poId || $company_id || $merchant_id || $poProject || $poLocation || $dateFrom || $dateTo || $date) {

          $pos = $query->paginate(10000);

          } else {

            $pos = $query->paginate(50);

          }


          $engineer = User::where('id','=', Auth::user()->id)->first();


          return view('po-list', compact('pos', 'dateTo', 'dateFrom', 'date', 'company_id', 'merchant_id', 'u_id', 'poFinanceStatus', 'poJobStatus', 'poId', 'poPod', 'poProject', 'poLocation', 'poPod', 'users', 'companies', 'merchants', 'engineer', 'adminusr'));

  }

  public function showPo($id)
  {

    // $po = Po::where('id','=',$id)->firstOrFail();

    $po = Po::select('pos.*', 'companies.companyName', 'users.name', 'merchants.merchantName')
    ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
    ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
    ->leftJoin('users', 'pos.u_id', '=', 'users.id')
    ->where('pos.id','=',$id)->firstOrFail();

    if (Auth::user()->accessLevel == '1') {
      return view('po-edit', compact('po'));
    } elseif (Auth::user()->companyId != $po->companyId) {
      return Redirect::to('/po-list')
      ->with('message', "Ah ah ah! You didn't say the magic word!");
    } else {
      return view('po-edit', compact('po'));
    }

  }

  public function editPo($id, Request $request)
  {

    $this->validate($request, [
        'poPod' => 'file|max:6000',
        ]);

    $editPo = Po::findOrFail($id);

    $poPod = $request->get('poPod');

    // $input = \Request::get('poPod');

    $input = $request->all();



    $destinationPath = 'uploads/'; // upload path
    $file = $request->file('poPod');
    // $fileName = $file->getClientOriginalName();

    $filename = $_FILES['poPod']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);


    if ($request->hasFile('poPod'))
    {

      $request->file('poPod')->move($destinationPath, $filename);

      $input['poPod'] = $filename;

      // if ($ext == 'pdf')
      // {
      //   $request->file('poPod')->move($destinationPath, $filename . '.pdf');
      // }
      //
      //
      // if ($ext == 'jpg' || $ext == 'jpeg')
      // {
      //   $request->file('poPod')->move($destinationPath, $filename . '.jpg');
      // }



    }



    $editPo->fill($input)->save();

    return Redirect::to("/po-edit/$id")
    ->with('message', "EM-$id successfully updated");

  }

}
