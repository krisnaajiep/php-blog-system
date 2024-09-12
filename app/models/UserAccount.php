<?php

class UserAccount extends Model
{
  private $table = "user_accounts";

  public function __construct()
  {
    parent::__construct();
  }

  public function create(array $data, $user_profile, $account_activation): bool
  {
    $password = password_hash($data["password"], PASSWORD_DEFAULT);

    $this->beginTransaction();

    try {
      $query = "INSERT INTO $this->table (username, email, password) VALUES (:username, :email, :password)";

      $this->prepare($query);
      $this->bind(":username", $data["username"]);
      $this->bind(":email", $data["email"]);
      $this->bind(":password", $password);

      $this->execute();

      $last_id = (int)$this->lastInsertId();

      $user_profile->create($last_id);
      // $account_activation->create($last_id);

      $this->commit();

      Flasher::setFlash("Your account registered successfully.", "Please login.", "success");

      return true;
    } catch (PDOException $e) {
      $this->rollback();

      Flasher::setFlash("Error inserting data: ", $e->getMessage(), "danger");

      return false;
    }
  }

  public function updateStatus(int $id)
  {
    $status = "active";

    $query = "UPDATE $this->table SET status = :status WHERE id = :id";

    $this->prepare($query);
    $this->bind(":status", $status);
    $this->bind(":id", $id);

    $this->execute();
  }

  public function deleteExpiredInactiveAccounts()
  {
    $status = "inactive";
    $now = date("U");

    $query = "DELETE FROM {$this->table} WHERE status = :status AND id IN (
                SELECT user_account_id FROM account_activations WHERE expires < :now
              )";

    $this->prepare($query);
    $this->bind(":status", $status);
    $this->bind(":now", $now);

