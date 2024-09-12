<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createCategoryModalLabel">Create New Post Categories</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <form action="<?= BASE_URL; ?>/category/create" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
          <div class="image text-center mb-3">
            <img src="<?= BASE_URL; ?>/assets/img/category_thumbnails/default.jpg" alt="default.jpg" class="img-preview rounded mb-3" width="200">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Thumbnail</label>
            <input class="form-control <?= Validator::hasValidationError("create_category", "thumbnail") ? "is-invalid" : ""; ?>" type="file" id="image" name="thumbnail">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("create_category", "thumbnail"); ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="name" class="col-form-label">Name:</label>
            <input type="text" class="form-control <?= Validator::hasValidationError("create_category", "name") ? "is-invalid" : ""; ?>" id="name" name="name" value="<?= empty(Request::getOldData("id")) ? Request::getOldData("name") : ""; ?>">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("create_category", "name"); ?>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>