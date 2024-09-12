<div class="row">
  <div class="col">
    <h2 class="mb-4"><?= Auth::getUser()->full_name; ?> Posts</h2>
  </div>
  <div class="col text-end">
    <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#filterModal"><i class="bi bi-filter"></i> Filter</button>
    <?php include_once "filter.php" ?>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createPostModal">
      Create New Post
    </button>
    <?php include_once "create.php" ?>
  </div>
</div>
<?php Flasher::getFlash() ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col" class="text-center">#</th>
      <th scope="col">Title</th>
      <th scope="col">Category</th>
      <th scope="col">Created At</th>
      <th scope="col">Last Update</th>
      <th scope="col">Status</th>
      <th scope="col" class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($data["posts"]):
      $i = Pagination::getStart() + 1;
      foreach ($data["posts"] as $post):
    ?>
        <tr>
          <th scope="row" class="text-center"><?= $i++; ?>.</th>
          <td><?= htmlspecialchars($post->title) ?></td>
          <td><?= htmlspecialchars($post->category_name) ?></td>
          <td><?= htmlspecialchars($post->created_at) ?></td>
          <td><?= htmlspecialchars($post->updated_at) ?></td>
          <td><span class="badge text-bg-<?= $post->status === "draft" ? "secondary" : ($post->status === "published" ? "success" : "warning") ?>"><?= htmlspecialchars($post->status) ?></span></td>
          <td class="text-center">
            <div class="d-flex justify-content-center">
              <div class="btn-group-vertical">
                <button type="button" class="btn btn-<?= $post->status === "published" ? "warning" : "success"; ?> btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#publishModal<?= $post->id; ?>">
                  <?= $post->status === "published" ? "Archieve" : "Publish"; ?>
                </button>
                <?php include "publish.php" ?>
                <button type="button" class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#viewModal<?= $post->id; ?>">
                  View
                </button>
                <?php include "view.php" ?>
                <button type="button" class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editPostModal<?= $post->id; ?>">
                  Edit
                </button>
                <?php include "edit.php" ?>
                <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $post->id; ?>">Delete</button>
                <?php include "delete.php" ?>
              </div>
            </div>
          </td>
        </tr>
      <?php
      endforeach;
    else:
      ?>
      <tr>
        <td colspan="7" class="text-center">Not found.</td>
      </tr>
    <?php endif ?>
  </tbody>
</table>

<?= $data["posts"] ? Pagination::getPagination("post") : "" ?>