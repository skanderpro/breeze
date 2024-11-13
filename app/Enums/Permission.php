<?php

namespace App\Enums;

enum Permission: string
{
  case PO_READ_LIST_ALL = "PO:READ:LIST-ALL";
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

  case PO_CREATE = "PO:CREATE";
  case PO_UPDATE = "PO:UPDATE";
  case POS_ALL = "POS:ALL";
  case POS_BY_COMPANY = "POS:BY-COMPANY";
  case POS_BY_CONTRACT = "POS:BY_CONTRACT";
  case POS_BY_OWN = "PO:UPDATE:BY-OWN";
  case POS_BY_OWN_MERCHANT = "POS:BY-OWN-MERCHANT";
  case POS_BY_OWN_BRANCH = "POS:BY-OWN-BRANCH";
  case PO_MANAGE_BY_COMPANY = "PO:MANAGE:BY-COMPANY";
  case PO_VIEW_BY_SUPPLIER = "PO:VIEW:BY-SUPPLIER";
  case PO_OVERLIMIT = "PO:OVERLIMIT";
  case REQUEST_CREATE = "REQUEST:CREATE";
  case REQUEST_VIEW = "REQUEST:VIEW";
  case REQUESTS_ALL = "REQUESTS:ALL";
  case REQUESTS_BY_COMPANY = "REQUESTS:BY-COMPANY";
  case REQUESTS_BY_CONTRACT = "REQUESTS:BY-CONTRACT";
  case REQUESTS_BY_OWN = "REQUESTS:BY-OWN";
  case REQUEST_MANAGE = "REQUEST:MANAGE";
  case EV_CHARGING = "EV:CHARGING";
  case USER_MANAGE = "USER:MANAGE";
  case USERS_ALL = "USERS:ALL";
  case USERS_BY_COMPANY = "USERS:BY-COMPANY";
  case COMPANY_MANAGE = "COMPANY:MANAGE";
  case COMPANIES_COMPANY_ADMIN = "COMPANIES:COMPANY-ADMIN";
  case COMPANIES_BY_OWN = "COMPANIES:BY-OWN";
  case COMPANIES_ADMIN = "COMPANIES:ADMIN";
  case COMPANY_REPORTS = "COMPANY:REPORTS";
  case COMPANY_ADD = "COMPANY:ADD";
  case SUPPLIER_MANAGE = "SUPPLIER:MANAGE";
  case SUPPLIERS_ADMIN = "SUPPLIERS:ADMIN";
  case SUPPLIERS_ALL = "SUPPLIERS:ALL";
  case SUPPLIERS_BY_MERCHANT = "SUPPLIERS:BY-MERCHANT";
  case SUPPLIER_REPORTS = "SUPPLIER:REPORTS";
  case ADMIN_PANEL = "ADMIN:PANEL";
  case APP_CONTROL_PANEL = "APP:CONTROL:PANEL";
  case SETTINGS = "SETTINGS";
  case ACCOUNT = "ACCOUNT";
  case SUPPORT_PAGE = "SUPPORT:PAGE";
  case MANAGE_ALERT = "MANAGE:ALERT";
  case VIEW_NOTIFICATIION = "VIEW:NOTIFICATION";
  case ADMIN_GROUP = "ADMIN:GROUP";
  case COMPANY_GROUP = "COMPANY:GROUP";
  case SUPPLIER_GROUP = "SUPPLIER:GROUP";
  //ROLES
  case ADMIN_SENIOR_MANAGEMENT = "ADMIN:SENIOR:MANAGEMENT";
  case ADMIN_ACCESS = "ADMIN:ACCESS";
  case COMPANY_FULL_PLAN = "COMPANY:FULL:PLAN";
  case COMPANY_PRO_PLAN = "COMPANY:PRO:PLAN";
  case COMPANY_STANDART_PLAN = "COMPANY:STANDART:PLAN";
  case COMPANY_LIMITED_PLAN = "COMPANY:LIMITED:PLAN";
  case COMPANY_BASIC_PLAN = "COMPANY:BASIC:PLAN";
  case SUPPLIER_HEAD_OFFICE = "SUPPLIER:HEAD:OFFICE";
  case SUPPLIER_BRANCH_MANAGER = "SUPPLIER:BRANCH:MANAGER";

