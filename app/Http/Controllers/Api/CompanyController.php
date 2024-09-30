<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
  public function index(Request $request)
  {
    $qb = Company::query();
    $query = $request->input("query");
    if (!empty($query)) {
      $qb = $qb->where("companyName", "like", "%{$query}%");
      $qb = $qb->orWhere("companyContactEmail", "like", "%{$query}%");
      $qb = $qb->orWhere("companyAddress", "like", "%{$query}%");
    }

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
      'url' => 'nullable',
      'companyContactPhone' => 'nullable',
    ]);

    $createdCompany = Company::create($request->toArray());

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
      'url' => 'nullable',
      'companyContactPhone' => 'nullable',
    ]);

    $input = $request->all();

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
}
