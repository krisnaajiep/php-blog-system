<div class="w-25 m-auto">
  <h2 class="text-center mb-4">Sign In</h2>
  <?php Flasher::getFlash() ?>
  <form action="<?= BASE_URL; ?>/auth/login" method="post" class="align-self-center mb-5">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <div class="form-floating mb-3">
      <input type="text" class="form-control <?= Validator::hasValidationError("login", "username") ? "is-invalid" : ""; ?>" id="username" name="username" aria-describedby="usernameHelp" placeholder="Enter Username" value="<?= Request::getOldData("username"); ?>" autofocus>
      <label for="username">Enter Username</label>
      <div class="invalid-feedback">
        <?= Validator::getValidationError("login", "username"); ?>
      </div>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control <?= Validator::hasValidationError("login", "password") ? "is-invalid" : ""; ?>" id="password" name="password" placeholder="Enter Password">
      <label for="password">Enter Password</label>
      <div class="invalid-feedback">
        <?= Validator::getValidationError("login", "password"); ?>
      </div>
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
      <label class="form-check-label" for="remember_me">Remember Me</label>
    </div>
    <button type="submit" class="btn btn-primary mb-3 w-100">Sign In</button>
    <div class="text-center">
      <a class="small" href="<?= BASE_URL; ?>/auth/forgotPassword">Forgot password?</a>
    </div>
    <div class="text-center">
      <a class="small" href="<?= BASE_URL; ?>/auth/signup">Create an Account!</a>
    </div>
  </form>
</div>