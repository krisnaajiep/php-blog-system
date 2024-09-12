<!-- Edit Post Modal -->
<div class="modal fade" id="editPostModal<?= $post->id; ?>" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editPostModalLabel">Edit Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <form action="<?= BASE_URL; ?>/post/update" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
          <input type="hidden" name="id" value="<?= $post->id; ?>">
          <input type="hidden" name="old_title" value="<?= $post->title; ?>">
          <input type="hidden" name="old_slug" value="<?= $post->slug; ?>">
          <input type="hidden" name="author_id" value="<?= $post->author_id; ?>">
          <input type="hidden" name="old_featured_image" value="<?= $post->featured_image; ?>">
          <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control <?= Request::getOldData("id") == $post->id && Validator::hasValidationError("update_post", "title") ? "is-invalid" : ""; ?>" name="title" id="title" value="<?= Request::getOldData("id") === $post->id ? Request::getOldData("title") : $post->title ?>">
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_post", "title"); ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea class="form-control <?= Request::getOldData("id") == $post->id && Validator::hasValidationError("update_post", "content") ? "is-invalid" : ""; ?>" name="content" id="content"><?= Request::getOldData("id") === $post->id ? Request::getOldData("content") : $post->content ?></textarea>
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_post", "content"); ?>
            </div>
          </div>
          <div class="mb-3">
            <select class="form-select <?= Request::getOldData("id") == $post->id && Validator::hasValidationError("update_post", "category_id") ? "is-invalid" : ""; ?>" name="category_id" aria-label="Category select">
              <option value="" selected>Select Post Category</option>
              <?php foreach ($data["categories"] as $category): ?>
                <option value="<?= $category->id; ?>" <?= Request::getOldData("id") === $post->id && Request::getOldData("category_id") == $category->id ? "selected" : ($post->category_id === $category->id ? "selected" : "") ?>><?= $category->name; ?></option>
              <?php endforeach ?>
            </select>
            <div class="invalid-feedback">
              <?= Validator::getValidationError("update_post", "category_id"); ?>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="image" class="form-label">Featured Image</label>
              <input class="form-control <?= Request::getOldData("id") == $post->id && Validator::hasValidationError("update_post", "featured_image") ? "is-invalid" : ""; ?>" type="file" name="featured_image" id="image">
              <div class="invalid-feedback">
                <?= Validator::getValidationError("update_post", "featured_image"); ?>
              </div>
            </div>
            <div class="col-md-6">
              <label for="image_caption" class="form-label">Image Caption:</label>
              <input type="text" class="form-control <?= Request::getOldData("id") == $post->id && Validator::hasValidationError("update_post", "image_caption") ? "is-invalid" : ""; ?>" name="image_caption" id="image_caption" value="<?= Request::getOldData("id") === $post->id ? Request::getOldData("image_caption") : $post->image_caption; ?>">
              <div class="invalid-feedback">
                <?= Validator::getValidationError("update_post", "image_caption"); ?>
              </div>
            </div>
          </div>
          <div class="text-center">
            <img src="<?= BASE_URL; ?>/assets/img/featured_images/<?= $post->featured_image; ?>" alt="<?= $post->featured_image; ?>" class="img-preview" width="1088">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="store" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>