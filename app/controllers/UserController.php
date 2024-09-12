<?php

class UserController extends Controller
{
  public function __construct()
  {
    if (!Auth::getLogin()) {
      header("Location: " . BASE_URL . "/auth/signin");
      exit;
    }
  }

  public function index(): string
  {
    $limit = 10;
    Pagination::setLimit($limit);
    $start = Pagination::getStart();

    $data["users"] = $this->model("UserAccount")->getAllUsers(Request::get(), $start, $limit);
    $data["roles"] = $this->model("UserRole")->getAllRolesWhereNotAdmin();

    return $this->view("dashboard/layouts/header")
      . $this->view("dashboard/users/index", $data)
      . $this->view("dashboard/layouts/footer");
  }

  public function updateProfile(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/dashboard");
      exit;
    }

    $validated_data = Validator::setRules("update_profile", $data, [
      "profile_picture" => ["image|type:jpeg,png|max_size:1025"],
      "full_name" => ["alpha", "min_length:3", "max_length:50"],
      "phone_number" => ["phone_number"],
      "address" => ["min_length:10"],
      "bio" => ["max_length:10000"]
    ]);

    $validated_data["profile_picture"] = FileHandler::upload("profile_pictures", $validated_data["profile_picture"], Auth::getUser()->profile_picture);

    if (
      $validated_data["profile_picture"] === Auth::getUser()->profile_picture &&
      $validated_data["full_name"] === Auth::getUser()->full_name &&
      $validated_data["phone_number"] === Auth::getUser()->phone_number &&
      $validated_data["address"] === Auth::getUser()->address &&
      $validated_data["bio"] === Auth::getUser()->bio
    ) {
      Flasher::setFlash("", "No data is changed.", "warning");
    } else {
      $this->model("UserProfile")->update($validated_data);
    }

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function updateAccount(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/dashboard/settings");
      exit;
    }

    $validated_data = Validator::setRules("update_account", $data, [
      "username" => ["required", "alpha_num", "lowercase", "min_length:5", "max_length:20"],
      "email" => ["required", "email"]
    ]);

    if (
      $validated_data["username"] === Auth::getUser()->username &&
      $validated_data["email"] === Auth::getUser()->email
    ) {
      Flasher::setFlash("", "No data is changed.", "warning");
    } else {
      $this->model("UserAccount")->update($validated_data);
    }

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function updatePassword(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/dashboard/settings");
      exit;
    }

    $validated_data = Validator::setRules("update_password", $data, [
      "old_password" => ["required", "min_length:8", "old_password"],
      "new_password" => ["required", "min_length:8", "match:repeat_new_password"],
      "repeat_new_password" => ["required", "match:new_password"]
    ]);

    unset($validated_data["repeat_new_password"]);

    if ($validated_data["old_password"] === $validated_data["new_password"]) {
      Flasher::setFlash("", "The new password cannot be the same as the old password.", "warning");
    } else {
      $this->model("UserAccount")->updatePassword($validated_data["new_password"]);
    }

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function updateRole(array $data = [])
  {
    if (Auth::getUser()->role_name !== "Admin" || empty($data) || $data["role_id"] == 1) {
      header("Location: " . BASE_URL . "/user");
      exit;
    }

    $this->model("UserAccount")->updateRole($data);

    header("Location: " . BASE_URL . "/user");
  }

  public function ban(array $data = [])
  {
    if (Auth::getUser()->role_name === "User" || empty($data)) {
      header("Location: " . BASE_URL . "/user");
      exit;
    }

    $this->model("UserAccount")->ban($data);

    header("Location: " . BASE_URL . "/user");
  }

  public function deleteAccount(array $data = [])
  {
    if (Auth::getUser()->username !== $data["username"] || empty($data)) {
      header("Location: " . BASE_URL . "/dashboard/settings");
      exit;
    }

    if ($this->model("UserAccount")->delete($data)) {
      Auth::setLogin(false);
      header("Location: " . BASE_URL . "/auth/signin");
    } else {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  }

  public function deleteUser(array $data = [])
  {
    if (Auth::getUser()->role_name !== "Admin" || empty($data)) {
      header("Location: " . BASE_URL . "/user");
      exit;
    }

    $this->model("UserAccount")->delete($data);

    header("Location: " . BASE_URL . "/user");
  }

  public function logout(): void
  {
    $_SESSION = [];

    session_unset();
    session_destroy();

    setcookie("id", "", time() - 3600, "/");
    setcookie("key", "", time() - 3600, "/");

    header("Location: " . BASE_URL . "/auth/signin");
  }
}
