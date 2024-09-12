<div class="mx-auto mb-5 text-center w-50">
  <h2 class="my-4">Reset Password</h2>
  <?php Flasher::getFlash() ?>
  <form action="<?= BASE_URL; ?>/auth/updatePassword" method="post" class="w-50 mx-auto mb-5">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="token" id="token" value="<?= $data["token"]; ?>">
    <div class="form-floating mb-3">
      <input type="password" class="form-control <?= Validator::hasValidationError("reset_password", "new_password") ? "is-invalid" : ""; ?>" id="new_password" name="new_password" aria-describedby="newPasswordHelp" placeholder="Enter New Password" autofocus>
      <label for="new_password">Enter New Password</label>
      <div class="invalid-feedback">
        <?= Validator::getValidationError("reset_password", "new_password"); ?>
      </div>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control <?= Validator::hasValidationError("reset_password", "repeat_new_password") ? "is-invalid" : ""; ?>" id="repeat_new_password" name="repeat_new_password" aria-describedby="repeatNewPasswordHelp" placeholder="Repeat New Password" autofocus>
      <label for="repeat_new_password">Repeat New Password</label>
      <div class="invalid-feedback">
        <?= Validator::getValidationError("reset_password", "repeat_new_password"); ?>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mb-3 w-100">Reset</button>
  </form>
</div>