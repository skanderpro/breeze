<?php

namespace App\Http\Controllers\Traits;

use App\Models\Company;
use App\Models\Merchant;
use App\Models\Po;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait PoControllerTrait
{
    public function store(Request $request)
    {

        if ($request->input('poType') == "alternate") {

            $this->validate($request, [
                'companyId' => 'required',
                'u_id' => 'required',
                'poType' => 'required|max:255',
                'poPurpose' => 'required|max:255',
                'inputMerchant' => 'required',
                'poProjectLocation' => 'required|max:255',
            ]);

        }

        if ($request->input('poType') == "Pre Approved") {

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

        $poAdminCompany = User::select('email')->where('companyId', $request->input('companyId'))->where('accessLevel', '2')->where('emailNotify', '!=', '1')->get();

        $creatPOmechant = Merchant::all()->where('id', $request->input('selectMerchant'))->first();

        $creatPOinputmechant = $request->input('inputMerchant');


        // email function to come, if validation above it met
        Mail::send('emails.po', compact('creatPO', 'creatPOmechant', 'creatPOinputmechant', 'poUser', 'poCompany', 'poAdminCompany'), function ($message) use ($request, $poAdminCompany, $poCompany) {

            if ($_SERVER["REMOTE_ADDR"] == '127.0.0.1') {

                $message->from('webtools@cornellstudios.com', $name = 'Express Merchants | Local');

            } else {

                $message->from('helpdesk@express-merchants.co.uk', $name = 'Express Merchants Helpdesk');

            }

            if ($_SERVER["REMOTE_ADDR"] == '127.0.0.1') {

                $message->to('webtools@cornellstudios.com')->subject('A Purchase Order has been created | Local');

            } else {

                $message->to('helpdesk@express-merchants.co.uk')->subject('A Purchase Order has been created');

            }

            if ($poAdminCompany) {

                foreach ($poAdminCompany as $poAdminComp) {
                    $message->cc($poAdminComp->email)->subject('A Purchase Order has been created');
                }

            }

            if ($poCompany) {

                $message->cc($poCompany->companyContactEmail)->subject('A Purchase Order has been created');

            }

            // $message->bcc( 'webtools@cornellstudios.com' )->subject( 'A Purchase Order has been created' );

        });

        return $creatPO;
    }

    public function getList(Request $request)
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

            if ($dateFrom && $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            }

            if ($date) {
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

            if ($dateFrom && $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            }

            if ($date) {
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

            if ($dateFrom && $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            }

            if ($date) {
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


        $engineer = User::where('id', '=', Auth::user()->id)->first();

        return compact('pos', 'dateTo', 'dateFrom', 'date', 'company_id', 'merchant_id', 'u_id', 'poFinanceStatus', 'poJobStatus', 'poId', 'poPod', 'poProject', 'poLocation', 'poPod', 'users', 'companies', 'merchants', 'engineer', 'adminusr');
    }

    public function getSingle($id)
    {
        return Po::select('pos.*', 'companies.companyName', 'users.name', 'merchants.merchantName')
            ->leftJoin('companies', 'pos.companyId', '=', 'companies.id')
            ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
            ->leftJoin('users', 'pos.u_id', '=', 'users.id')
            ->where('pos.id', '=', $id)->firstOrFail();
    }

    public function updadePo($id, Request $request)
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


        if ($request->hasFile('poPod')) {

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

        return $editPo;
    }
}