    $this->execute();
  }

  public function getUserIdForPasswordReset(string $email): int
  {
    $query = "SELECT id, status FROM $this->table WHERE BINARY email = :email";

    $this->prepare($query);
    $this->bind(":email", $email);

    $this->execute();

    if ($this->rowCount() === 0) throw new PDOException("Email is not registered");

    if ($this->single()->status === "inactive") {
      throw new PDOException("Your account is inactive. Please activate your account first");
    } elseif ($this->single()->status === "banned") {
      throw new PDOException("Your account is banned. Please contact the moderator or admin");
    }

    return $this->single()->id;
  }

  public function resetPassword(int $id, string $new_password)
  {
    $password = password_hash($new_password, PASSWORD_DEFAULT);

    $query = "UPDATE $this->table SET password = :password WHERE id = :id";

    $this->prepare($query);
    $this->bind(":password", $password);
    $this->bind(":id", $id);

    $this->execute();
  }

  public function getUserForLogin(array $data): int|false
  {
    try {
      $query = "SELECT id, username, password, status FROM {$this->table} WHERE BINARY username = :username";

      $this->prepare($query);
      $this->bind(":username", $data["username"]);

      $this->execute();

      if ($this->rowCount() === 0 || !password_verify($data["password"], $this->single()->password))
        throw new PDOException("Invalid username or password.");

      if ($this->single()->status === "inactive")
        throw new PDOException("Your account is inactive. Please Check your email to activate your account.");

      if ($this->single()->status === "banned")
        throw new PDOException("Your account is got banned. Please contact the moderator or admin");

      return $this->single()->id;
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "warning");

      return false;
    }
  }

  public function update(array $data)
  {
    try {
      $query = "UPDATE {$this->table} SET username = :username, email = :email WHERE id = :id";

      $this->prepare($query);
      $this->bind(":username", $data["username"]);
      $this->bind(":email", $data["email"]);
      $this->bind(":id", Auth::getUser()->id);

      $this->execute();

      Flasher::setFlash("", "Updating account successfully.", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function updatePassword(string $new_password)
  {
    $password = password_hash($new_password, PASSWORD_DEFAULT);

    try {
      $query = "UPDATE $this->table SET password = :password WHERE id = :id";

      $this->prepare($query);
      $this->bind(":password", $password);
      $this->bind(":id", Auth::getUser()->id);

      $this->execute();

      Flasher::setFlash("", "Updating password successfully.", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function updateRole(array $data)
  {
    $old_role_id = (int)$data["old_role_id"];
    $old_role_name = $data["old_role_name"];
    $role_id = (int)$data["role_id"];

    try {
      if ($old_role_id === $role_id) throw new PDOException("This user is already a $old_role_name", 2);

      if ($role_id === 2) {
        $query = "SELECT id FROM $this->table WHERE role_id = :role_id";
        $this->prepare($query);
        $this->bind(":role_id", $role_id);

        $this->execute();

        if ($this->rowCount() === 1) throw new PDOException("Cannot be more than 1 moderator", 2);
      }

      $query = "UPDATE $this->table SET role_id = :role_id WHERE username = :username";

      $this->prepare($query);
      $this->bind(":role_id", $role_id);
      $this->bind(":username", $data["username"]);

      $this->execute();

      Flasher::setFlash("", "Updating user role successfully", "success");
    } catch (PDOException $e) {
      $type = $e->getCode() === 2 ? "warning" : "danger";
      Flasher::setFlash("", $e->getMessage(), $type);
    }
  }

  public function ban(array $data)
  {
    try {
      $status = $data["status"] === "active" ? "banned" : ($data["status"] === "banned" ? "active" : throw new PDOException("This user is inactive", 2));

      if ($data["role_name"] === "Admin") throw new PDOException("Admin cannot be banned", 2);

      if ($data["username"] === Auth::getUser()->username) throw new PDOException("Cannot ban your own account", 2);

      $query = "UPDATE $this->table SET status = :status WHERE username = :username";

      $this->prepare($query);
      $this->bind(":status", $status);
      $this->bind(":username", $data["username"]);

      $this->execute();

      $action = $status === "banned" ? "Banning" : "Unbanning";

      Flasher::setFlash("", $action . " user successfully", "success");
    } catch (PDOException $e) {
      $type = $e->getCode() === 2 ? "warning" : "danger";
      Flasher::setFlash("", $e->getMessage(), $type);
    }
  }

  public function delete(array $data): bool
  {
    try {
      $query = "DELETE FROM {$this->table} WHERE username = :username";

      $this->prepare($query);
      $this->bind(":username", $data["username"]);

      $this->execute();

      FileHandler::remove("image", "profile_pictures", $data["profile_picture"]);

      Flasher::setFlash("", "Deleting account successfully.", "success");

      return true;
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");

      return false;
    }
  }

  public function getAllUsers(array $filter, int $start = 0, int $limit = 0)
  {
    $query = "SELECT $this->table.id, 
                     $this->table.username,
                     $this->table.email,
                     $this->table.role_id,
                     $this->table.status,
                     $this->table.created_at,
                     $this->table.updated_at,
                     user_roles.name as role_name,
                     user_profiles.full_name,
                     user_profiles.phone_number,
                     user_profiles.address,
                     user_profiles.bio,
                     user_profiles.profile_picture 
              FROM {$this->table} 
              JOIN user_roles ON {$this->table}.role_id = user_roles.id
              JOIN user_profiles ON {$this->table}.id = user_profiles.user_account_id";

    $keyword = isset($filter["keyword"]) ?  "%" . $filter["keyword"] . "%" : "";

    $query = $this->filter($filter, $query);
    $query .= " LIMIT :start, :limit";

    $this->prepareFilter($filter, $query, $keyword);

    $this->bind(":start", $start);
    $this->bind(":limit", $limit);

    $result_set = $this->resultSet();

    $query = "SELECT COUNT($this->table.id) as total FROM $this->table
              JOIN user_roles ON $this->table.role_id = user_roles.id
              JOIN user_profiles ON $this->table.id = user_profiles.user_account_id";

    $query = $this->filter($filter, $query);
    $this->prepareFilter($filter, $query, $keyword);

    Pagination::setPages($this->single()->total);

    return $result_set;
  }

  private function filter(array $filter, string $query): string
  {
    $condition = [];

    if (!empty($filter["keyword"])) {
      $condition[] = "(user_profiles.full_name LIKE :full_name OR $this->table.username LIKE :username)";
    }

    if (!empty($filter["role"])) $condition[] = "user_roles.name = :role";
    if (!empty($filter["status"])) $condition[] = "$this->table.status = :status";
    if (!empty($condition)) $query .= " WHERE " . implode(" AND ", $condition);

    return $query;
  }

  private function prepareFilter(array $filter, string $query, string $keyword)
  {
    $this->prepare($query);

    if (!empty($filter["keyword"])) {
      $this->bind(":full_name", $keyword);
      $this->bind(":username", $keyword);
    }

    if (!empty($filter["role"])) $this->bind(":role", $filter["role"]);
    if (!empty($filter["status"])) $this->bind(":status", $filter["status"]);
  }

  public function __destruct()
  {
    $this->close();
  }
}
