<div class="row">
  <div class="col">
    <h2 class="mb-4">Post Categories</h2>
  </div>
  <div class="col">
    <form class="d-flex" role="search" method="get">
      <input class="form-control me-2" type="search" name="category_keyword" placeholder="Search" aria-label="Search" value="<?= Request::get("keyword"); ?>">
      <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>
  </div>
  <div class="col text-end">
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
      Create New Category
    </button>
    <?php include_once "create.php" ?>
  </div>
</div>
<?php Flasher::getFlash() ?>
<table class="table w-50">
  <thead>
    <tr>
      <th scope="col" class="text-center">#</th>
      <th scope="col">Name</th>
      <th scope="col" class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($data["categories"]):
      $i = 1;
      foreach ($data["categories"] as $category):
    ?>
        <tr>
          <th scope="row" class="text-center"><?= $i++; ?>.</th>
          <td><?= htmlspecialchars($category->name); ?></td>
          <td class="text-center">
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $category->id; ?>">
              Edit
            </button>
            <?php include "edit.php" ?>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $category->id; ?>">Delete </button>
            <?php include "delete.php" ?>
          </td>
        </tr>
      <?php
      endforeach;
    else:
      ?>
      <tr>
        <td colspan="4" class="text-center">Not found.</td>
      </tr>
    <?php endif ?>
  </tbody>
</table>