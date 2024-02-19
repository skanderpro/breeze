<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::query()->whereNot('disabled', '1')->paginate();

        return CompanyResource::collection($companies);
    }

    public function single(Company $company)
    {
        return new CompanyResource($company);
    }
}
