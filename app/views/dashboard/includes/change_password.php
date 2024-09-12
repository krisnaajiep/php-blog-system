<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <form action="<?= BASE_URL; ?>/user/updatePassword" method="post">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
          <div class="mb-3">
            <label for="old_password" class="form-label">Old Password</label>
            <input type="password" class="form-control <?= Validator::hasValidationError("update_password", "old_password") ? "is-invalid" : ""; ?>" id="old_password" name="old_password" placeholder="Old Password">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_password", "old_password"); ?>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-6">
              <label for="new_password" class="form-label">New Password</label>
              <input type="password" class="form-control <?= Validator::hasValidationError("update_password", "new_password") ? "is-invalid" : ""; ?>" id="new_password" name="new_password" placeholder="New Password">
              <div class="invalid-feedback">
                <?= Validator::getValidationError("update_password", "new_password"); ?>
              </div>
            </div>
            <div class="col-6">
              <label for="repeat_new_password" class="form-label">Repeat New Password</label>
              <input type="password" class="form-control <?= Validator::hasValidationError("update_password", "repeat_new_password") ? "is-invalid" : ""; ?>" id="repeat_new_password" name="repeat_new_password" placeholder="Repeat New Password">
              <div class="invalid-feedback">
                <?= Validator::getValidationError("update_password", "repeat_new_password"); ?>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>