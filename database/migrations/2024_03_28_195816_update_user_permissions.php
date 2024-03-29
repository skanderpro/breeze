<?php

use App\Enums\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $accessLevelPerm = [
            '1' => [
                Permission::PO_READ_LIST_ALL->value => true,
                Permission::MENU_READ_ADMIN->value => true,
                Permission::PO_READ_USERS_ALL->value => true,
                Permission::USERS_READ_ALL->value => true,
                Permission::PO_EXPORT_ALL->value => true,
                Permission::MERCHANT_MANAGE_ALL->value => true,
                Permission::NOTIFICATION_MANAGE_ALL->value => true,
                Permission::COMPANY_MANAGE_ALL->value => true,
                Permission::COMPANY_MANAGE->value => true,
            ],
            '2' => [
                Permission::PO_READ_LIST_COMPANY_ALL->value => true,
                Permission::COMPANY_MANAGE->value => true,
                Permission::USERS_READ_COMPANY->value => true,
                Permission::PO_EXPORT_COMPANY->value => true,
            ],
            '3' => [
                Permission::PO_READ_LIST_COMPANY->value => true,
                Permission::PO_EXPORT_CLIENT->value => true,
            ]
        ];

        Schema::table('users', function (Blueprint $table) {
            $table->json('permissions')->nullable();
        });

        DB::transaction(function () use ($accessLevelPerm) {
            foreach ($accessLevelPerm as $al => $perm) {
                \App\Models\User::query()->where('accessLevel', $al)
                    ->update([
                        'permissions' => \json_encode($perm),
                    ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
