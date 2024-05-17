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
}
