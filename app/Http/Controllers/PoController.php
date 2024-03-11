<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PoControllerTrait;
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
    use PoControllerTrait;

    public function export(Request $request)
    {

        // Excel::store(new PoExport, 'public/po_export.xlsx');
        // return Excel::download(new PoExport, 'po_export.xlsx');

        $exportDate = $request->get('exportDate');
        $month = date("m", strtotime($exportDate));

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
        $month = date("m", strtotime($exportDate));

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
        $month = date("m", strtotime($exportDate));

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
        $month = date("m", strtotime($exportDate));

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
        $month = date("m", strtotime($exportDate));

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
        $month = date("m", strtotime($exportDate));

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
        $creatPO = $this->store($request);

        return Redirect::to('po-created')->with('message', $creatPO->id)->with('selectMerchant', $creatPO->selectMerchant)->with('poType', $creatPO->poType);

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
                    ->where('pos.id', 'LIKE', "%$search%")
                    ->orwhere('pos.poType', 'LIKE', "%$search%")
                    ->orwhere('pos.poPurpose', 'LIKE', "%$search%")
                    ->orwhere('pos.poProject', 'LIKE', "%$search%")
                    ->orwhere('pos.poProjectLocation', 'LIKE', "%$search%")
                    ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
                    ->leftJoin('users', 'pos.u_id', '=', 'users.id')
                    ->orWhere('companies.companyName', 'LIKE', "%$search%")
                    ->orWhere('users.name', 'LIKE', "%$search%")
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
                    ->where('pos.id', 'LIKE', "%$search%")
                    ->orwhere('pos.poType', 'LIKE', "%$search%")
                    ->orwhere('pos.poPurpose', 'LIKE', "%$search%")
                    ->orwhere('pos.poProject', 'LIKE', "%$search%")
                    ->orwhere('pos.poProjectLocation', 'LIKE', "%$search%")
                    ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
                    ->leftJoin('users', 'pos.u_id', '=', 'users.id')
                    ->orWhere('companies.companyName', 'LIKE', "%$search%")
                    ->orWhere('users.name', 'LIKE', "%$search%")
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
                    ->where('pos.id', 'LIKE', "%$search%")
                    ->orwhere('pos.poType', 'LIKE', "%$search%")
                    ->orwhere('pos.poPurpose', 'LIKE', "%$search%")
                    ->orwhere('pos.poProject', 'LIKE', "%$search%")
                    ->orwhere('pos.poProjectLocation', 'LIKE', "%$search%")
                    ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
                    ->leftJoin('users', 'pos.u_id', '=', 'users.id')
                    ->orWhere('companies.companyName', 'LIKE', "%$search%")
                    ->orWhere('users.name', 'LIKE', "%$search%")
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

       $data = $this->listPo($request);


        return view('po-list', $data);

    }

    public function showPo($id)
    {

        // $po = Po::where('id','=',$id)->firstOrFail();

        $po = $this->getSingle($id);

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

        $this->updadePo($id, $request);

        return Redirect::to("/po-edit/$id")
            ->with('message', "EM-$id successfully updated");

    }

}
