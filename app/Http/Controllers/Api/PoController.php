<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PoControllerTrait;
use App\Http\Resources\PoResource;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PoController extends Controller
{
    use PoControllerTrait;

    public function __construct(AccessCheckInterface $accessCheckService)
    {
        $this->accessCheckService = $accessCheckService;
    }


    public function storePo(Request $request)
    {
        $createdPo = $this->store($request);

        return PoResource::make($createdPo);
    }

    public function index(Request $request)
    {
		$input = $request->all();
		$user = Auth::user();
        $data = $this->getList4Role($user,$input);

        return PoResource::collection($data);
    }

    public function myPos(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();

        if (empty($input['filter'])) {
            $input['filter'] = [];
        }

        $input['filter']['u_id'] = Auth::id();

        $data = $this->getList4Role($user,$input);

        return PoResource::collection($data);
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

    public function podUpload($id, Request $request)
    {
        $po = $this->uploadPoPod($id, $request);

        return PoResource::make($po);
    }

    public function podDelete($id, Request $request)
    {
        $po = $this->removePod($id, $request);

        return PoResource::make($po);
    }

	public function uploadPOD($id, Request $request){

		$po = $this->getSingle($id);

		$data = $request->data;

		// Вкажіть шлях до файлу, де ви хочете його зберегти.
		$path = 'public/';

		// Генеруємо унікальне ім'я файлу.
		$filename = Str::random(20) . $request->name;

		// Використовуйте метод put для збереження файлу на диск. В даному випадку ми використовуємо локальний диск.
		Storage::disk('local')->put($path . $filename, base64_decode ($data));

		// Отримуємо URL збереженого файлу.
		$url = Storage::disk('local')->url($path . $filename);
		$po->poPod = ($url);
		$po->poCompleted = 1;
		$po->update();

		return response( url($url), 200);


	}

	public function cancel($id, Request $request)
	{
		$input = $request->all();

		$po = $this->cancelPo($id, $input['status']);

        return PoResource::make($po);
	}

	public function visit($id){
		$po = $this->visitPo($id);

        return PoResource::make($po);
	}
}
