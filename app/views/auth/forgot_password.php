<div class="mx-auto mb-5 text-center w-50">
  <h2 class="mb-0">Forgot Your Password?</h2>
  <p class="mb-0 mt-2 mb-4">Enter your email address and we'll send you a link to reset your password!</p>
  <?php Flasher::getFlash() ?>
  <form action="<?= BASE_URL; ?>/auth/sendResetPasswordLink" method="post" class="w-50 mx-auto mb-5">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <div class="form-floating mb-3">
      <input type="email" class="form-control <?= Validator::hasValidationError("send_reset_password_link", "email") ? "is-invalid" : ""; ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address" value="<?= Request::getOldData("email"); ?>" autofocus>
      <label for="email">Enter Email Address</label>
      <div class="invalid-feedback">
        <?= Validator::getValidationError("send_reset_password_link", "email"); ?>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mb-3 w-100">Submit</button>
    <div class="text-center">
      <a class="small" href="<?= BASE_URL; ?>/auth/signup">Create an Account!</a>
    </div>
    <div class="text-center">
      <a class="small" href="<?= BASE_URL; ?>/auth">Already have an account? Login!</a>
    </div>
  </form>
</div>