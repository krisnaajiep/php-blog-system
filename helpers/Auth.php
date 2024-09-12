<?php

class Auth
{
  public static function setLogin(bool $login): void
  {
    $_SESSION["login"] = $login;
  }

  public static function getLogin(): bool
  {
    return $_SESSION["login"] ?? false;
  }

  public static function setUserAccountId(int $user_account_id): void
  {
    $_SESSION["user_account_id"] = $user_account_id;
  }

  public static function getUserAccountId(): int
  {
    return $_SESSION["user_account_id"];
  }

  public static function getUser(): object
  {
    $model = new Model();

    $id = self::getUserAccountId();

    $query = "SELECT user_accounts.id, 
                     user_accounts.username,
                     user_accounts.email,
                     user_accounts.password,
                     user_accounts.role_id,
                     user_accounts.status,
                     user_accounts.created_at,
                     user_accounts.updated_at,
                     user_roles.name as role_name,
                     user_profiles.full_name,
                     user_profiles.phone_number,
                     user_profiles.address,
                     user_profiles.bio,
                     user_profiles.profile_picture
              FROM user_accounts 
              JOIN user_roles ON user_accounts.role_id = user_roles.id 
              JOIN user_profiles ON user_accounts.id = user_profiles.user_account_id
              WHERE user_accounts.id = :id";

    $model->prepare($query);
    $model->bind(":id", $id);

    $user = $model->single();

    $model->close();

    return $user;
  }
}
