<?php

class UserRole extends Model
{
  private $table = "user_roles";

  public function __construct()
  {
    parent::__construct();
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
