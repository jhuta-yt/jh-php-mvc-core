<?php

declare(strict_types=1);

namespace App\Core\Form;

use App\Core\Model;

class TextareaField extends BaseField {

  // public function __construct(public Model $model, public string $attribute) {
  //   // $this->type = self::TYPE_TEXT;
  //   parent::__construct($model, $attribute);
  // }

  public function renderField(): string {
    return sprintf(
      '<textarea name="%s" class=" %s">%s</textarea>',
      $this->attribute,                         // textarea.name
      $this->model->hasError($this->attribute) ? 'error' : '', // textarea.class => error
      $this->model->{$this->attribute},         // textarea.value
    );
  }
}
