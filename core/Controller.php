<?php

class Controller
{
  public function __construct()
  {
    $this->model("UserAccount")->deleteExpiredInactiveAccounts();
    $this->model("PasswordReset")->deleteExpiredTokens();
    Cookie::rememberMe();
  }

  protected function view(string $view, array $data = [])
  {
    require_once "app/views/" . $view . ".php";
  }

  protected function model(string $model)
  {
    require_once "app/models/" . $model . ".php";

    return new $model();
  }
}
