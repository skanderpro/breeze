<?php

namespace App\Http\Controllers\Traits;

use App\Enums\Permission;
use App\Mail\PoRequestMerchant;
use App\Models\Company;
use App\Models\Merchant;
use App\Models\Po;
use App\Models\Setting;
use App\Models\User;
use App\Services\PoMailService\PoMailService;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

trait PoControllerTrait
{
  /** @var AccessCheckInterface */
  public $accessCheckService;

  protected function validateStoreRequest(Request $request)
  {
    $poType = $request->input("poType", $request->input("items.0.poType"));

    if ($poType == "alternate") {
      return $this->validate($request, [
        "items.*.companyId" => "required",
        "items.*.u_id" => "required",
        "items.*.poType" => "required|max:255",
        "items.*.poPurpose" => "required|max:255",
        "items.*.poNotes" => "nullable",
        "items.*.alt_merchant_name" => "required",
        "items.*.alt_merchant_email" => "required",
        "items.*.alt_merchant_contact" => "required",
        "items.*.poProjectLocation" => "required|max:255",
      ]);
    } elseif ($poType == "Pre Approved") {
      return $this->validate($request, [
        "items.*.companyId" => "required",
        "items.*.u_id" => "required",
        "items.*.poNotes" => "nullable",
        "items.*.poType" => "required|max:255",
        "items.*.poPurpose" => "required|max:255",
        "items.*.selectMerchant" => "required",
        "items.*.poProjectLocation" => "required|max:255",
      ]);
    }

    throw new \Exception("poType validation failed");
  }

  protected function validateStore(Request $request)
  {
    if ($request->input("poType") == "alternate") {
      return $this->validate($request, [
        "companyId" => "required",
        "u_id" => "required",
        "poType" => "required|max:255",
        "poNotes" => "nullable",
        "poPurpose" => "required|max:255",
        "alt_merchant_name" => "required",
        "alt_merchant_contact" => "required",
        "alt_merchant_email" => "required",
        "poProjectLocation" => "required|max:255",
      ]);
    } elseif ($request->input("poType") == "Pre Approved") {
      return $this->validate($request, [
        "companyId" => "required",
        "u_id" => "required",
        "poNotes" => "nullable",
        "poType" => "required|max:255",
        "poPurpose" => "required|max:255",
        "selectMerchant" => "required",
        "poProjectLocation" => "required|max:255",
      ]);
    }

    throw new \Exception("poType validation failed");
  }

  public function storeRequests(Request $request)
  {
    $numberKey = "po-request-key";
    $number = Setting::getInt($numberKey) + 1;
    Setting::set($numberKey, $number);
    $this->validateStoreRequest($request);

    $poNumber = "RQ-{$number}";

    $payload = $request->toArray();
    $pos = [];
    $notify = [];
    $id = null;
    foreach ($payload["items"] as $item) {
      $item["is_request"] = "1";
      $item["poNumber"] = $poNumber;
      $item["created_by_id"] = Auth::id();
      $item["status"] = "Awaiting Quote(s)";
      $po = Po::create($item);
      if (empty($id)) {
          $id = $po->id;
      }
      $po->poNumber = "RQ-{$id}";
      $po->save();
      $pos[] = $po;

      $merchant = !empty($item["selectMerchant"])
        ? Merchant::find($item["selectMerchant"])
        : null;

      if (!$merchant && !empty($item["alt_merchant_email"])) {
        $notify[] = [
          "email" => $item["alt_merchant_email"],
          "name" => $item["alt_merchant_name"],
          "contact" => $item["alt_merchant_contact"],
          "po" => $po,
        ];
      } elseif ($merchant) {
        $notify[] = [
          "email" => empty($merchant->merchantEmail)
            ? $merchant->merchantContactEmail
            : $merchant->merchantEmail,
          "name" => empty($merchant->merchantName)
            ? $merchant->merchantContactName
            : $merchant->merchantName,
          "contact" => empty($merchant->merchantPhone)
            ? $merchant->merchantContactPhone
            : $merchant->merchantPhone,
          "po" => $po,
        ];
      }
    }

    foreach ($notify as $item) {
      try {
        Mail::to($item["email"])->send(new PoRequestMerchant($item["po"]));
      } catch (\Exception $e) {
        Log::error("email send error", [
          "message" => $e->getMessage(),
          "error" => $e,
        ]);
      }
    }

    return $pos;
  }

