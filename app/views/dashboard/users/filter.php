<!-- User Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterModalLabel">User Filter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <form role="search" method="get">
          <div class="mb-3">
            <label for="keyword" class="form-label">Keyword:</label>
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= Request::get("keyword"); ?>">
          </div>
          <div class="mb-3">
            <label for="role" class="col-form-label">Role:</label>
            <select class="form-select" name="role" aria-label="Role select example">
              <option value="" selected>Choose role...</option>
              <option value="Admin" <?= Request::get("role") === "Admin" ? "selected" : "" ?>>Admin</option>
              <?php foreach ($data["roles"] as $role): ?>
                <option value="<?= $role->name; ?>" <?= Request::get("role") === $role->name ? "selected" : "" ?>><?= $role->name; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="col-form-label">Status:</label>
            <select class="form-select" name="status" aria-label="Role select example">
              <option value="" selected>Choose status...</option>
              <option value="active" <?= Request::get("status") === "active" ? "selected" : "" ?>>active</option>
              <option value="inactive" <?= Request::get("status") === "inactive" ? "selected" : "" ?>>inactive</option>
              <option value="banned" <?= Request::get("status") === "banned" ? "selected" : "" ?>>banned</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <a href="<?= BASE_URL; ?>/user" class="btn btn-secondary">Reset</a>
        <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>
  </div>
</div>