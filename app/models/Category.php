<?php

class Category extends Model
{
  private $table = "categories";

  public function __construct()
  {
    parent::__construct();
  }

  public function create(array $data)
  {
    $slug = Slug::createSlug($this->table, $data["name"]);

    try {
      $query = "INSERT INTO $this->table (name, slug, thumbnail) VALUES (:name, :slug, :thumbnail)";

      $this->prepare($query);
      $this->bind(":name", $data["name"]);
      $this->bind(":slug", $slug);
      $this->bind(":thumbnail", $data["thumbnail"]);

      $this->execute();

      Flasher::setFlash("", "Creating new category successfully", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function getAllCategories(): array
  {
    $query = "SELECT * FROM $this->table";

    if (!empty(Request::get("category_keyword"))) $query .= " WHERE name LIKE :name";

    $query .= " ORDER BY created_at DESC";

    $this->prepare($query);

    if (!empty(Request::get("category_keyword"))) {
      $category_keyword = "%" . Request::get("category_keyword") . "%";
      $this->bind(":name", $category_keyword);
    }

    return $this->resultSet();
  }

  public function update(array $data)
  {
    $slug = $data["name"] !== $data["old_name"] ? Slug::createSlug($this->table, $data["name"]) : $data["old_slug"];

    try {
      $query = "UPDATE $this->table SET name = :name, slug = :slug, thumbnail = :thumbnail WHERE id = :id";

      $this->prepare($query);
      $this->bind(":name", $data["name"]);
      $this->bind(":slug", $slug);
      $this->bind(":thumbnail", $data["thumbnail"]);
      $this->bind(":id", (int)$data["id"]);

      $this->execute();

      Flasher::setFlash("", "Updating category successfully", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function delete(array $data)
  {
    try {
      $query = "DELETE FROM $this->table WHERE slug = :slug";

      $this->prepare($query);
      $this->bind(":slug", $data["slug"]);

      $this->execute();

      FileHandler::remove("image", "category_thumbnails", $data["thumbnail"]);

      Flasher::setFlash("", "Deleting category successfully", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function __destruct()
  {
    $this->close();
  }
}
