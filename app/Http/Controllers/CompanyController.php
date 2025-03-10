<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
  public function addCompany(AccessCheckInterface $accessCheck)
  {
    if (!$accessCheck->check(Permission::COMPANY_MANAGE_ALL)) {
      return Redirect::to("/");
    } else {
      return view("create-company");
    }
  }

  public function createCompany(Request $request)
  {
    $this->validate($request, [
      "companyName" => "required|max:255",
      "companyPhone" => "required|max:12",
      "companyContact" => "required|max:255",
      "companyContactEmail" => "required|email|max:255",
      "companyAddress" => "required|max:255",
    ]);

    Company::create($request->toArray());

    return Redirect::to("company-list")->with(
      "message",
      "Company successfully added"
    );
  }

  public function showCompany(AccessCheckInterface $accessCheck)
  {
    // $companies = Company::all();
    $companies = DB::table("companies")->paginate(25);

    if (!$accessCheck->check(Permission::COMPANY_MANAGE_ALL)) {
      return Redirect::to("/");
    } else {
      return view("company-list", compact("companies"));
    }
  }

  public function detailsCompany($id)
  {
    $companyedit = Company::where("id", "=", $id)->firstOrFail();

    return view("company-edit", compact("companyedit"));
  }

  public function editCompany($id, Request $request)
  {
    $this->validate($request, [
      "companyName" => "required|max:255",
      "companyPhone" => "required|max:12",
      "companyContact" => "required|max:255",
      "companyContactEmail" => "required|email|max:255",
      "companyAddress" => "required|max:255",
    ]);

    $editCompany = Company::findOrFail($id);
    $input = $request->all();

    $editCompany->fill($input)->save();

    return Redirect::to("/company-edit/$id")->with(
      "message",
      "Company successfully edited"
    );
  }

  public function disableCompany($id)
  {
    Company::where("id", $id)->update(["disabled" => "1"]);

    return Redirect::to("company-list")->with("message", "Company disabled");
  }

  public function enableCompany($id)
  {
    Company::where("id", $id)->update(["disabled" => ""]);

    return Redirect::to("company-list")->with("message", "Company enabled");
  }

  public function removeCompany($id)
  {
    $company = Company::find($id);

    $company->delete();

    return Redirect::to("company-list")->with("message", "Company removed");
  }
}
