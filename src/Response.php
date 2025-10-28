<?php

declare(strict_types=1);

namespace App\Core\src;

class Response {

  public function setStatusCode(int $code) {
    http_response_code($code);
  }

  public function redirect($url) {
    header("Location: {$url}");
  }
}
