<?php

class Request
{
  private static function validateCsrf()
  {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
      die('Invalid CSRF token');
    }
  }

  private static function sanitize(string $value): string
  {
    return trim(stripslashes($value));
  }

  public static function post(?string $key = null)
  {
    self::validateCsrf();

    if ($key === null) {
      $post = [];

      foreach ($_POST as $key => $value) {
        if (is_string($value)) $value = self::sanitize($value);

        self::setOldData($key, $value);

        $post[$key] = $value;
      }

      return $post;
    }

    if (isset($_POST[$key])) {
      $value = $_POST[$key];

      if (is_string($value)) return self::sanitize($value);

      self::setOldData($key, $value);

      return $value;
    }

    return null;
  }

  public static function get(?string $key = null)
  {
    if ($key === null) {
      $get = [];

      foreach ($_GET as $key => $value) {
        if (is_string($value)) $value = self::sanitize($value);

        $get[$key] = $value;
      }

      return $get;
    }

    if (isset($_GET[$key])) {
      $value = $_GET[$key];

      if (is_string($value)) return self::sanitize($value);

      return $value;
    }

    return null;
  }

  public static function files(?string $key = null)
  {
    if ($key === null) {
      return $_FILES;
    }

    return $_FILES[$key] ?? null;
  }

  public static function setOldData(string $field, $value)
  {
    $_SESSION["old_data"][$field] = $value;
  }

  public static function getOldData(string $field)
  {
    return $_SESSION["old_data"][$field] ?? null;
  }
}
