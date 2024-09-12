<?php

class Post extends Model
{
  private $table = "posts";

  public function __construct()
  {
    parent::__construct();
  }

  public function create(array $data)
  {
    $slug = Slug::createSlug($this->table, $data["title"]);

    try {
      $query = "INSERT INTO $this->table (title, slug, content, category_id, author_id, featured_image, image_caption)
                VALUES (:title, :slug, :content, :category_id, :author_id, :featured_image, :image_caption)";

      $this->prepare($query);
      $this->bind(":title", $data["title"]);
      $this->bind(":slug", $slug);
      $this->bind(":content", $data["content"]);
      $this->bind(":category_id", (int)$data["category_id"]);
      $this->bind(":author_id", Auth::getUser()->id);
      $this->bind(":featured_image", $data["featured_image"] ?? 'default.jpg');
      $this->bind(":image_caption", $data["image_caption"]);

      $this->execute();

      Flasher::setFlash("", "Creating new post successfully", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function getPostsByAuthor(array $filter, int $start = 0, int $limit = 0): array
  {
    $query = "SELECT $this->table.id,
                     $this->table.title,
                     $this->table.slug,
                     $this->table.content,
                     $this->table.category_id,
                     $this->table.author_id,
                     $this->table.featured_image,
                     $this->table.image_caption,
                     $this->table.published_at,
                     $this->table.created_at,
                     $this->table.updated_at,
                     $this->table.status,
                     categories.name as category_name,
                     user_accounts.username as author_username,
                     user_accounts.email as author_email,
                     user_profiles.full_name as author_name
             FROM $this->table
             JOIN categories ON $this->table.category_id = categories.id
             JOIN user_accounts ON $this->table.author_id = user_accounts.id
             JOIN user_profiles ON $this->table.author_id = user_profiles.user_account_id
             WHERE $this->table.author_id = :author_id";

    $keyword = isset($filter["keyword"]) ?  "%" . $filter["keyword"] . "%" : "";

    $query = $this->filter($filter, $query);

    $query .= " ORDER BY created_at DESC LIMIT :start, :limit";

    $this->prepareFilter($filter, $query, $keyword);

    $this->bind(":author_id", Auth::getUser()->id);
    $this->bind(":start", $start);
    $this->bind(":limit", $limit);

    $result_set = $this->resultSet();

    $query = "SELECT COUNT($this->table.id) as total FROM $this->table
              JOIN categories ON $this->table.category_id = categories.id
              JOIN user_accounts ON $this->table.author_id = user_accounts.id
              JOIN user_profiles ON $this->table.author_id = user_profiles.user_account_id
              WHERE $this->table.author_id = :author_id";

    $query = $this->filter($filter, $query);
    $this->prepareFilter($filter, $query, $keyword);
    $this->bind(":author_id", Auth::getUser()->id);

    Pagination::setPages($this->single()->total);

    return $result_set;
  }

  private function filter(array $filter, string $query): string
  {
    $condition = [];

    if (!empty($filter["keyword"])) $condition[] = "($this->table.title LIKE :title OR
                                                    categories.name LIKE :category_name OR
                                                    user_profiles.full_name LIKE :author_name)";
    if (!empty($filter["category_name"])) $condition[] = "categories.name = :category_name";
    if (!empty($filter["status"])) $condition[] = "$this->table.status = :status";
    if (!empty($filter["author_name"])) $condition[] = "user_profiles.full_name = :author_name";
    if (!empty($condition)) $query .= " AND " . implode(" AND ", $condition);

    return $query;
  }

  private function prepareFilter(array $filter, string $query, string $keyword)
  {
    $this->prepare($query);

    if (!empty($filter["keyword"])) $this->bind(":title", $keyword);
    if (!empty($filter["keyword"])) $this->bind(":category_name", $keyword);
    if (!empty($filter["keyword"])) $this->bind(":author_name", $keyword);
    if (!empty($filter["category_name"])) $this->bind(":category_name", $filter["category_name"]);
    if (!empty($filter["status"])) $this->bind(":status", $filter["status"]);
    if (!empty($filter["author_name"])) $this->bind(":author_name", $filter["author_name"]);
  }

  private function getOldDataBySlug(string $slug): object
  {
    $query = "SELECT content, category_id, image_caption FROM $this->table WHERE slug = :slug";

    $this->prepare($query);
    $this->bind(":slug", $slug);

    return $this->single();
  }

  public function getAllPosts(array $filter, int $start = 0, int $limit = 0)
  {
    $query = "SELECT $this->table.id,
                     $this->table.title,
                     $this->table.slug,
                     $this->table.content,
                     $this->table.featured_image,
                     $this->table.published_at,
                     categories.name as category_name,
                     user_profiles.full_name as author_name  
              FROM $this->table
              JOIN categories ON $this->table.category_id = categories.id
              JOIN user_accounts ON $this->table.author_id = user_accounts.id
              JOIN user_profiles ON $this->table.author_id = user_profiles.user_account_id
              WHERE $this->table.status = :status
              ";

    $keyword = isset($filter["keyword"]) ?  "%" . $filter["keyword"] . "%" : "";

    $query = $this->filter($filter, $query);

    $query .= " ORDER BY $this->table.published_at DESC LIMIT :start, :limit";

    $this->prepareFilter($filter, $query, $keyword);

    $status = "published";

    $this->bind(":status", $status);
    $this->bind(":start", $start);
    $this->bind(":limit", $limit);

    $result_set = $this->resultSet();

    $query = "SELECT COUNT($this->table.id) as total FROM $this->table
              JOIN categories ON $this->table.category_id = categories.id
              JOIN user_accounts ON $this->table.author_id = user_accounts.id
              JOIN user_profiles ON $this->table.author_id = user_profiles.user_account_id
              WHERE $this->table.status = :status";

    $query = $this->filter($filter, $query);
    $this->prepareFilter($filter, $query, $keyword);
    $this->bind(":status", $status);
    Pagination::setPages($this->single()->total);

    return $result_set;
  }

  public function getPostBySlug(string $slug)
  {
    $query = "SELECT $this->table.title,
                     $this->table.content,
                     $this->table.featured_image,
                     $this->table.image_caption,
                     $this->table.published_at,
                     categories.name as category_name,
                     user_profiles.full_name as author_name
                     FROM $this->table
                     JOIN categories ON $this->table.category_id = categories.id
                     JOIN user_profiles ON $this->table.author_id = user_profiles.user_account_id
                     WHERE $this->table.slug = :slug";

    $this->prepare($query);
    $this->bind(":slug", $slug);

    return $this->single();
  }

  public function update(array $data)
  {
    $old_data = $this->getOldDataBySlug($data["old_slug"]);

    try {
      if (
        $data["title"] === $data["old_title"] &&
        $data["content"] === $old_data->content &&
        $data["category_id"] == $old_data->category_id &&
        $data["featured_image"] === $data["old_featured_image"] &&
        $data["image_caption"] === $old_data->image_caption
      ) throw new PDOException("No data is changed", 2);

      $query = "UPDATE $this->table SET title = :title, 
                                        slug = :slug, 
                                        content = :content,
                                        category_id = :category_id,
                                        featured_image = :featured_image,
                                        image_caption = :image_caption
                                        WHERE id = :id";

      $slug = $data["title"] !== $data["old_title"] ? Slug::createSlug($this->table, $data["title"]) : $data["old_slug"];

      $this->prepare($query);
      $this->bind(":title", $data["title"]);
      $this->bind(":slug", $slug);
      $this->bind(":content", $data["content"]);
      $this->bind(":category_id", (int)$data["category_id"]);
      $this->bind(":featured_image", $data["featured_image"] ?? 'default.jpg');
      $this->bind(":image_caption", $data["image_caption"]);
      $this->bind(":id", (int)$data["id"]);

      $this->execute();

      Flasher::setFlash("", "Updating post successfully", "success");
    } catch (PDOException $e) {
      $type = $e->getCode() === 2 ? "warning" : "danger";
      Flasher::setFlash("", $e->getMessage(), $type);
    }
  }

  public function setStatus(array $data)
  {
    $published_at = date("Y-m-d");
    $status = $data["old_status"] !== "published" ? "published" : "archived";

    try {
      $query = "UPDATE $this->table SET published_at = :published_at, status = :status WHERE slug = :slug";

      $this->prepare($query);
      $this->bind(":published_at", $published_at);
      $this->bind(":status", $status);
      $this->bind(":slug", $data["slug"]);

      $this->execute();

      $action = $data["old_status"] !== "published" ?  "Publishing" : "Archive";

      Flasher::setFlash("", $action . " post successfully", "success");
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

      FileHandler::remove("image", "featured_images", $data["featured_image"]);

      Flasher::setFlash("", "Deleting post successfully", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function __destruct()
  {
    $this->close();
  }
}
