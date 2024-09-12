<?php

class Validator
{
  public static function setRules(string $action, array $data, array $rules): array|string|false
  {
    $_SESSION["validation_errors"] = [];
    $validated_data = [];

    foreach ($rules as $field => $ruleset) {
      $value = $data[$field] ?? null;

      foreach ($ruleset as $rule) {
        if (!isset($_SESSION["validation_errors"][$field])) {
          $validated_value = self::validate($action, $value, $rule, $field, $data);
        }
      }

      $validated_data[$field] = $validated_value ?? null;
    }

    if (self::hasValidationErrors($action)) {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
      exit;
    }

    if (is_array($validated_data[$field])) return $validated_data[$field];

    return $validated_data;
  }

  public static function validate($action, $value, string $rule, string $field, array $data)
  {
    if ($rule === "required" && empty($value)) {
      self::setValidationError($action, $field, $field . " field is required.");
    }

    if (!empty($value)) {
      if ($rule === "alpha" && !preg_match("/^[a-zA-Z\s\-]+$/", $value)) {
        self::setValidationError($action, $field, $field . " input may only contain letters, spaces, and hyphens (-).");
      }

      if ($rule === "alpha_num") {
        if (!preg_match("/^[a-zA-Z0-9._-]+$/", $value)) {
          self::setValidationError($action, $field, $field . " input may only contain letters, numbers, periods (.), underscores (_), and hyphens (-).");
        }
      }

      if ($rule === "alpha_num_space") {
        if (!preg_match("/^[a-zA-Z0-9. _-]+$/", $value)) {
          self::setValidationError($action, $field, $field . " input may only contain letters, spaces, numbers, periods (.), underscores (_), and hyphens (-).");
        }
      }

      if ($rule === "num" && !is_numeric($value)) {
        self::setValidationError($action, $field, $field . " input must be numeric");
      }

      if ($rule === "lowercase" && $value !== strtolower($value)) {
        self::setValidationError($action, $field, $field . " input letters must be lowercase.");
      }

      if (strpos($rule, "min_length") !== false && strpos($rule, ":") !== false) {
        $rule = explode(":", $rule)[1];

        if (strlen($value) < (int)$rule) {
          self::setValidationError($action, $field, $field . " input must be at least {$rule} characters long.");
        }
      }

      if (strpos($rule, "max_length") !== false && strpos($rule, ":") !== false) {
        $rule = explode(":", $rule)[1];

        if (strlen($value) > (int)$rule) {
          self::setValidationError($action, $field, $field . " input must not exceed {$rule} characters.");
        }
      }

      if ($rule === "numeric" && !is_numeric($value)) {
        self::setValidationError($action, $field, $field . " input must be numeric.");
      }

      if ($rule === "email") {
        $value = filter_var($value, FILTER_SANITIZE_EMAIL);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
          self::setValidationError($action, $field, $field . " input must be a valid email address.");
        }
      }

      if (strpos($rule, "match") !== false && strpos($rule, ":") !== false) {
        $match = explode(":", $rule);
        if ($value !== $data[$match[1]]) {
          self::setValidationError($action, $field, $field . " doesn't match.");
        }
      }

      if ($rule === "phone_number" && !preg_match("/^08[0-9]{10,12}$/", $value)) {
        self::setValidationError($action, $field, $field . " input must be a valid phone number.");
      }

      if ($rule === "date") {
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $value)) {
          self::setValidationError($action, $field, $field . " input format must be Y-m-d.");
          return;
        }

        $parts = explode("-", $value);
        if (!checkdate($parts[1], $parts[2], $parts[0])) {
          self::setValidationError($action, $field, $field . " input must be a valid date.");
        }
      }
    }

    if (strpos($rule, "image") !== false && $value["error"] === 0) {
      $file_type = explode("/", $value["type"])[0];
      if ($file_type !== "image") {
        self::setValidationError($action, $field, $field . " input must be an image file.");
        return;
      }

      if (strpos($rule, "|") !== false) {
        $image_rules = explode("|", $rule);
        unset($image_rules[0]);

        foreach ($image_rules as $image_rule) {
          if (strpos($image_rule, "type") !== false && strpos($image_rule, ":") !== false) {
            $valid_types = explode(":", $image_rule)[1];
            $valid_types = explode(",", $valid_types);
            $file_type = explode("/", $value["type"])[1];

            if (!in_array($file_type, $valid_types)) {
              $valid_types = implode(",", $valid_types);
              self::setValidationError($action, $field, $field . " file must be of type: " . $valid_types);
              return;
            }
          }

          if (strpos($image_rule, "max_size") !== false && strpos($image_rule, ":") !== false) {
            $max_size = (int)explode(":", $image_rule)[1];

            if ($value["size"] > ($max_size * 1024)) {
              self::setValidationError($action, $field, $field . " file size must not exceed " . floor($max_size / 1024) . "MB");
            }
          }
        }
      }
    }

    if ($rule === "old_password" && !password_verify($value, Auth::getUser()->password)) {
      self::setValidationError($action, $field, $field . " input is invalid.");
    }

    return $value;
  }

  public static function setValidationError($action, $field, $message): void
  {
    $_SESSION["validation_errors"][$action][$field] = $message;
  }

  public static function hasValidationErrors($action): bool
  {
    return !empty($_SESSION["validation_errors"][$action]);
  }

  public static function hasValidationError($action, $field): bool
  {
    return isset($_SESSION["validation_errors"][$action][$field]);
  }

  public static function getValidationError($action, $field): string
  {
    return $_SESSION["validation_errors"][$action][$field] ?? "";
  }
}
