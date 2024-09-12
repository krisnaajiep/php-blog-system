<!-- Post Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterModalLabel">Post Filter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <form role="search" method="get">
          <div class="mb-3">
            <label for="keyword" class="form-label">Keyword:</label>
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= Request::get("keyword"); ?>">
          </div>
          <div class="mb-3">
            <label for="role" class="col-form-label">Category:</label>
            <select class="form-select" name="category_name" aria-label="Role select example">
              <option value="" selected>Choose category...</option>
              <?php foreach ($data["categories"] as $category): ?>
                <option value="<?= $category->name; ?>" <?= Request::get("category_name") === $category->name ? "selected" : "" ?>><?= $category->name; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="col-form-label">Status:</label>
            <select class="form-select" name="status" aria-label="Role select example">
              <option value="" selected>Choose status...</option>
              <option value="draft" <?= Request::get("status") === "draft" ? "selected" : "" ?>>draft</option>
              <option value="published" <?= Request::get("status") === "published" ? "selected" : "" ?>>published</option>
              <option value="archived" <?= Request::get("status") === "archived" ? "selected" : "" ?>>archived</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <a href="<?= BASE_URL; ?>/post" class="btn btn-secondary">Reset</a>
        <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>
  </div>
</div>