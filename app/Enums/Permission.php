<?php

namespace App\Enums;

enum Permission: string
{
    // case PO_READ_LIST_ALL = 'PO:READ:LIST-ALL';
    // case PO_EXPORT_ALL = 'PO:EXPORT:ALL';
    // case PO_EXPORT_COMPANY = 'PO:EXPORT:COMPANY';
    // case PO_EXPORT_CLIENT = 'PO:EXPORT:CLIENT';
    // case USERS_READ_ALL = 'USERS:READ:ALL';
    // case USERS_READ_COMPANY = 'USERS:READ:COMPANY';
    // case COMPANY_MANAGE = 'COMPANY:MANAGE';
    // case COMPANY_MANAGE_ALL = 'COMPANY:MANAGE:ALL';
    // case NOTIFICATION_MANAGE_ALL = 'NOTIFICATION:MANAGE:ALL';
    // case MERCHANT_MANAGE_ALL = 'MERCHANT:MANAGE:ALL';
    // case MENU_READ_ADMIN = 'MENU:READ:ADMIN';
    // case PO_READ_USERS_ALL = 'PO:READ:USER-ALL';
    // case PO_READ_LIST_COMPANY_ALL = 'PO:READ:LIST-COMPANY-ALL';
    // case PO_READ_LIST_COMPANY = 'PO:READ:LIST-COMPANY';
    
    case PO_CREATE = 'PO:CREATE';
    case PO_UPDATE = 'PO:UPDATE';
    case PO_UPDATE_ALL = 'PO:UPDATE:ALL';
    case PO_UPDATE_BY_COMPANY = 'PO:UPDATE:BY-COMPANY';
    case PO_UPDATE_BY_CONTRACT = 'PO:UPDATE:BY_CONTRACT';
    case PO_UPDATE_BY_OWN = 'PO:UPDATE:BY-OWN';
    case PO_UPDATE_BY_OWN_MERCHANT = 'PO:UPDATE:BY-OWN-MERCHANT';
    case PO_UPDATE_BY_OWN_BRANCH = 'PO:UPDATE:BY-OWN-BRANCH';
    case PO_MANAGE_BY_COMPANY = 'PO:MANAGE:BY-COMPANY';
    case PO_VIEW_BY_SUPPLIER = 'PO:VIEW:BY-SUPPLIER';
    case REQUEST_CREATE = 'REQUEST:CREATE';
    case REQUEST_VIEW = 'REQUEST:VIEW';
    case REQUEST_VIEW_ALL = 'REQUEST:VIEW:ALL';
    case REQUEST_VIEW_BY_COMPANY = 'REQUEST:VIEW:BY-COMPANY';
    case REQUEST_VIEW_BY_CONTRACT = 'REQUEST:VIEW:BY-CONTRACT';
    case REQUEST_VIEW_BY_OWN = 'REQUEST:VIEW:BY-OWN';
    case REQUEST_MANAGE = 'REQUEST:MANAGE';
    case EV_CHARGING = 'EV:CHARGING';
    case USER_MANAGE = 'USER:MANAGE';
    case USER_MANAGE_ALL = 'USER:MANAGE:ALL';
    case USER_MANAGE_BY_COMPANY = 'USER:MANAGE:BY-COMPANY';
    case COMPANY_MANAGE = 'COMPANY:MANAGE';
    case COMPANY_MANAGE_COMPANY_ADMIN = 'COMPANY:MANAGE:COMPANY-ADMIN';
    case COMPANY_CONTRACTS_BY_OWN = 'COMPANY:CONTRACTS:BY-OWN';
    case COMPANY_MANAGE_ADMIN = 'COMPANY:MANAGE:ADMIN';
    case COMPANY_REPORTS = 'COMPANY:REPORTS';
    case SUPPLIER_MANAGE = 'SUPPLIER:MANAGE';
    case SUPPLIER_MANAGE_ADMIN = 'SUPPLIER:MANAGE:ADMIN';
    case SUPPLIERS_ALL = 'SUPPLIERS:ALL';
    case SUPPLIERS_BY_MERCHANT = 'SUPPLIERS:BY-MERCHANT';
    case SUPPLIER_REPORTS = 'SUPPLIER:REPORTS';
    case ADMIN_PANEL = 'ADMIN:PANEL';
    case SETTINGS = 'SETTINGS';
    case ACCOUNT = 'ACCOUNT';
    case SUPPORT_PAGE = 'SUPPORT:PAGE';
    case MANAGE_ALERT = 'MANAGE:ALERT';
    case VIEW_NOTIFICATIION = 'VIEW:NOTIFICATION';
    

