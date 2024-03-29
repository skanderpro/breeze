<?php

namespace App\Enums;

enum Permission: string
{
    case PO_READ_LIST_ALL = 'PO:READ:LIST-ALL';
    case PO_EXPORT_ALL = 'PO:EXPORT:ALL';
    case PO_EXPORT_COMPANY = 'PO:EXPORT:COMPANY';
    case PO_EXPORT_CLIENT = 'PO:EXPORT:CLIENT';
    case USERS_READ_ALL = 'USERS:READ:ALL';
    case USERS_READ_COMPANY = 'USERS:READ:COMPANY';
    case COMPANY_MANAGE = 'COMPANY:MANAGE';
    case COMPANY_MANAGE_ALL = 'COMPANY:MANAGE:ALL';
    case NOTIFICATION_MANAGE_ALL = 'NOTIFICATION:MANAGE:ALL';
    case MERCHANT_MANAGE_ALL = 'MERCHANT:MANAGE:ALL';
    case MENU_READ_ADMIN = 'MENU:READ:ADMIN';
    case PO_READ_USERS_ALL = 'PO:READ:USER-ALL';
    case PO_READ_LIST_COMPANY_ALL = 'PO:READ:LIST-COMPANY-ALL';
    case PO_READ_LIST_COMPANY = 'PO:READ:LIST-COMPANY';

    public static function getRoleMap()
    {
        return [
            '1' => [
                Permission::PO_READ_LIST_ALL->value,
                Permission::MENU_READ_ADMIN->value,
                Permission::PO_READ_USERS_ALL->value,
                Permission::USERS_READ_ALL->value,
                Permission::PO_EXPORT_ALL->value,
                Permission::MERCHANT_MANAGE_ALL->value,
                Permission::NOTIFICATION_MANAGE_ALL->value,
                Permission::COMPANY_MANAGE_ALL->value,
            ],
            '2' => [
                Permission::PO_READ_LIST_COMPANY_ALL->value,
                Permission::COMPANY_MANAGE->value,
                Permission::USERS_READ_COMPANY->value,
                Permission::PO_EXPORT_COMPANY->value,
            ],
            '3' => [
                Permission::PO_READ_LIST_COMPANY->value,
                Permission::PO_EXPORT_CLIENT->value,
            ]
        ];
    }
}
