<?php

class PasswordReset extends Model
{
  private $table = "password_resets";

  public function __construct()
  {
    parent::__construct();
  }

  public function create(string $email, $user_account)
  {
    try {
      $user_account_id = $user_account->getUserIdForPasswordReset($email);

      $token = bin2hex(random_bytes(32));
      $expires = date("U") + 3600;

      $query = "INSERT INTO {$this->table} (user_account_id, token, expires) VALUES (:user_account_id, :token, :expires)";

      $this->prepare($query);
      $this->bind(":user_account_id", $user_account_id);
      $this->bind(":token", $token);
      $this->bind(":expires", $expires);

      $this->execute();

      $this->sendLink($user_account_id, $token);

      Flasher::setFlash("Reser password link has been sended.", "Please check your email", "success");
    } catch (PDOException $e) {
      Flasher::setFlash("", $e->getMessage(), "warning");
    }
  }

  private function sendLink(int $user_account_id, string $token)
  {
    $query = "SELECT email FROM user_accounts WHERE id = :id";

    $this->prepare($query);
    $this->bind(":id", $user_account_id);

    $this->execute();

    $email = $this->single()->email;

    $reset_link = BASE_URL . "/auth/resetPassword/" . $token;
    $subject = "Password Reset Request";
    $message = "To reset your password, please click on the following link: $reset_link";

    mail($email, $subject, $message);
  }

  public function reset(string $token, $new_password, $user_account)
  {
    $this->beginTransaction();

    try {
      $query = "SELECT user_account_id FROM {$this->table} WHERE token = :token";

      $this->prepare($query);
      $this->bind(":token", $token);

      $this->execute();

      if ($this->rowCount() === 0) throw new PDOException("Invalid or expired token");

      $user_account_id = $this->single()->user_account_id;

      $user_account->resetPassword($user_account_id, $new_password);
      $this->delete($token);

      $this->commit();

      Flasher::setFlash("Your password has been resetted.", "Please login.", "success");

      return true;
    } catch (PDOException $e) {
      $this->rollback();

      Flasher::setFlash("", $e->getMessage(), "warning");

      return false;
    }
  }

  private function delete(string $token)
  {
    $query = "DELETE FROM {$this->table} WHERE token = :token";

    $this->prepare($query);
    $this->bind(":token", $token);

    $this->execute();
  }

  public function deleteExpiredTokens()
  {
    $now = date("U");

    $query = "DELETE FROM {$this->table} WHERE expires < :now";

    $this->prepare($query);
    $this->bind(":now", $now);

    $this->execute();
  }

  public function __destruct()
  {
    $this->close();
  }
}
