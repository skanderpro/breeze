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
        $query = $request->input('query');
        if (!empty($query)) {
            $qb = $qb->where('companyName', 'like', "%{$query}%");
        }

        return CompanyResource::collection($qb->paginate());
    }

    public function single(Company $company)
    {
        return new CompanyResource($company);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'companyName' => 'required|max:255',
            'companyPhone' => 'required|max:12',
            'companyContact' => 'required|max:255',
            'companyContactEmail' => 'required|email|max:255',
            'companyAddress' => 'required|max:255'
        ]);

        $createdCompany = Company::create($request->toArray());

        return new CompanyResource($createdCompany);
    }

    public function update(Company $company, Request $request)
    {
        $this->validate($request, [
            'companyName' => 'required|max:255',
            'companyPhone' => 'required|max:12',
            'companyContact' => 'required|max:255',
            'companyContactEmail' => 'required|email|max:255',
            'companyAddress' => 'required|max:255'
        ]);

        $input = $request->all();

        $company->fill($input)->save();

        return new CompanyResource($company);
    }
}
