<?php

class Cookie
{
  public static function rememberMe(): void
  {
    $model = new Model();

    if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
      $id = (int)$_COOKIE["id"];

      $query = "SELECT id, username FROM user_accounts WHERE user_accounts.id = :id";
      $model->prepare($query);
      $model->bind(":id", $id);

      $model->execute();

      $user_account = $model->single();

      if ($_COOKIE["key"] === hash("sha256", $user_account->username)) {
        Auth::setLogin(true);
        Auth::setUserAccountId($user_account->id);
      }

      $model->close();
    }
  }
}
