<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal<?= $category->id; ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editCategoryModalLabel">Edit Post Categories</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <form action="<?= BASE_URL; ?>/category/update" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
          <input type="hidden" name="id" value="<?= $category->id; ?>">
          <input type="hidden" name="old_name" value="<?= $category->name; ?>">
          <input type="hidden" name="old_slug" value="<?= $category->slug; ?>">
          <input type="hidden" name="old_thumbnail" value="<?= $category->thumbnail; ?>">
          <div class="image text-center mb-3">
            <img src="<?= BASE_URL; ?>/assets/img/category_thumbnails/<?= $category->thumbnail; ?>" alt="" class="img-preview rounded mb-3" width="200">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Thumbnail</label>
            <input class="form-control <?= Request::getOldData("id") == $category->id && Validator::hasValidationError("update_category", "thumbnail") ? "is-invalid" : ""; ?>" type="file" id="image" name="thumbnail">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_category", "thumbnail"); ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="name" class="col-form-label">Name:</label>
            <input type="text" class="form-control <?= Request::getOldData("id") == $category->id && Validator::hasValidationError("update_category", "name") ? "is-invalid" : ""; ?>" id="name" name="name" value="<?= Request::getOldData("id") === $category->id ? Request::getOldData("name") : $category->name ?>">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_category", "name"); ?>
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