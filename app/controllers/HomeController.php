<?php

class HomeController extends Controller
{
  public function index(): string
  {
    $limit = (Request::get("page") == 1 || empty(Request::get("page"))) ? 7 : 6;
    Pagination::setLimit($limit);
    $start = Pagination::getStart();
    $data["posts"] = $this->model("Post")->getAllPosts(Request::get(), $start, $limit);
    $data["posts"] = array_reverse($data["posts"]);

    return $this->view("layouts/header")
      . $this->view("home/index", $data)
      . $this->view("layouts/footer");
  }

  public function post(string $slug = null): string
  {
    if (is_null($slug)) {
      header("Location: " . BASE_URL);
      exit;
    }

    $data["post"] = $this->model("Post")->getPostBySlug($slug);

    if (!$data["post"]) {
      header("Location: " . BASE_URL);
      exit;
    }

    return $this->view("layouts/header")
      . $this->view("home/post", $data)
      . $this->view("layouts/footer");
  }

  public function categories(): string
  {
    $data["categories"] = $this->model("Category")->getAllCategories();

    return $this->view("layouts/header")
      . $this->view("home/categories", $data)
      . $this->view("layouts/footer");
  }
}