  public function store(Request $request)
  {
    $this->validateStore($request);

    $creatPO = Po::create($request->toArray());
    $creatPO->poNumber = "EM-{$creatPO->id}";
    $creatPO->status = "New Order";
    $creatPO->client_status = "New Order";
    $creatPO->created_by_id = Auth::id();
    $creatPO->update();

    $poEmailService = new PoMailService($creatPO);

    try {
      $poEmailService->send();
    } catch (\Exception $e) {
      Log::error($e->getMessage(), [
        "error" => $e,
      ]);
    }

    return $creatPO;
  }

  public function getList(Request $request)
  {
    $adminusr = User::where("accessLevel", "2")
      ->where("companyId", Auth::user()->companyId)
      ->first();

    $merchants = Merchant::all();

    // Sets the parameters from the get request to the variables.
    $u_id = $request->get("u_id");
    $poPod = $request->get("poPod");
    $poId = $request->get("poId");
    $poJobStatus = $request->get("poJobStatus");
    $poFinanceStatus = $request->get("poFinanceStatus");
    $company_id = $request->get("company_id");
    $merchant_id = $request->get("merchant_id");
    $poProject = $request->get("poProject");
    $poLocation = $request->get("poLocation");
    $dateFrom = $request->get("dateFrom");
    $dateTo = $request->get("dateTo");
    $date = $request->get("date");
    $poPod = $request->get("poPod");

    $query = Po::query()->whereNot("is_request", "1");

    // $pos = DB::table('pos')
    // ->join('companies', 'pos.companyId', '=', 'companies.id')
    // ->select('pos.*', 'companies.companyName')
    // ->orderBy('id', 'desc')
    // ->paginate(15);

    $companies = Company::all();

    if ($this->accessCheckService->check(Permission::PO_READ_LIST_ALL->value)) {
      $users = User::all();

      if ($u_id) {
        $query->where("u_id", "=", $u_id);
      }

      if ($poId) {
        $query->where("id", "=", $poId);
      }

      if ($dateFrom && $dateTo) {
        $query->whereBetween("created_at", [$dateFrom, $dateTo]);
      }

      if ($date) {
        $query->where("created_at", "LIKE", "%$date%");
      }

      if ($company_id) {
        $query->where("companyId", "=", $company_id);
      }

      if ($merchant_id) {
        $query->where("selectMerchant", "=", $merchant_id);
      }

      if ($poPod) {
        $query->where("poPod", "=", "");
      }

      if ($poJobStatus) {
        $query->where("poJobStatus", "=", $poJobStatus);
      }

      if ($poFinanceStatus) {
        $query->where("poFinanceStatus", "=", $poFinanceStatus);
      }

      if ($poProject) {
        $query->where("poProject", "=", "$poProject");
      }

      if ($poLocation) {
        $query->where("poProjectLocation", "LIKE", "%$poLocation%");
      }
    }

    if (
      $this->accessCheckService->check(
        Permission::PO_READ_LIST_COMPANY_ALL->value
      )
    ) {
      $users = User::where("companyId", Auth::user()->companyId)->get();

      if ($u_id) {
        $query->where("u_id", "=", $u_id);
      }

      if ($poId) {
        $query->where("id", "=", $poId);
      }

      if ($dateFrom && $dateTo) {
        $query->whereBetween("created_at", [$dateFrom, $dateTo]);
      }

      if ($date) {
        $query->where("created_at", "LIKE", "%$date%");
      }

      if ($poProject) {
        $query->where("poProject", "=", "$poProject");
      }

      if ($poPod) {
        $query->where("poPod", "=", "");
      }

      if ($poLocation) {
        $query->where("poProjectLocation", "LIKE", "%$poLocation%");
      }

      $query->where("companyId", "=", Auth::user()->companyId);
    }

    if (
      $this->accessCheckService->check(Permission::PO_READ_LIST_COMPANY->value)
    ) {
      if ($u_id) {
        $query->where("u_id", "=", $u_id);
      }

      if ($poId) {
        $query->where("id", "=", $poId);
      }

      if ($dateFrom && $dateTo) {
        $query->whereBetween("created_at", [$dateFrom, $dateTo]);
      }

      if ($date) {
        $query->where("created_at", "LIKE", "%$date%");
      }

      if ($poPod) {
        $query->where("poPod", "=", "");
      }

      if ($poLocation) {
        $query->where("poProjectLocation", "LIKE", "%$poLocation%");
      }

      $query->where("companyId", "=", Auth::user()->companyId);
      $query->where("u_id", "=", Auth::user()->id);

      // $query->where('poInvoice', '=', "");
      // $query->where('poPod', '=', "");
      // $query->where('poCompanyPo', '=', "");
    }

    $query->orderBy("id", "desc");

    if (
      $u_id ||
      $poId ||
      $company_id ||
      $merchant_id ||
      $poProject ||
      $poLocation ||
      $dateFrom ||
      $dateTo ||
      $date
    ) {
      $pos = $query->paginate(10000);
    } else {
      $pos = $query->paginate(50);
    }

    $engineer = User::where("id", "=", Auth::user()->id)->first();

    return compact(
      "pos",
      "dateTo",
      "dateFrom",
      "date",
      "company_id",
      "merchant_id",
      "u_id",
      "poFinanceStatus",
      "poJobStatus",
      "poId",
      "poPod",
      "poProject",
      "poLocation",
      "poPod",
      "users",
      "companies",
      "merchants",
      "engineer",
      "adminusr"
    );
  }

