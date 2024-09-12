<?php

class UserProfile extends Model
{
  private $table = "user_profiles";

  public function __construct()
  {
    parent::__construct();
  }

  public function create(int $last_id)
  {
    $query = "INSERT INTO $this->table (user_account_id, profile_picture) VALUES (:user_account_id, :profile_picture)";

    $this->prepare($query);
    $this->bind(":user_account_id", $last_id);
    $this->bind(":profile_picture", "default.jpg");

    $this->execute();
  }

  public function update(array $data)
  {
    try {
      $query = "UPDATE $this->table SET 
                full_name = :full_name,
                phone_number = :phone_number,
                address = :address,
                bio = :bio,
                profile_picture = :profile_picture
                WHERE user_account_id = :user_account_id";

      $this->prepare($query);
      $this->bind(":full_name", $data["full_name"]);
      $this->bind(":phone_number", $data["phone_number"]);
      $this->bind(":address", $data["address"]);
      $this->bind(":bio", $data["bio"]);
      $this->bind(":profile_picture", $data["profile_picture"]);
      $this->bind(":user_account_id", Auth::getUser()->id);

      $this->execute();

      Flasher::setFlash("", "Updating profile successfully.", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "danger");
    }
  }

  public function __destruct()
  {
    $this->close();
  }
}
