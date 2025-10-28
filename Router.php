<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Exceptions\NotFoundException;

class Router {
  // public Request $request;
  protected array $routes = [];

  public function __construct(
    public Request $request,
    public Response $response
  ) {
  }

  public function get(string $path, $callback) {
    $this->routes['get'][$path] = $callback;
  }

  public function post(string $path, $callback) {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve() {
    $path     = $this->request->getPath();
    $method   = $this->request->method();
    $callback = $this->routes[$method][$path] ?? false;
    if ($callback === false) {
      throw new NotFoundException();
      // return $this->renderView("err/404");
    }
    if (is_string($callback)) {
      return Application::$app->view->renderView($callback);
    }
    if (is_array($callback)) {
      // $controller = Application::$app->controller;
      // $controller = new $callback[0]();
      // $controller->action = $callback[1];
      /** @var \App\Core\Controller $controller */
      $controller = new $callback[0]();
      Application::$app->controller = $controller;
      $controller->action = $callback[1];
      $callback[0] = $controller;

      foreach ($controller->getMiddlewares() as $middleware) {
        $middleware->execute();
      }
    }
    // var_dump($callback);
    return call_user_func($callback, $this->request, $this->response);
  }

  // public function renderContent($viewContent) {
  //   return Application::$app->view->renderContent($viewContent);
  // }

  // protected function layoutContent() {
  //   $layout = Application::$app->layout;
  //   if (Application::$app->controller) {
  //     $layout = Application::$app->controller->layout;
  //   }
  //   ob_start();
  //   include_once Application::$ROOT_DIR . "/views/layouts/{$layout}.tpl.php";
  //   return ob_get_clean();
  // }

  // protected function renderOnlyView($view, $params = []) {
  //   extract($params, EXTR_SKIP);
  //   // foreach ($params as $key => $value) {
  //   //   $$key = $value;
  //   // }

  //   ob_start();
  //   include_once Application::$ROOT_DIR . "/views/{$view}.tpl.php";
  //   return ob_get_clean();
  // }
}
