<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MerchantControllerTrait;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Services\Merchant\MerchantFilter;

class MerchantController extends Controller
{
  use MerchantControllerTrait;

  public function index(Request $request)
  {
    $qb = Merchant::query();

    $filter = new MerchantFilter($qb);
    $filter
      ->filterByParentAndDisabled()
      ->filterBySearch($request->get("search"))
      ->filterByName($request->get("name"))
      ->filterByMerchantId($request->get("merchant_id"))
      ->filterByGreenSupplier($request->get("green_supplier"))
      ->filterByMerchantAttributes($request);
    return MerchantResource::collection($qb->get());
  }

  public function getAdminList(Request $request)
  {
    $qb = Merchant::query();
    $filter = new MerchantFilter($qb);
    $filter->filterBySearch($request->get("search"));
    return MerchantResource::collection($qb->get());
  }

  public function createMerchant(Request $request)
  {
    $merchant = $this->store($request);
    return MerchantResource::make($merchant);
  }

  public function updateMerchant($id, Request $request)
  {
    $merchant = $this->update($id, $request);

    return MerchantResource::make($merchant);
  }

  public function toggle(Merchant $merchant, Request $request)
  {
    $merchant->disabled = !$merchant->disabled;
    $merchant->save();

    return MerchantResource::make($merchant);
  }

  public function findByParentMerchant($parent_id)
  {
    return $this->findByParent($parent_id);
  }
}
