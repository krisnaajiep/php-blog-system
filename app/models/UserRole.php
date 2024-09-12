<?php

class UserRole extends Model
{
  private $table = "user_roles";

  public function __construct()
  {
    parent::__construct();

    try {
      $this->prepare("SHOW TABLES LIKE :table");
      $this->bind(":table", $this->table);
      if (!$this->single()) $this->createTable();

      $this->prepare("SELECT id FROM $this->table");
      $this->execute();
      if ($this->rowCount() === 0) $this->create();
    } catch (PDOException $e) {
      die("Error: " . $e->getMessage());
    }
  }

  private function createTable()
  {
    $this->prepare("CREATE TABLE $this->table (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(50) NOT NULL
                  )");

    $this->execute();
  }

  private function create()
  {
    $query = "INSERT INTO {$this->table} (id, name) VALUES (:id, :name)";
    $this->prepare($query);

    $data = [
      [1, "Admin"],
      [2, "Moderator"],
      [3, "User"]
    ];

    foreach ($data as $row) {
      $id = $row[0];
      $name = $row[1];
      $this->bind(":id", $id);
      $this->bind(":name", $name);
      $this->execute();
    }
  }

  public function getAllRolesWhereNotAdmin(): array
  {
    $query = "SELECT * FROM $this->table WHERE NOT name = 'Admin'";

    $this->prepare($query);

    return $this->resultSet();
  }

  public function __destruct()
  {
    $this->close();
  }
}
