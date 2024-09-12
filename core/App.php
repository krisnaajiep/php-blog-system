<?php

class App
{
  private $controller = "HomeController", $method = "index", $params = [];

  public function __construct()
  {
    $url = $this->parseURL();

    if (isset($url[0])) {
      if (file_exists("app/controllers/" . ucfirst($url[0] . "Controller.php"))) {
        $this->controller = ucfirst($url[0]) . "Controller";
        unset($url[0]);
      }
    }

    require_once "app/controllers/" . $this->controller . ".php";
    $this->controller = new $this->controller;

    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    if (!empty($_POST)) {
      $data = Request::post();

      if (!empty(Request::files())) {
        foreach (Request::files() as $key => $value) {
          $data[$key] = $value;
        }
      }

      $this->params = [$data];
    } elseif (!empty($url)) {
      $this->params = array_values($url);
    }

    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  private function parseURL()
  {
    if (!empty(Request::get("url"))) {
      $url = rtrim(Request::get("url"), "/");
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode("/", $url);

      return $url;
    }
  }

  public function __destruct()
  {
    if (isset($_SESSION["old_data"])) unset($_SESSION["old_data"]);
    if (isset($_SESSION["validation_errors"])) unset($_SESSION["validation_errors"]);
    if (isset($_SESSION["validation_id"])) unset($_SESSION["validation_id"]);
  }
}
