<?php

class AuthController extends Controller
{
  public function __construct()
  {
    if (Auth::getLogin()) {
      header("Location: " . BASE_URL . "/dashboard");
      exit;
    }
  }

  public function index(): string
  {
    return $this->view("layouts/header")
      . $this->view("auth/signin")
      . $this->view("layouts/footer");
  }

  public function signup(): string
  {
    return $this->view("layouts/header")
      . $this->view("auth/signup")
      . $this->view("layouts/footer");
  }

  public function register(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/auth/signup");
      exit;
    }

    $validated_data = Validator::setRules("register", $data, [
      "username" => ["required", "alpha_num", "lowercase", "min_length:5", "max_length:20"],
      "email" => ["required", "email"],
      "password" => ["required", "min_length:8", "match:repeat_password"],
      "repeat_password" => ["required", "match:password"]
    ]);

    if ($this->model("UserAccount")->create($validated_data, $this->model("UserProfile"), $this->model("AccountActivation"))) {
      header("Location: " . BASE_URL . "/auth/signin");
    } else {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  }

  public function forgotPassword(): string
  {
    return $this->view("layouts/header")
      . $this->view("auth/forgot_password")
      . $this->view("layouts/footer");
  }

  public function activate(string $token = null)
  {
    if (is_null($token)) {
      header("Location: " . BASE_URL . "/auth");
      exit;
    }

    $this->model("AccountActivation")->activate($token, $this->model("UserAccount"));

    header("Location: " . BASE_URL . "/auth/signin");
  }

  public function sendResetPasswordLink(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/auth/forgotPassword");
      exit;
    }

    $validated_data = Validator::setRules("send_reset_password_link", $data, ["email" => ["required", "email"]]);

    $this->model("PasswordReset")->create($validated_data["email"], $this->model("UserAccount"));

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function resetPassword(string $token = null): string
  {
    if (is_null($token)) {
      header("Location: " . BASE_URL . "/auth");
      exit;
    }

    $data["token"] = $token;

    return $this->view("layouts/header")
      . $this->view("auth/reset_password", $data)
      . $this->view("layouts/footer");
  }

  public function updatePassword(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/auth/forgotPassword");
      exit;
    }

    $validated_data = Validator::setRules("reset_password", $data, [
      "new_password" => ["required", "min_length:8", "match:repeat_new_password"],
      "repeat_new_password" => ["required", "match:new_password"]
    ]);

    if ($this->model("PasswordReset")->reset($data["token"], $validated_data["new_password"], $this->model("UserAccount"))) {
      header("Location: " . BASE_URL . "/auth/signin");
    } else {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  }

  public function login(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/auth");
      exit;
    }

    $validated_data = Validator::setRules("login", $data, [
      "username" => ["required"],
      "password" => ["required"]
    ]);

    $user_account_id = $this->model("UserAccount")->getUserForLogin($validated_data);

    if ($user_account_id !== false) {
      Auth::setLogin(true);
      Auth::setUserAccountId($user_account_id);

      if (isset($data["remember_me"])) {
        setcookie("id", $user_account_id, time() + (86400 * 30), "/");
        setcookie("key", hash("sha256", $validated_data["username"]), time() + (86400 * 30), "/");
      }

      header("Location: " . BASE_URL . "/dashboard");
    } else {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  }
}
