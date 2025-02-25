<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Po;
use App\Models\PoNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExportReportController extends Controller
{
    public function byCompany(Request $request)
    {
        $qb = Po::query();

        if ($request->has('from')) {
            $qb = $qb->where('created_at', $request->get('from'));
        }

        if ($request->has('to')) {
            $qb = $qb->where('created_at', $request->get('to'));
        }

        if ($request->has('companies')) {
            $qb = $qb->whereIn('companyId', $request->get('companies'));
        }

        $pos = $qb->get();
        $data = [];

        foreach ($pos as $po) {
            $data[] = [
                'id' => $po->id,
                'em_number' => $po->poNumber,
                'contract_name' => $po->contract?->companyName,
                'purpose' => $po->poPurpose,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'agreed_markup' => $po->company?->agreed_markup,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'invoice_number' => $po->poInvoice ?? $po->EMInvoice,
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'materials' => $po->poMaterials,
//                'name' => '',
                'created_by' => $po->createdBy  ?->name,
                'created_at' => $po->created_at,
            ];
        }

        return response()->json($data);
    }

    public function byContract(Request $request)
    {
        $qb = Po::query();

        if ($request->has('from')) {
            $qb = $qb->where('created_at', $request->get('from'));
        }

        if ($request->has('to')) {
            $qb = $qb->where('created_at', $request->get('to'));
        }

        if ($request->has('contracts')) {
            $qb = $qb->whereIn('contract_id', $request->get('contracts'));
        }

        $pos = $qb->get();
        $data = [];

        foreach ($pos as $po) {
            $data[] = [
                'id' => $po->id,
                'em_number' => $po->poNumber,
                'contract_name' => $po->contract?->companyName,
                'purpose' => $po->poPurpose,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'agreed_markup' => $po->company?->agreed_markup,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'invoice_number' => $po->poInvoice ?? $po->EMInvoice,
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'materials' => $po->poMaterials,
//                'name' => '',
                'created_by' => $po->createdBy?->name,
                'created_at' => $po->created_at,
            ];
        }

        return response()->json($data);
    }


    public function byUser(Request $request)
    {
        $qb = Po::query();

        if ($request->has('from')) {
            $qb = $qb->where('created_at', $request->get('from'));
        }

        if ($request->has('to')) {
            $qb = $qb->where('created_at', $request->get('to'));
        }

        if ($request->has('users')) {
            $qb = $qb->whereIn('u_id', $request->get('users'));
        }

        $pos = $qb->get();
        $data = [];

        foreach ($pos as $po) {
            $data[] = [
                'id' => $po->id,
                'em_number' => $po->poNumber,
                'contract_name' => $po->contract?->companyName,
                'purpose' => $po->poPurpose,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'supplier_cost' => $po->poValue,
                'agreed_markup' => $po->company?->agreed_markup,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'invoice_number' => $po->poInvoice ?? $po->EMInvoice,
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'materials' => $po->poMaterials,
//                'name' => '',
                'spend_limit' => $po->user?->getOrderLimitAttribute(),
                'pod_uploaded' => !empty($po->poPod),
                'created_by' => $po->createdBy?->name,
                'status' => $po->status,
                'created_at' => $po->created_at,
            ];
        }

        return response()->json($data);
    }

    public function byCompanyRebate(Request $request)
    {
        $qb = Po::query();

        if ($request->has('from')) {
            $qb = $qb->where('created_at', $request->get('from'));
        }

        if ($request->has('to')) {
            $qb = $qb->where('created_at', $request->get('to'));
        }

        if ($request->has('companies')) {
            $qb = $qb->whereIn('companyId', $request->get('companies'));
        }

        $pos = $qb->get();
        $data = [];

        foreach ($pos as $po) {
            $data[] = [
                'id' => $po->id,
                'em_number' => $po->poNumber,
                'contract_name' => $po->contract?->companyName,
                'purpose' => $po->poPurpose,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'agreed_markup' => $po->company?->agreed_markup,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'agreed_rebate' => $po->company?->agreed_rebate,
                'rebate_amount' => $po->poValue * floatval($po->company?->agreed_rebate),
                'invoice_number' => $po->poInvoice ?? $po->EMInvoice,
            ];
        }

        return response()->json($data);
    }


    public function byContractRebate(Request $request)
    {
        $qb = Po::query();

        if ($request->has('from')) {
            $qb = $qb->where('created_at', $request->get('from'));
        }

        if ($request->has('to')) {
            $qb = $qb->where('created_at', $request->get('to'));
        }

        if ($request->has('contracts')) {
            $qb = $qb->whereIn('contract_id', $request->get('contracts'));
        }

        $pos = $qb->get();
        $data = [];

        foreach ($pos as $po) {
            $data[] = [
                'id' => $po->id,
                'em_number' => $po->poNumber,
                'contract_name' => $po->contract?->companyName,
                'purpose' => $po->poPurpose,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'agreed_markup' => $po->company?->agreed_markup,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'agreed_rebate' => $po->company?->agreed_rebate,
                'rebate_amount' => $po->poValue * floatval($po->company?->agreed_rebate),
                'invoice_number' => $po->poInvoice ?? $po->EMInvoice,
            ];
        }

        return response()->json($data);
    }
}
