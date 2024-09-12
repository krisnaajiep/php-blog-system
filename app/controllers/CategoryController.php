<?php

class CategoryController extends Controller
{
  public function __construct()
  {
    if (!Auth::getLogin() || Auth::getUser()->role_name === "User") {
      header("Location: " . BASE_URL . "/dashboard");
      exit;
    }
  }

  public function index(): string
  {
    $data["categories"] = $this->model("Category")->getAllCategories();

    if (Validator::hasValidationErrors("update_category")) {
      $data["category_id"] = $_SESSION["validation_id"];
    }

    return $this->view("dashboard/layouts/header")
      . $this->view("dashboard/categories/index", $data)
      . $this->view("dashboard/layouts/footer", $data);
  }

  public function create(array $data = [])
  {
    if (Auth::getUser()->role_name === "User" || empty($data)) {
      header("Location: " . BASE_URL . "/category");
      exit;
    }

    $validated_data = Validator::setRules("create_category", $data, [
      "thumbnail" => ["image|type:jpeg,png|max_size:10240"],
      "name" => ["required", "alpha"]
    ]);

    $validated_data["thumbnail"] = FileHandler::upload("category_thumbnails", $validated_data["thumbnail"], "default.jpg");

    $this->model("Category")->create($validated_data);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function update(array $data = [])
  {
    if (Auth::getUser()->role_name === "User" || empty($data)) {
      header("Location: " . BASE_URL . "/category");
      exit;
    }

    $_SESSION["validation_id"] = $data["id"];

    $validated_data = Validator::setRules("update_category", $data, [
      "thumbnail" => ["image|type:jpeg,png|max_size:10240"],
      "name" => ["required", "alpha"]
    ]);

    $data["thumbnail"] = FileHandler::upload("category_thumbnails", $validated_data["thumbnail"], $data["old_thumbnail"]);
    $data["name"] = $validated_data["name"];

    if ($data["name"] === $data["old_name"] && $data["thumbnail"] === $data["old_thumbnail"]) {
      Flasher::setFlash("", "No data is changed.", "warning");
    } else {
      $this->model("Category")->update($data);
    }

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function delete(array $data = [])
  {
    if (Auth::getUser()->role_name === "User" || empty($data)) {
      header("Location: " . BASE_URL . "/category");
      exit;
    }

    $this->model("Category")->delete($data);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }
}
