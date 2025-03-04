<?php

namespace App\Http\Controllers\Api;

use App\Exports\PosExternalExport;
use App\Http\Controllers\Controller;
use App\Models\Po;
use App\Models\PoNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportReportController extends Controller
{
    protected function exportResponse($data)
    {
        $fileName = now()->format('y/m') . '/export-' . now()->format('y-m-d-m-Y-H-i-s') . '.csv';

        Excel::store(
            new PosExternalExport($data),
            $fileName,
            'public',
            \Maatwebsite\Excel\Excel::CSV
        );

        return response()->json([
            'url' => Storage::disk('public')->url($fileName),
        ]);
    }

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

        return $this->exportResponse($data);
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

        return $this->exportResponse($data);
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

        return $this->exportResponse($data);
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

        return $this->exportResponse($data);
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

        return $this->exportResponse($data);
    }

    public function companyCompliensReport(Request $request)
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
                'supplier_cost' => $po->poValue,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'materials_brief' => $po->poMaterials,
                'name' => '',
                'spend_limit' => $po->user?->getOrderLimitAttribute(),
                'pod_uploaded' => !empty($po->poPod),
                'agreed_rebate' => $po->company?->agreed_rebate,
                'created_by' => $po->createdBy?->name,
                'status' => $po->status,
                'created_at' => $po->created_at,
            ];
        }

        return $this->exportResponse($data);
    }

    public function contractCompliensReport(Request $request)
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
                'supplier_cost' => $po->poValue,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'materials_brief' => $po->poMaterials,
                'name' => '',
                'spend_limit' => $po->user?->getOrderLimitAttribute(),
                'pod_uploaded' => !empty($po->poPod),
                'agreed_rebate' => $po->company?->agreed_rebate,
                'created_by' => $po->createdBy?->name,
                'status' => $po->status,
                'created_at' => $po->created_at,
            ];
        }

        return $this->exportResponse($data);
    }

    public function userCompliensReport(Request $request)
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
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'materials_brief' => $po->poMaterials,
                'name' => '',
                'spend_limit' => $po->user?->getOrderLimitAttribute(),
                'pod_uploaded' => !empty($po->poPod),
                'agreed_rebate' => $po->company?->agreed_rebate,
                'created_by' => $po->createdBy?->name,
                'status' => $po->status,
                'created_at' => $po->created_at,
            ];
        }

        return $this->exportResponse($data);
    }

    public function supplierTypeReport(Request $request)
    {
        $qb = Po::query();

        if ($request->has('from')) {
            $qb = $qb->where('created_at', $request->get('from'));
        }

        if ($request->has('to')) {
            $qb = $qb->where('created_at', $request->get('to'));
        }

        if ($request->has('merchants')) {
            $qb = $qb->whereIn('selectMerchant', $request->get('merchants'));
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
                'invoice_number' => $po->poInvoice,
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'materials_brief' => $po->poMaterials,
                'name' => '',
                'created_by' => $po->createdBy?->name,
                'created_at' => $po->created_at,
            ];
        }

        return $this->exportResponse($data);
    }

    public function companyStatusReport(Request $request)
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
                'status' => $po->status,
                'pod_uploaded' => !empty($po->poPod),
                'company_name' => $po->company?->companyName,
                'contract_name' => $po->contract?->companyName,
                'user_name' => "{$po->user?->name} ({$po->user?->accessLevel})",
                'created_by' => "{$po->createdBy?->name} ({$po->createdBy?->accessLevel})",
                'purpose' => $po->poPurpose,
                'project' => $po->poProject,
                'project_location' => $po->poProjectLocation,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'po_type' => $po->poType,
                'alternative_supplier_name' => $po->alt_merchant_name,
                'alt_supplier_contact' => $po->alt_merchant_contact,
                'alt_supplier_email' => $po->alt_merchant_email,
                'supplier_cost' => $po->poValue,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'invoice_number' => $po->poInvoice,
                'materials_brief' => $po->poMaterials,
                'po_cancelled' => $po->poCancelled ? 'yes' : 'no',
                'cancelled_by' => $po->poCancelledBy,
                'reason' => '',
                'location' => $po->poProjectLocation,
                'project_number' => $po->poProject,
                'name' => '',
                'created_at' => $po->created_at,
            ];
        }

        return $this->exportResponse($data);
    }

    public function contractStatusReport(Request $request)
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
                'status' => $po->status,
                'pod_uploaded' => !empty($po->poPod),
                'company_name' => $po->company?->companyName,
                'contract_name' => $po->contract?->companyName,
                'user_name' => "{$po->user?->name} ({$po->user?->accessLevel})",
                'created_by' => "{$po->createdBy?->name} ({$po->createdBy?->accessLevel})",
                'purpose' => $po->poPurpose,
                'project' => $po->poProject,
                'project_location' => $po->poProjectLocation,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'po_type' => $po->poType,
                'alternative_supplier_name' => $po->alt_merchant_name,
                'alt_supplier_contact' => $po->alt_merchant_contact,
                'alt_supplier_email' => $po->alt_merchant_email,
                'supplier_cost' => $po->poValue,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'invoice_number' => $po->poInvoice,
                'materials_brief' => $po->poMaterials,
                'po_cancelled' => $po->poCancelled ? 'yes' : 'no',
                'cancelled_by' => $po->poCancelledBy,
                'reason' => '',
            ];
        }

        return $this->exportResponse($data);
    }

    public function userStatusReport(Request $request)
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
                'status' => $po->status,
                'pod_uploaded' => !empty($po->poPod),
                'company_name' => $po->company?->companyName,
                'contract_name' => $po->contract?->companyName,
                'user_name' => "{$po->user?->name} ({$po->user?->accessLevel})",
                'created_by' => "{$po->createdBy?->name} ({$po->createdBy?->accessLevel})",
                'purpose' => $po->poPurpose,
                'project' => $po->poProject,
                'project_location' => $po->poProjectLocation,
                'supplier_name' => $po->merchant ? $po->merchant->name : $po->alt_merchant_name,
                'po_type' => $po->poType,
                'alternative_supplier_name' => $po->alt_merchant_name,
                'alt_supplier_contact' => $po->alt_merchant_contact,
                'alt_supplier_email' => $po->alt_merchant_email,
                'supplier_cost' => $po->poValue,
                'actual_supplier_cost' => $po->actual_value,
                'billable_value' => $po->billable_value_final,
                'invoice_number' => $po->poInvoice,
                'materials_brief' => $po->poMaterials,
                'po_cancelled' => $po->poCancelled ? 'yes' : 'no',
                'cancelled_by' => $po->poCancelledBy,
                'reason' => '',
            ];
        }

        return $this->exportResponse($data);
    }
}
