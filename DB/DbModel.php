<?php

declare(strict_types=1);

namespace App\Core\DB;

use App\Core\Application;
use App\Core\Model;
use App\Models\User;

#[\AllowDynamicProperties]
abstract class DbModel extends Model {
  abstract public function tableName(): string;
  abstract public function attributes(): array;
  abstract public function primaryKey(): string;

  public function save() {
    $tableName  = $this->tableName();
    $attributes = $this->attributes();

    // col1, col2,...
    $columns = implode(",", $attributes);
    // [':col1', ':col2',...]
    $params  = array_map(fn($attr) => ":$attr", $attributes);
    // ':col1', ':col2',...
    $params  = implode(",", $params);

    $sql  = "INSERT INTO {$tableName} ({$columns}) VALUES ({$params});";
    $stmt = self::prepare($sql);

    foreach ($attributes as $attribute) {
      $stmt->bindValue(":{$attribute}", $this->{$attribute});
    }
    $stmt->execute();
    return true;
    var_dump($stmt, $params, $attributes);
  }

  public function findOne($where) {
    $tableName  = static::tableName();
    // $tableName  = User::tableName();
    // $tableName  = self::tableName();
    // $tableName  = $this->tableName();

    $attributes = array_keys($where);
    $attr       = array_map(fn($attr) => "{$attr} = :{$attr}", $attributes);
    $whereSql   = implode(" AND ", $attr);
    $stmt       = self::prepare("SELECT * FROM {$tableName} WHERE {$whereSql}");
    foreach ($where as $key => $item) {
      $stmt->bindValue(":{$key}", $item);
    }
    $stmt->execute();
    return $stmt->fetchObject(static::class);
  }

  public static function prepare($sql) {
    return Application::$app->db->pdo->prepare($sql);
  }
}
