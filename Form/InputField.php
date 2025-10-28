<?php

declare(strict_types=1);

namespace App\Core\Form;

use App\Core\Model;

class InputField extends BaseField {
  public const TYPE_TEXT     = 'text';
  public const TYPE_PASSWORD = 'password';
  public const TYPE_NUMBER   = 'number';

  public string $type;

  public function __construct(public Model $model, public string $attribute) {
    $this->type = self::TYPE_TEXT;
    parent::__construct($model, $attribute);
  }

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

  public function passwordField() {
    $this->type = self::TYPE_PASSWORD;
    return $this;
  }

  public function renderField(): string {
    return sprintf(
      '<input type="%s" name="%s" value="%s" class=" %s">',
      $this->type,                              // input.type
      $this->attribute,                         // input.name
      $this->model->{$this->attribute},         // input.value
      $this->model->hasError($this->attribute) ? 'error' : '', // input.class => error
    );
  }
}
