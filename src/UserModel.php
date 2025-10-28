<?php

declare(strict_types=1);

namespace JH\MVCCore;

use JH\MVCCore\DB\DbModel;

abstract class UserModel extends DbModel {
  abstract public function getDisplayName(): string;
}
