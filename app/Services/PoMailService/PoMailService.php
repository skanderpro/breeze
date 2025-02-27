<?php
namespace App\Services\PoMailService;

use App\Models\Po;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PoMailService
{
  private Po $po;
  const EMAIL_ADMIN = "helpdesk@express-merchants.co.uk";

  public function __construct(Po $po)
  {
    $this->po = $po;
  }

  private function getEmails()
  {
    $companyAdmins = $this->getCompanyAdmins();
    $contractAdmins = $this->getContractUsers();

    $poSendEmails = config('app.po_send_emails', []);
    $poSendEmails = explode(',', $poSendEmails);

    $emails = array_merge($companyAdmins, $contractAdmins, $poSendEmails);

    return $emails;
  }

  private function getContractUsers()
  {
    $userEmails = User::join(
      "companies_users as cu",
      "cu.user_id",
      "=",
      "users.id"
    )
      ->where("cu.company_id", $this->po->contract_id)
      ->where(function ($query) {
        $query->where("accessLevel", "4")->orWhere("accessLevel", "5");
      })
      ->get()
      ->pluck("email")
      ->toArray();
    return $userEmails;
  }

  private function getCompanyAdmins()
  {
    $userEmails = User::where("companyId", $this->po->companyId)
      ->where("accessLevel", "3")
      ->get()
      ->pluck("email")
      ->toArray();
    return $userEmails;
  }

  public function send()
  {
    $ccEmails = $this->getEmails();
    $emailAdmin = self::EMAIL_ADMIN;
    $creatPO = $this->po;

    Mail::send("emails.po", compact("creatPO"), function ($message) use (
      $creatPO,
      $emailAdmin,
      $ccEmails
    ) {
      $message->from($emailAdmin, $name = "Express Merchants Helpdesk");
      $message->to($emailAdmin)->subject("New PO " . $creatPO->poNumber);
      $message->cc($ccEmails)->subject("New PO " . $creatPO->poNumber);
    });
  }
}
