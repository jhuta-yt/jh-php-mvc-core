<?php

declare(strict_types=1);

namespace App\Core\src;

use App\Core\DB\Database;

class Application {
  public ?Controller $controller = null;
  public Database   $db;
  public ?UserModel   $user;
  public Request    $request;
  public Response   $response;
  public Router     $router;
  public Session    $session;
  public View       $view;
  public static Application $app;
  public static string $ROOT_DIR;
  public string $userClass;
  public string $layout = 'main';

  public function __construct($rootPath, array $config) {
    $this->userClass = $config['user_class'];
    self::$ROOT_DIR  = $rootPath;
    self::$app       = $this;
    $this->request   = new Request;
    $this->response  = new Response;
    $this->session   = new Session;
    $this->view      = new View;
    $this->router    = new Router($this->request, $this->response);
    $this->db        = new Database($config['db']);

    $primaryValue = $this->session->get('user');
    if ($primaryValue) {
      $user = new $this->userClass;
      $primaryKey = ($user)->primaryKey();
      // $primaryKey = $this->userClass::primaryKey();
      $this->user = ($user)->findOne([$primaryKey => $primaryValue]);
      // $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
    } else {
      $this->user = null;
    }
  }

  public function run() {
    try {
      echo $this->router->resolve();
    } catch (\Exception $e) {
      $this->response->setStatusCode($e->getCode());
      echo $this->view->renderView('error/error', [
        'exception' => $e,
      ]);
    }
  }

  public function getController(): Controller {
    return $this->controller;
  }

  public function setController(Controller $controller): void {
    $this->controller = $controller;
  }

  public function login(UserModel $user) {
    $this->user = $user;
    $primaryKey = $user->primaryKey();
    $primaryValue = $user->{$primaryKey};
    $this->session->set('user', $primaryValue);
    return true;
  }

  public function logout() {
    $this->user = null;
    $this->session->remove('user');
  }

  public static function isGuest() {
    return !self::$app->user;
  }
}
