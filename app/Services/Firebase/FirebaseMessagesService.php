<?php
namespace App\Services\Firebase;

use Kreait\Firebase\Factory;

class FirebaseMessagesService
{
  protected $messaging;
  public function __construct()
  {
    $factory = (new Factory())->withServiceAccount(
      base_path("firebase-messages.config.json")
    );
    $this->messaging = $factory->createMessaging();
  }
  public function sendNotification($title, $body, $token)
  {
    $message = [
      "notification" => ["title" => $title, "body" => $body],
      "token" => $token,
    ];
    return $this->messaging->send($message);
  }
}
