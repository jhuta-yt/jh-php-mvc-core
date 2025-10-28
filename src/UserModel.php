<?php

declare(strict_types=1);

namespace App\Core\src;

use App\Core\DB\DbModel;

abstract class UserModel extends DbModel {
  abstract public function getDisplayName(): string;
}
