<?php

declare(strict_types=1);

namespace JH\MVCCore\Exceptions;

use Exception;

class NotFoundException extends \Exception {
  protected $code    = 404;
  protected $message = "Page Not Found";
}
