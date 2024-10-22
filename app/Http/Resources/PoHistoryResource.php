<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PoHistoryResource extends JsonResource
{
  private $latestUploadedPod;

  public function __construct($resource)
  {
    parent::__construct($resource);
    $this->latestUploadedPod = request()->latestUploadedPod;
  }

  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $fileExists =
      $this->action === "Uploaded POD" &&
      $this->id === $this->latestUploadedPod &&
      $this->fileExists($this->formatted_data);
    return [
      "action" => $this->action,
      "user" => $this->user->name,
      "created_at" => date("d/m/y - H:i", strtotime($this->created_at)),
      "data" => $this->when(
        $this->action === "Uploaded POD",
        $fileExists ? fn() => $this->formatted_data : null,
        fn() => $this->formatted_data
      ),
    ];
  }

  /**
   * Check if a file exists.
   *
   * @param string $url
   * @return bool
   */
  private function fileExists($url)
  {
    $headers = @get_headers($url);
    return $headers && strpos($headers[0], "200");
  }
}
