<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PoControllerTrait;
use App\Http\Resources\PoResource;
use Illuminate\Http\Request;

class PoController extends Controller
{
    use PoControllerTrait;

    public function storePo(Request $request)
    {
        $createdPo = $this->store($request);

        return PoResource::make($createdPo);
    }

    public function index(Request $request)
    {
        $data = $this->getList($request);

        return PoResource::collection($data['pos']);
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
	
	public function cancel($id)
	{
		$po = $this->cancelPo($id);

        return PoResource::make($po);
	}
}