    public static function getRoleMap()
    {
        return [
            '1' => [
                Permission::PO_CREATE->value,
                Permission::PO_UPDATE->value ,
                Permission::PO_MANAGE_BY_COMPANY->value,
                Permission::REQUEST_CREATE->value,
                Permission::REQUEST_MANAGE->value,
                Permission::REQUEST_VIEW_ALL->value,
                Permission::EV_CHARGING->value,
                Permission::USER_MANAGE->value,
                Permission::COMPANY_MANAGE->value,
                Permission::SUPPLIER_MANAGE->value,
                Permission::SUPPLIERS_ALL->value,
                Permission::ADMIN_PANEL->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,
                Permission::MANAGE_ALERT->value,
                Permission::VIEW_NOTIFICATIION->value,
                Permission::PO_UPDATE_ALL->value,
                Permission::COMPANY_MANAGE_ADMIN->value ,
                Permission::USER_MANAGE_ALL->value,
                Permission::SUPPLIER_MANAGE_ADMIN->value                                                    
                // Permission::PO_READ_LIST_ALL->value,
                // Permission::MENU_READ_ADMIN->value,
                // Permission::PO_READ_USERS_ALL->value,
                // Permission::USERS_READ_ALL->value,
                // Permission::PO_EXPORT_ALL->value,
                // Permission::MERCHANT_MANAGE_ALL->value,
                // Permission::NOTIFICATION_MANAGE_ALL->value,
                // Permission::COMPANY_MANAGE_ALL->value,
            ],
            '2' => [
                Permission::PO_CREATE->value,
                Permission::PO_UPDATE->value ,
                Permission::PO_MANAGE_BY_COMPANY->value,
                Permission::REQUEST_CREATE->value,
                // Permission::REQUEST_VIEW->value,
                Permission::REQUEST_VIEW_ALL->value,
                Permission::REQUEST_MANAGE->value,
                Permission::EV_CHARGING->value,
                Permission::USER_MANAGE->value,
                Permission::COMPANY_MANAGE->value,
                Permission::SUPPLIER_MANAGE->value,
                Permission::SUPPLIERS_ALL->value,
                Permission::ADMIN_PANEL->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,
                Permission::MANAGE_ALERT->value,
                Permission::VIEW_NOTIFICATIION->value,
                Permission::PO_UPDATE_ALL->value,
                Permission::COMPANY_MANAGE_ADMIN->value  ,
                Permission::USER_MANAGE_ALL->value,
                Permission::SUPPLIER_MANAGE_ADMIN->value           
                // Permission::PO_READ_LIST_COMPANY_ALL->value,
                // Permission::COMPANY_MANAGE->value,
                // Permission::USERS_READ_COMPANY->value,
                // Permission::PO_EXPORT_COMPANY->value,
            ],
            '3' => [
                Permission::PO_CREATE->value,
                Permission::PO_UPDATE->value ,
                Permission::PO_MANAGE_BY_COMPANY->value,
                Permission::REQUEST_VIEW_BY_COMPANY->value,
                Permission::REQUEST_CREATE->value,
                Permission::REQUEST_VIEW->value,
                Permission::EV_CHARGING->value,
                Permission::USER_MANAGE_BY_COMPANY->value,
                Permission::ADMIN_PANEL->value,
                Permission::COMPANY_MANAGE->value,
                Permission::COMPANY_MANAGE_COMPANY_ADMIN->value  ,
                Permission::COMPANY_REPORTS->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,
                Permission::VIEW_NOTIFICATIION->value,
                Permission::PO_UPDATE_BY_COMPANY->value,    
                // Permission::PO_READ_LIST_COMPANY->value,
                // Permission::PO_EXPORT_CLIENT->value,
            ],
            '4' => [
                Permission::PO_CREATE->value,
                Permission::PO_UPDATE->value ,
                Permission::PO_MANAGE_BY_COMPANY->value,
                Permission::REQUEST_CREATE->value,
                Permission::REQUEST_VIEW->value,
                Permission::REQUEST_VIEW_BY_CONTRACT->value,
                Permission::EV_CHARGING->value,
                Permission::USER_MANAGE->value,
                Permission::COMPANY_MANAGE->value,
                Permission::COMPANY_REPORTS->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,
                Permission::VIEW_NOTIFICATIION->value,
                Permission::PO_UPDATE_BY_CONTRACT->value   ,
                Permission::COMPANY_CONTRACTS_BY_OWN->value
            ],
            '5' => [
                Permission::PO_CREATE->value,
                Permission::PO_UPDATE->value ,
                Permission::PO_MANAGE_BY_COMPANY->value,
                Permission::REQUEST_CREATE->value,
                Permission::REQUEST_VIEW->value,
                Permission::REQUEST_VIEW_BY_CONTRACT->value,
                Permission::EV_CHARGING->value,
                Permission::USER_MANAGE->value,
                Permission::COMPANY_MANAGE->value,
                Permission::COMPANY_REPORTS->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,
                Permission::VIEW_NOTIFICATIION->value,
                Permission::PO_UPDATE_BY_CONTRACT->value,
                Permission::COMPANY_CONTRACTS_BY_OWN->value
            ],
            '6' => [
                Permission::PO_CREATE->value,
                Permission::PO_UPDATE->value ,
                Permission::PO_MANAGE_BY_COMPANY->value,
                Permission::REQUEST_CREATE->value,
                Permission::REQUEST_VIEW->value,
                Permission::REQUEST_VIEW_BY_OWN->value,
                Permission::EV_CHARGING->value,
                Permission::COMPANY_REPORTS->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,
                Permission::VIEW_NOTIFICATIION->value,
                Permission::PO_UPDATE_BY_OWN->value,
                Permission::COMPANY_CONTRACTS_BY_OWN->value
            ],
            '7' => [
                
                
                Permission::PO_MANAGE_BY_COMPANY->value,
                Permission::REQUEST_CREATE->value,
                Permission::REQUEST_VIEW->value,
                Permission::REQUEST_VIEW_BY_OWN->value,
                Permission::EV_CHARGING->value,
                Permission::COMPANY_REPORTS->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,
                Permission::VIEW_NOTIFICATIION->value,
                Permission::COMPANY_CONTRACTS_BY_OWN->value
            ],
            '8' => [
                Permission::PO_UPDATE->value ,
                Permission::PO_VIEW_BY_SUPPLIER->value,
                Permission::SUPPLIER_MANAGE->value,
                Permission::SUPPLIER_REPORTS->value,
                Permission::SUPPLIERS_BY_MERCHANT->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,  
                Permission::VIEW_NOTIFICATIION->value ,
                Permission::PO_UPDATE_BY_OWN_MERCHANT->value,
                Permission::ADMIN_PANEL->value,        
            ],
            '9' => [
                Permission::PO_UPDATE->value ,
                Permission::PO_VIEW_BY_SUPPLIER->value,
                Permission::SUPPLIER_MANAGE->value,
                Permission::SUPPLIER_REPORTS->value,
                Permission::SETTINGS->value,
                Permission::ACCOUNT->value,  
                Permission::VIEW_NOTIFICATIION->value,
                Permission::PO_UPDATE_BY_OWN_BRANCH->value   
            ]
        ];
    }
}
