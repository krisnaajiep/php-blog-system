<?php

class PostController extends Controller
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

    $data["posts"] = $this->model("Post")->getPostsByAuthor(Request::get(), $start, $limit);
    $data["categories"] = $this->model("Category")->getAllCategories();

    if (Validator::hasValidationErrors("update_post")) {
      $data["post_id"] = $_SESSION["validation_id"];
    }

    return $this->view("dashboard/layouts/header")
      . $this->view("dashboard/posts/index", $data)
      . $this->view("dashboard/layouts/footer", $data);
  }

  public function create(array $data = [])
  {
    if (empty($data)) {
      header("Location: " . BASE_URL . "/post");
      exit;
    }

    $validated_data = Validator::setRules("create_post", $data, [
      "title" => ["required", "alpha_num_space", "min_length:5", "max_length:100"],
      "content" => ["required", "min_length:100", "max_length:10000"],
      "category_id" => ["required", "num"],
      "featured_image" => ["image|type:jpeg,png|max_size:20480"],
      "image_caption" => ["min_length:5", "max_length:200"]
    ]);

    $validated_data["featured_image"] = FileHandler::upload("featured_images", $validated_data["featured_image"], "default.jpg");

    $this->model("Post")->create($validated_data);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function update(array $data = [])
  {
    if (empty($data) || Auth::getUser()->id !== (int)$data["author_id"]) {
      header("Location: " . BASE_URL . "/post");
      exit;
    }

    $_SESSION["validation_id"] = $data["id"];

    $validated_data = Validator::setRules("update_post", $data, [
      "id" => ["required"],
      "old_title" => ["required"],
      "old_slug" => ["required"],
      "old_featured_image" => ["required"],
      "title" => ["required", "alpha_num_space", "min_length:5", "max_length:100"],
      "content" => ["required", "min_length:100", "max_length:10000"],
      "category_id" => ["required", "num"],
      "featured_image" => ["image|type:jpeg,png|max_size:10240"],
      "image_caption" => ["min_length:5", "max_length:200"]
    ]);

    $validated_data["featured_image"] = FileHandler::upload("featured_images", $validated_data["featured_image"], $validated_data["old_featured_image"]);

    $this->model("Post")->update($validated_data);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function setStatus(array $data = [])
  {
    if (empty($data) || Auth::getUser()->id !== (int)$data["author_id"]) {
      header("Location: " . BASE_URL . "/post");
      exit;
    }

    $this->model("Post")->setStatus($data);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  public function delete(array $data = [])
  {
    if (empty($data) || Auth::getUser()->id !== (int)$data["author_id"]) {
      header("Location: " . BASE_URL . "/post");
      exit;
    }

    $this->model("Post")->delete($data);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }
}
