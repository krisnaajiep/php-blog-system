<div class="w-50 m-auto">
  <h2 class="text-center mb-4">Sign Up</h2>
  <?php Flasher::getFlash() ?>
  <form action="<?= BASE_URL; ?>/auth/register" method="post" class="align-self-center mb-5">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <div class="form-floating mb-3">
      <input type="text" class="form-control <?= Validator::hasValidationError("register", "username") ? "is-invalid" : ""; ?>" name="username" id="username" aria-describedby="usernameHelp" placeholder="Enter Username" value="<?= Request::getOldData("username"); ?>" autofocus>
      <label for="username">Enter Username</label>
      <div class="invalid-feedback">
        <?= Validator::getValidationError("register", "username"); ?>
      </div>
    </div>
    <div class="form-floating mb-3">
      <input type="email" class="form-control <?= Validator::hasValidationError("register", "email") ? "is-invalid" : ""; ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address" value="<?= Request::getOldData("email"); ?>">
      <label for="email">Enter Email Address</label>
      <div class="invalid-feedback">
        <?= Validator::getValidationError("register", "email"); ?>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="form-floating mb-3">
          <input type="password" class="form-control <?= Validator::hasValidationError("register", "password") ? "is-invalid" : ""; ?>" name="password" id="password" placeholder="Enter Password">
          <label for="password">Enter Password</label>
          <div class="invalid-feedback">
            <?= Validator::getValidationError("register", "password"); ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-floating">
          <input type="password" class="form-control <?= Validator::hasValidationError("register", "repeat_password") ? "is-invalid" : ""; ?>" name="repeat_password" id="repeat_password" placeholder="Repeat Password">
          <label for="repeat_password">Repeat Password</label>
          <div class="invalid-feedback">
            <?= Validator::getValidationError("register", "repeat_password"); ?>
          </div>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mb-3 w-100">Sign Up</button>
    <div class="text-center">
      <a class="small" href="<?= BASE_URL; ?>/auth/forgotPassword">Forgot password?</a>
    </div>
    <div class="text-center">
      <a class="small" href="<?= BASE_URL; ?>/auth">Already have an account? Login!</a>
    </div>
  </form>
</div>