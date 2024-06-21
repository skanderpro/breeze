<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PoControllerTrait;
use App\Http\Resources\PoResource;
use App\Models\Po;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PoRequestController extends Controller
{
    use PoControllerTrait;

    public function __construct(AccessCheckInterface $accessCheckService)
    {
        $this->accessCheckService = $accessCheckService;
    }

    protected function groupRequests($poRequests)
    {
        return PoResource::collection($poRequests)->collection->groupBy('poNumber');
    }

    public function storePo(Request $request)
    {
        $createdPo = $this->storeRequests($request);

        return $this->groupRequests($createdPo);
    }

    public function getCounts()
    {
        return response()->json([
            'total' => Po::getRequestCount(),
            'admin_approved' => Po::getApprovedRequestsCount(),
        ]);
    }

    public function getSingleCounts($number)
    {
        return response()->json([
            'total' => Po::getRequestCount($number),
            'admin_approved' => Po::getApprovedRequestsCount($number),
        ]);
    }

    public function uploadRequestFile($poNumber, Request $request)
    {
        $file = $request->file('file');
        if (!$file) {
            return response()->json([
                'error' => 'File is required',
            ]);
        }

        $path = $file->store('files', 'public');

        Po::updateRequests($poNumber, [
            'request_file' => $path,
        ]);

        return $this->groupRequests(Po::getRequestsByNumber($poNumber));
    }

    public function index(Request $request)
    {
		$input = $request->all();
		$user = Auth::user();
        $data = $this->getRequestList4Role($user, $input);

        return $this->groupRequests($data);
    }

    public function approve($id)
    {
        $po = $this->getSingle($id);

        $number = $po->poNumber;

        $po->is_request = 0;
        $po->poNumber = "EM-{$po->id}";
        $po->save();

        Po::query()
        ->where('poNumber', $number)
        ->delete();

        return PoResource::make($po);
    }

    public function show($id)
    {
        $po = $this->getSingle($id);

        return PoResource::make($po);
    }

    public function update($id, Request $request)
    {
        $po = $this->updadePo($id, $request);

        return PoResource::make($po);
    }

    public function setStatus(Po $po, Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $po->status = $request->input('status');
        $po->save();

        return PoResource::make($po);
    }

	public function cancel($id, Request $request)
	{
		$input = $request->all();

		$po = $this->cancelPo($id, $input['status']);

        return PoResource::make($po);
	}
	
	public function getByNumber($number){
		$pos = $this->getRequestsByNumber($number);
		return PoResource::collection($pos);
	}
}
