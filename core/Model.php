<?php

class Model
{
  private $stmt, $dbh;

  public function __construct()
  {
    try {
      $this->dbh = new PDO("mysql:host=" . DB_HOST . ";", DB_USER, DB_PASS, [PDO::ATTR_PERSISTENT => true]);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->prepare("SHOW DATABASES LIKE :dbname");
      $this->bind(":dbname", DB_NAME);
      if (!$this->single()) $this->createDB(DB_NAME);

      $this->exec("USE " . DB_NAME);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  protected function beginTransaction()
  {
    $this->dbh->beginTransaction();
  }

  protected function commit()
  {
    $this->dbh->commit();
  }

  protected function rollback()
  {
    $this->dbh->rollBack();
  }

  protected function exec(string $query)
  {
    $this->dbh->exec($query);
  }

  public function prepare(string $query)
  {
    $this->stmt = $this->dbh->prepare($query);
  }

  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;

        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;

        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;

        default:
          $type = PDO::PARAM_STR;
          break;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute()
  {
    $this->stmt->execute();
  }

  protected function lastInsertId(): string|false
  {
    return $this->dbh->lastInsertId();
  }

  protected function resultSet()
  {
    $this->execute();

    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function single()
  {
    $this->execute();

    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  public function close()
  {
    $this->dbh = null;
  }

  private function createDB($dbname)
  {
    $this->prepare("CREATE DATABASE $dbname");
    $this->execute();
  }
}
