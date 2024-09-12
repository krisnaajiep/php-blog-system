<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editProfileModalLabel">Edit Profile</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <form action="<?= BASE_URL; ?>/user/updateProfile" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
          <div class="image text-center mb-3">
            <img src="<?= BASE_URL; ?>/assets/img/profile_pictures/<?= Auth::getUser()->profile_picture; ?>" alt="" class="img-preview rounded-circle mb-3" width="200">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Profile Picture</label>
            <input class="form-control <?= Validator::hasValidationError("update_profile", "profile_picture") ? "is-invalid" : ""; ?>" type="file" id="image" name="profile_picture">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_profile", "profile_picture"); ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="full_name" class="col-form-label">Full Name:</label>
            <input type="text" class="form-control <?= Validator::hasValidationError("update_profile", "full_name") ? "is-invalid" : ""; ?>" id="full_name" name="full_name" value="<?= Request::getOldData("full_name") ?? Auth::getUser()->full_name ?>">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_profile", "full_name"); ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="phone_number" class="col-form-label">Phone Number:</label>
            <input type="text" class="form-control <?= Validator::hasValidationError("update_profile", "phone_number") ? "is-invalid" : ""; ?>" id="phone_number" name="phone_number" value="<?= Request::getOldData("phone_number") ?? Auth::getUser()->phone_number ?>">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_profile", "phone_number") ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="address" class="col-form-label">Address:</label>
            <textarea class="form-control <?= Validator::hasValidationError("update_profile", "address") ? "is-invalid" : ""; ?>" id="address" name="address"><?= Request::getOldData("address") ?? Auth::getUser()->address ?></textarea>
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_profile", "address"); ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="bio" class="col-form-label">Bio:</label>
            <textarea class="form-control <?= Validator::hasValidationError("update_profile", "bio") ? "is-invalid" : ""; ?>" id="bio" name="bio"><?= Request::getOldData("bio") ?? Auth::getUser()->bio ?></textarea>
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_profile", "bio"); ?>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>