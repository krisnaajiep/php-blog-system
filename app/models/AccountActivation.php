<?php

class AccountActivation extends Model
{
  private $table = "account_activations";

  public function __construct()
  {
    parent::__construct();
  }

  public function create(int $last_id)
  {
    $token = bin2hex(random_bytes(32));
    $expires = date("U") + 3600;

    $query = "INSERT INTO {$this->table} (user_account_id, token, expires) VALUES (:user_account_id, :token, :expires)";

    $this->prepare($query);
    $this->bind(":user_account_id", $last_id);
    $this->bind(":token", $token);
    $this->bind(":expires", $expires);

    $this->execute();

    $this->sendLink($last_id, $token);
  }

  private function sendLink(int $last_id, string $token)
  {
    $query = "SELECT email FROM user_accounts WHERE id = :id";

    $this->prepare($query);
    $this->bind(":id", $last_id);

    $this->execute();

    $email = $this->single()->email;

    $reset_link = BASE_URL . "/auth/activate/" . $token;
    $subject = "Email Activation Request";
    $message = "To activate your account, please click on the following link: $reset_link";

    mail($email, $subject, $message);
  }

  public function activate(string $token, $user_account)
  {
    $this->beginTransaction();

    try {
      $query = "SELECT user_account_id FROM {$this->table} WHERE token = :token";

      $this->prepare($query);
      $this->bind(":token", $token);

      $this->execute();

      if ($this->rowCount() === 0) throw new PDOException("Invalid or expired token.");

      $user_account_id = (int)$this->single()->user_account_id;

      $user_account->updateStatus($user_account_id);
      $this->delete($token);

      $this->commit();

      Flasher::setFlash("Your account has been activated.", "Please login.", "success");
    } catch (PDOException $e) {
      $this->rollback();

      Flasher::setFlash("", $e->getMessage(), "warning");
    }
  }

  private function delete(string $token)
  {
    $query = "DELETE FROM {$this->table} WHERE token = :token";

    $this->prepare($query);
    $this->bind(":token", $token);

    $this->execute();
  }

  public function __destruct()
  {
    $this->close();
  }
}
