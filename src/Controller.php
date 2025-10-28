<?php

declare(strict_types=1);

namespace JH\MVCCore;

use JH\MVCCore\Middlewares\BaseMiddleware;

class Controller {
  public string $layout = 'main';
  public string $action = '';

  /** @var \JH\MVCCore\Middlewares\BaseMiddleware[] */
  protected array $middlewares = [];

  public function setLayout($layout) {
    $this->layout = $layout;
  }

  public function render($view, $params = []) {
    return Application::$app->view->renderView($view, $params);
  }

  public function registerMiddleware(BaseMiddleware $middleware) {
    $this->middlewares[] = $middleware;
  }

  public function getMiddlewares(): array {
    return $this->middlewares;
  }
}
