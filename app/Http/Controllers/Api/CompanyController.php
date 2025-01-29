<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\Filters\Company\CompanyFilter;
use Exception;

class CompanyController extends Controller
{
  public function index(Request $request)
  {
    $qb = Company::query();
    $filter = new CompanyFilter($qb);
    $filter->filterByParentAndDisabled();

    return CompanyResource::collection($qb->get());
  }

  public function getAdminList(Request $request)
  {
    $qb = Company::query();
    $query = $request->input("query");
    $filter = new CompanyFilter($qb);
    $filter->filterBySearch($query);
    return CompanyResource::collection($qb->get());
  }

  public function single(Company $company)
  {
    return new CompanyResource($company);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      "companyName" => "required|max:255",
      "companyPhone" => "required|max:20",
      "companyContact" => "required|max:255",
      "companyContactEmail" => "required|email|max:255",
      "companyAddress" => "required|max:255",
      "url" => "nullable",
      "companyContactPhone" => "nullable",
      "phoneCode" => "nullable",
      "companyContactPhoneCode" => "nullable",
    ]);

    $createdCompany = Company::create($request->toArray());
    $lockout = collect($request->input("lockout"));
    $merchantIds = $lockout->pluck("value")->toArray();
    $createdCompany->lockout()->sync($merchantIds);
    return new CompanyResource($createdCompany);
  }

  public function update(Company $company, Request $request)
  {
    $this->validate($request, [
      "companyName" => "required|max:255",
      "companyPhone" => "required|max:12",
      "companyContact" => "required|max:255",
      "companyContactEmail" => "required|email|max:255",
      "companyAddress" => "required|max:255",

      "url" => "nullable",
      "phoneCode" => "nullable",
      "companyContactPhone" => "nullable",
      "companyContactPhoneCode" => "nullable",
    ]);

    $input = $request->all();
    $lockout = collect($request->input("lockout"));
    $merchantIds = $lockout->pluck("value")->toArray();
    $company->lockout()->sync($merchantIds);
    $company->fill($input)->save();

    return new CompanyResource($company);
  }

  public function toggle(Company $company)
  {
    $company->disabled = (int) $company->disabled ? "" : "1";
    $company->save();

    return new CompanyResource($company);
  }

  public function findByParent($parent_id)
  {
    $companies = Company::where("parent_id", $parent_id)->get();
    return CompanyResource::collection($companies);
  }

  public function lockoutValidate(Company $company, Request $request)
  {
    try {
      $merchantsRequest = $request->get("merchants");
      $merchants = explode(",", $merchantsRequest);
      $lockout = $company->lockout->pluck("id");
      $containsAny = collect($merchants)->some(
        fn($merchant) => $lockout->contains($merchant)
      );
      if ($containsAny) {
        return ["status" => false];
      } else {
        return ["status" => true];
      }
    } catch (Exception $exception) {
      return ["status" => false];
    }
  }
}
