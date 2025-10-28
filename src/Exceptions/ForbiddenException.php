<?php

declare(strict_types=1);

namespace JH\MVCCore\Exceptions;

use Exception;

class ForbiddenException extends \Exception {
  protected $code    = 403;
  protected $message = "You don't have permission to access this page";
}
