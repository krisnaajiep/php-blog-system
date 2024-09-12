<div class="row mb-4">
  <div class="col">
    <h2>Account Settings</h2>
  </div>
  <div class="col text-end">
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
    <?php include_once "includes/change_password.php" ?>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</button>
    <?php include_once "includes/delete_account.php" ?>
  </div>
</div>
<?php Flasher::getFlash() ?>
<div class="bg-white p-3">
  <form action="<?= BASE_URL; ?>/user/updateAccount" method="post" class="w-50">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control <?= Validator::hasValidationError("update_account", "username") ? "is-invalid" : ""; ?>" id="username" name="username" placeholder="Username" value="<?= Request::getOldData("username") ?? Auth::getUser()->username ?>">
      <div class="invalid-feedback">
        <?= Validator::getValidationError("update_account", "username"); ?>
      </div>
    </div>
    <div class="mb-4">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control <?= Validator::hasValidationError("update_account", "email") ? "is-invalid" : ""; ?>" id="email" name="email" placeholder="Email Address" value="<?= Request::getOldData("email") ?? Auth::getUser()->email ?>">
      <div class="invalid-feedback">
        <?= Validator::getValidationError("update_account", "email"); ?>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
  </form>
</div>