  public function getSingle($id)
  {
    return Po::select(
      "pos.*",
      "companies.companyName",
      "users.name",
      "merchants.merchantName"
    )
      ->leftJoin("companies", "pos.companyId", "=", "companies.id")
      ->leftJoin("merchants", "pos.selectMerchant", "=", "merchants.id")
      ->leftJoin("users", "pos.u_id", "=", "users.id")
      ->where("pos.id", "=", $id)
      ->firstOrFail();
  }

  public function updadePo($id, Request $request)
  {
    $this->validate($request, [
      "poPod" => "file|max:6000",
    ]);

    $editPo = Po::findOrFail($id);

    $poPod = $request->get("poPod");

    // $input = \Request::get('poPod');

    $input = $request->all();

    $destinationPath = "uploads/"; // upload path
    $file = $request->file("poPod");
    // $fileName = $file->getClientOriginalName();

    $filename = $_FILES["poPod"]["name"];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if ($request->hasFile("poPod")) {
      $request->file("poPod")->move($destinationPath, $filename);

      $input["poPod"] = $filename;

      // if ($ext == 'pdf')
      // {
      //   $request->file('poPod')->move($destinationPath, $filename . '.pdf');
      // }
      //
      //
      // if ($ext == 'jpg' || $ext == 'jpeg')
      // {
      //   $request->file('poPod')->move($destinationPath, $filename . '.jpg');
      // }
    }

    $editPo->fill($input)->save();
    // $editPo->billable_value =
    //   $editPo->value * (Auth::user()->company?->agreed_markup ?? 1);
    $editPo->save();

    return $editPo;
  }

  public function uploadPoPod($id, Request $request)
  {
    $this->validate($request, [
      "poPod" => "file|max:6000",
    ]);

    $destinationPath = "uploads/"; // upload path

    $filename = $_FILES["poPod"]["name"];

    $editPo = Po::findOrFail($id);
    if ($request->hasFile("poPod")) {
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      $tmpName = Uuid::uuid4();
      $filename = "{$tmpName}.{$ext}";
      $request
        ->file("poPod")
        ->move(Storage::disk("public")->path($destinationPath), $filename);
      $editPo->poPod = "/storage/{$destinationPath}{$filename}";
      $editPo->save();
    }

    return $editPo;
  }

  public function removePod($id, Request $request)
  {
    $this->validate($request, [
      "poPod" => "file|max:6000",
    ]);

    $editPo = Po::findOrFail($id);
    $destinationPath = "uploads/" . $editPo->poPod; // upload path

    $fileWasDeleted = false;

    if (Storage::disk("public")->exists($destinationPath)) {
      Storage::disk("public")->delete($destinationPath);
      $fileWasDeleted = true;
    } elseif (Storage::disk("local")->exists($editPo->poPod)) {
      Storage::disk("local")->delete($editPo->poPod);
      $fileWasDeleted = true;
    } elseif (Storage::exists($editPo->poPod)) {
      Storage::delete($editPo->poPod);
      $fileWasDeleted = true;
    } elseif (file_exists(base_path($editPo->poPod))) {
      unlink(base_path($editPo->poPod));
      $fileWasDeleted = true;
    } elseif (
      Storage::disk("public")->exists(
        str_replace("/storage/", "", $editPo->poPod)
      )
    ) {
      Storage::disk("public")->delete(
        str_replace("/storage/", "", $editPo->poPod)
      );
      $fileWasDeleted = true;
    }

    if ($fileWasDeleted) {
      $editPo->poPod = "";
      $editPo->save();
    }

    return $editPo;
  }

