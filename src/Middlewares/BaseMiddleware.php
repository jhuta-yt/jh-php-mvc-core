<?php

declare(strict_types=1);

namespace JH\MVCCore\Middlewares;

abstract class BaseMiddleware {
  abstract public function execute();
}
