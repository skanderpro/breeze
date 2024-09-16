<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\GateAccessService;
use App\Enums\Permission;

class PermissionController extends Controller {


	protected $permissionGate;

	public function __construct(GateAccessService $gateAccessService){
		$this->permissionGate = $gateAccessService;
	}

	public function check(Request $request){
		$user = Auth::user();
		$input = $request->all();
		$result = [];
		$permissions = $input['permissions'];

		$roleMap = Permission::getRoleMap();
		for($i = 0;$i < count($permissions);$i++){
			$result[$permissions[$i]] = in_array($permissions[$i], $roleMap[$user->accessLevel]);
		}
		return response()->json($result);
	}
}