  public function getList4Role($user, $filter)
  {
    $pos = Po::select("pos.*")
      ->whereNot("pos.is_request", "1")
      ->join("companies", "companies.id", "=", "pos.companyId")
      ->leftJoin("merchants", "merchants.id", "=", "pos.selectMerchant");

    if (
      !empty($filter["filter"]["startDate"]) &&
      !empty($filter["filter"]["endDate"])
    ) {
      $startDate = date(
        "Y-m-d H:i:s",
        strtotime($filter["filter"]["startDate"])
      );
      $endDate = date("Y-m-d H:i:s", strtotime($filter["filter"]["endDate"]));

      $pos = $pos->where(function ($q) use ($startDate, $endDate) {
        $q->where("pos.created_at", ">=", $startDate)->where(
          "pos.created_at",
          "<=",
          $endDate
        );
      });
    }

    if (!empty($filter["filter"]["search"])) {
      $pos = $pos->where(function ($q) use ($filter) {
        $q->where(
          "merchants.merchantName",
          "like",
          "%" . $filter["filter"]["search"] . "%"
        )
          ->orWhere(
            "pos.alt_merchant_name",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "pos.poNumber",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          );
      });
    }

    $pos = $pos->orderBy("pos.id", "desc")->get();

    if (!empty($filter["filter"]["statuses"])) {
      $statuses = explode(",", $filter["filter"]["statuses"]);
      $pos = $pos->filter(function ($item) use ($statuses) {
        return in_array($item->status, $statuses);
      });
    }

    return $pos;
  }

  public function getRequestList4Role($user, $filter)
  {
    $pos = Po::select("pos.*")
      ->where("pos.is_request", "1")
      ->join("companies", "companies.id", "=", "pos.companyId")
      ->where("companies.parent_id", $user->companyId);

    if (
      !empty($filter["filter"]["startDate"]) &&
      !empty($filter["filter"]["endDate"])
    ) {
      $pos = $pos->whereBetween("pos.created_at", [
        date("Y-m-d H:i:s", strtotime($filter["filter"]["startDate"])),
        date("Y-m-d H:i:s", strtotime($filter["filter"]["endDate"])),
      ]);
    }

    if (!empty($filter["filter"]["search"])) {
      $pos = $pos->where(function ($q) use ($filter) {
        $q->where(
          "pos.poNumber",
          "like",
          "%" . $filter["filter"]["search"] . "%"
        );
      });
    }

    if (!empty($filter["filter"]["statuses"])) {
      $statuses = $filter["filter"]["statuses"];
      $pos = $pos->whereIn("status", $statuses);
    }

    $pos = $pos->orderBy("pos.id", "desc")->get();
    return $pos;
  }

  public function getAdminRequestList($filter)
  {
    $pos = Po::select("pos.*")
      ->where("pos.is_request", "1")
      ->leftJoin("merchants", "merchants.id", "=", "pos.selectMerchant");

    if (
      !empty($filter["filter"]["startDate"]) &&
      !empty($filter["filter"]["endDate"])
    ) {
      $pos = $pos->whereBetween("pos.created_at", [
        date("Y-m-d H:i:s", strtotime($filter["filter"]["startDate"])),
        date("Y-m-d H:i:s", strtotime($filter["filter"]["endDate"])),
      ]);
    }

    if (!empty($filter["filter"]["search"])) {
      $pos = $pos->where(function ($q) use ($filter) {
        $q->where(
          "merchants.merchantName",
          "like",
          "%" . $filter["filter"]["search"] . "%"
        )
          ->orWhere(
            "pos.alt_merchant_name",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "pos.poProject",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "pos.poNumber",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          );
      });
    }

    $pos = $pos->orderBy("pos.id", "desc")->get();

    if (!empty($filter["filter"]["statuses"])) {
      $statuses = explode(",", $filter["filter"]["statuses"]);
      $pos = $pos->filter(function ($item) use ($statuses) {
        return in_array($item->status, $statuses);
      });
    }

    return $pos;
  }

  public function cancelPo($id, $status)
  {
    $editPo = Po::findOrFail($id);
    $editPo->poCancelled = 1;
    $editPo->poCancelledBy = Auth::user()->name;
    $editPo->poCompletedStatus = $status;
    $editPo->status = "Cancelled";
    $editPo->update();
    return $editPo;
  }

  public function visitPo($id)
  {
    $editPo = Po::findOrFail($id);
    $editPo->poVisitStatus = 1;
    $editPo->update();
    return $editPo;
  }

  public function getRequestsByNumber($number)
  {
    $pos = PO::where("poNumber", $number)->get();
    return $pos;
  }

  public function uploadRequestFileMethod($request)
  {
    $this->validate($request, [
      "file" => "file|max:6000",
    ]);

    $destinationPath = "uploads/"; // upload path
    $filename = "";
    $path = "";

    if ($request->hasFile("file")) {
      $ext = $request->file("file")->extension();
      $tmpName = Uuid::uuid4();
      $filename = "{$tmpName}.{$ext}";
      $request
        ->file("file")
        ->move(Storage::disk("public")->path($destinationPath), $filename);
      $path = "/storage/{$destinationPath}{$filename}";
    }
    return ["file" => $path];
  }
}