  public static function getRoleMap()
  {
    return [
      "1" => [
        Permission::PO_CREATE->value,
        Permission::PO_UPDATE->value,
        Permission::PO_MANAGE_BY_COMPANY->value,
        Permission::REQUEST_CREATE->value,
        Permission::REQUEST_MANAGE->value,
        Permission::REQUESTS_ALL->value,
        Permission::REQUEST_VIEW->value,
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
        Permission::POS_ALL->value,
        Permission::COMPANIES_ADMIN->value,
        Permission::USERS_ALL->value,
        Permission::SUPPLIERS_ADMIN->value,
        Permission::PO_OVERLIMIT->value,
        Permission::ADMIN_GROUP->value,
        Permission::APP_CONTROL_PANEL->value,
        Permission::ADMIN_SENIOR_MANAGEMENT->value,
        Permission::COMPANY_ADD->value,
        // Permission::PO_READ_LIST_ALL->value,
        // Permission::MENU_READ_ADMIN->value,
        // Permission::PO_READ_USERS_ALL->value,
        // Permission::USERS_READ_ALL->value,
        // Permission::PO_EXPORT_ALL->value,
        // Permission::MERCHANT_MANAGE_ALL->value,
        // Permission::NOTIFICATION_MANAGE_ALL->value,
        // Permission::COMPANY_MANAGE_ALL->value,
      ],
      "2" => [
        Permission::PO_CREATE->value,
        Permission::PO_UPDATE->value,
        Permission::PO_MANAGE_BY_COMPANY->value,
        Permission::REQUEST_CREATE->value,
        Permission::REQUEST_VIEW->value,
        Permission::REQUESTS_ALL->value,
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
        Permission::POS_ALL->value,
        Permission::COMPANIES_ADMIN->value,
        Permission::USERS_ALL->value,
        Permission::SUPPLIERS_ADMIN->value,
        Permission::PO_OVERLIMIT->value,
        Permission::ADMIN_GROUP->value,
        Permission::APP_CONTROL_PANEL->value,
        Permission::ADMIN_ACCESS->value,
        // Permission::PO_READ_LIST_COMPANY_ALL->value,
        // Permission::COMPANY_MANAGE->value,
        // Permission::USERS_READ_COMPANY->value,
        // Permission::PO_EXPORT_COMPANY->value,
      ],
      "3" => [
        Permission::PO_CREATE->value,
        Permission::PO_UPDATE->value,
        Permission::PO_MANAGE_BY_COMPANY->value,
        Permission::REQUESTS_BY_COMPANY->value,
        Permission::REQUEST_CREATE->value,
        Permission::REQUEST_VIEW->value,
        Permission::EV_CHARGING->value,
        Permission::USERS_BY_COMPANY->value,
        Permission::ADMIN_PANEL->value,
        Permission::COMPANY_MANAGE->value,
        Permission::COMPANIES_COMPANY_ADMIN->value,
        Permission::COMPANY_REPORTS->value,
        Permission::SETTINGS->value,
        Permission::ACCOUNT->value,
        Permission::VIEW_NOTIFICATIION->value,
        Permission::POS_BY_COMPANY->value,
        Permission::PO_OVERLIMIT->value,
        Permission::COMPANY_GROUP->value,
        Permission::APP_CONTROL_PANEL->value,
        Permission::COMPANY_FULL_PLAN->value,
        Permission::USER_MANAGE->value,
        // Permission::PO_READ_LIST_COMPANY->value,
        // Permission::PO_EXPORT_CLIENT->value,
      ],
      "4" => [
        Permission::PO_CREATE->value,
        Permission::PO_UPDATE->value,
        Permission::PO_MANAGE_BY_COMPANY->value,
        Permission::REQUEST_CREATE->value,
        Permission::REQUEST_VIEW->value,
        Permission::REQUESTS_BY_CONTRACT->value,
        Permission::EV_CHARGING->value,
        // Permission::USER_MANAGE->value,
        Permission::SETTINGS->value,
        Permission::ACCOUNT->value,
        Permission::VIEW_NOTIFICATIION->value,
        Permission::POS_BY_CONTRACT->value,
        Permission::COMPANIES_BY_OWN->value,
        Permission::PO_OVERLIMIT->value,
        Permission::COMPANY_GROUP->value,
        Permission::APP_CONTROL_PANEL->value,
        Permission::COMPANY_PRO_PLAN->value,
      ],
      "5" => [
        Permission::PO_CREATE->value,
        Permission::PO_UPDATE->value,
        Permission::PO_MANAGE_BY_COMPANY->value,
        Permission::REQUEST_CREATE->value,
        Permission::REQUEST_VIEW->value,
        Permission::REQUESTS_BY_CONTRACT->value,
        Permission::EV_CHARGING->value,
        // Permission::USER_MANAGE->value,
        Permission::SETTINGS->value,
        Permission::ACCOUNT->value,
        Permission::VIEW_NOTIFICATIION->value,
        Permission::POS_BY_CONTRACT->value,
        Permission::COMPANIES_BY_OWN->value,
        Permission::PO_OVERLIMIT->value,
        Permission::COMPANY_GROUP->value,
        Permission::APP_CONTROL_PANEL->value,
        Permission::COMPANY_STANDART_PLAN->value,
      ],
      "6" => [
        Permission::PO_CREATE->value,
        Permission::PO_UPDATE->value,
        Permission::PO_MANAGE_BY_COMPANY->value,
        Permission::REQUEST_CREATE->value,
        Permission::REQUEST_VIEW->value,
        Permission::REQUESTS_BY_OWN->value,
        Permission::EV_CHARGING->value,
        Permission::SETTINGS->value,
        Permission::ACCOUNT->value,
        Permission::VIEW_NOTIFICATIION->value,
        Permission::POS_BY_OWN->value,
        Permission::COMPANIES_BY_OWN->value,
        Permission::COMPANY_GROUP->value,
        Permission::APP_CONTROL_PANEL->value,
        Permission::COMPANY_LIMITED_PLAN->value,
      ],
      "7" => [
        Permission::PO_MANAGE_BY_COMPANY->value,
        Permission::REQUEST_CREATE->value,
        Permission::REQUEST_VIEW->value,
        Permission::REQUESTS_BY_OWN->value,
        Permission::EV_CHARGING->value,
        Permission::SETTINGS->value,
        Permission::ACCOUNT->value,
        Permission::VIEW_NOTIFICATIION->value,
        Permission::COMPANIES_BY_OWN->value,
        Permission::COMPANY_GROUP->value,
        Permission::APP_CONTROL_PANEL->value,
        Permission::COMPANY_BASIC_PLAN->value,
      ],
      "8" => [
        Permission::PO_UPDATE->value,
        Permission::PO_VIEW_BY_SUPPLIER->value,
        Permission::SUPPLIER_MANAGE->value,
        Permission::SUPPLIER_REPORTS->value,
        Permission::SUPPLIERS_BY_MERCHANT->value,
        Permission::SETTINGS->value,
        Permission::ACCOUNT->value,
        Permission::VIEW_NOTIFICATIION->value,
        Permission::POS_BY_OWN_MERCHANT->value,
        Permission::ADMIN_PANEL->value,
        Permission::SUPPLIER_GROUP->value,
        Permission::SUPPLIER_HEAD_OFFICE->value,
      ],
      "9" => [
        Permission::PO_UPDATE->value,
        Permission::PO_VIEW_BY_SUPPLIER->value,
        Permission::SUPPLIER_MANAGE->value,
        Permission::SETTINGS->value,
        Permission::ACCOUNT->value,
        Permission::VIEW_NOTIFICATIION->value,
        Permission::POS_BY_OWN_BRANCH->value,
        Permission::SUPPLIER_GROUP->value,
        Permission::ADMIN_PANEL->value,
        Permission::SUPPLIER_BRANCH_MANAGER->value,
      ],
    ];
  }
}
