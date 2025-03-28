<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PoControllerTrait;
use App\Http\Resources\PoResource;
use App\Models\Po;
use App\Models\User;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Exports\PosExport;
use App\Services\Filters\Po\PoFilter;
use Excel;

class PoController extends Controller
{
  use PoControllerTrait;

  private PoFilter $poFilter;

  public function __construct(
    AccessCheckInterface $accessCheckService,
    PoFilter $poFilter
  ) {
    $this->accessCheckService = $accessCheckService;
    $this->poFilter = $poFilter;
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
    $data = $this->getList4Role($user, $input);

    return PoResource::collection($data);
  }

  public function myPos()
  {
    $query = Po::query();
    $this->poFilter
      ->setQuery($query)
      ->filterOnlyPos()
      ->filterByOwner()
      ->filterByDates()
      ->filterByClientStatuses()
      ->filterSeachByText()
      ->orderBy("id", "desc");

    return PoResource::collection($query->get());
  }

  public function adminPos()
  {
    $query = Po::query();
    $this->poFilter
      ->setQuery($query)
      ->filterOnlyPos()
      ->filterByDates()
      ->filterSeachByText();

    if (in_array(auth()->user()->accessLevel, ["4", "5"])) {
      $this->poFilter->filterByClientStatuses();
    } else {
      $this->poFilter->filterByAdminStatuses();
    }
    $query->orderBy("id", "desc");

    return PoResource::collection($query->get());
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

  public function updatePo(Po $po, Request $request)
  {
    $payload = $request->validate([
      "billable_value_final" => "nullable",
      "actual_value" => "nullable",
      "poInvoice" => "nullable",
      "poEMInvoice" => "nullable",
      "contractName" => "nullable",
      "status" => "required",
      "poMaterials" => "required",
      "poProject" => "nullable",
      "poCompanyPo" => "nullable",
    ]);

    $po->fill($payload);
    $po->update();

    return PoResource::make($po);
  }

  public function updateCompanyPo(Po $po, Request $request)
  {
    $payload = $request->validate([
      "poCompanyPo" => "required",
    ]);

    $po->fill($payload);
    $po->update();

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

  public function uploadPOD($id, Request $request)
  {
    $po = $this->getSingle($id);

    $data = $request->data;

    // Вкажіть шлях до файлу, де ви хочете його зберегти.
    $path = "public/";

    // Генеруємо унікальне ім'я файлу.
    $filename = Str::random(20) . $request->name;

    // Використовуйте метод put для збереження файлу на диск. В даному випадку ми використовуємо локальний диск.
    Storage::disk("local")->put($path . $filename, base64_decode($data));

    // Отримуємо URL збереженого файлу.
    $url = Storage::disk("local")->url($path . $filename);
    $po->poPod = $url;
    $po->poCompleted = 1;
    $po->update();

    return response(url($url), 200);
  }

  public function cancel($id, Request $request)
  {
    $input = $request->all();

    $po = $this->cancelPo($id, $input["status"]);

    return PoResource::make($po);
  }

  public function visit($id)
  {
    $po = $this->visitPo($id);

    return PoResource::make($po);
  }

  public function byUser(User $user)
  {
    return PoResource::collection($user->pos);
  }

  public function export(Request $request)
  {
    $startDate = $request->query("exportStartDate");
    $endDate = $request->query("exportEndDate");

    $timestamp = Carbon::now()->format("Y-m-d_H-i-s");
    $fileName = "pos_export_{$timestamp}.xlsx";
    $filePath = "exports/{$fileName}";
    Excel::store(new PosExport($startDate, $endDate), $filePath, "public");

    $url = Storage::url($filePath);

    return response()->json([
      "message" => "File exported successfully",
      "url" => url($url),
    ]);
  }
}
