<?php

declare(strict_types=1);

namespace App\Core\Form;

use App\Core\src\Model;

abstract class BaseField {
  public function __construct(public Model $model, public string $attribute) {
  }

  abstract public function renderField(): string;

  public function __toString() {
    return sprintf(
      '
      <div class="">
        <label for="">%s</label>
        %s
        <div class="error">%s</div>
      </div>
    ',
      $this->model->getLabel($this->attribute), // label
      $this->renderField(),
      $this->model->getFirstError($this->attribute) // error message
    );
  }
}
