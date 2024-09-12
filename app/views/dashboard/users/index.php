<div class="row">
  <div class="col">
    <h2 class="mb-4">Users DataTable</h2>
  </div>
  <div class="col-4 text-end">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal"><i class="bi bi-filter"></i> Filter</button>
    <?php include_once "filter.php" ?>
  </div>
</div>
<?php Flasher::getFlash() ?>
<table class="table mb-3">
  <thead>
    <tr>
      <th scope="col" class="text-center">#</th>
      <th scope="col">Full Name</th>
      <th scope="col">Username</th>
      <th scope="col">Role</th>
      <th scope="col">Status</th>
      <th scope="col">Joined at</th>
      <th scope="col" class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($data["users"]):
      $i = Pagination::getStart() + 1;
      foreach ($data["users"] as $user):
    ?>
        <tr>
          <th scope="row" class="text-center"><?= $i++; ?>.</th>
          <td><?= htmlspecialchars($user->full_name); ?></td>
          <td><?= htmlspecialchars($user->username); ?></td>
          <td>
            <span class="badge bg-<?= $user->role_name === "Admin" ? "primary" : ($user->role_name === "Moderator" ? "info" : "secondary") ?>"><?= htmlspecialchars($user->role_name); ?></span>
          </td>
          <td>
            <span class="badge bg-<?= $user->status === "active" ? "success" : ($user->status === "inactive" ? "warning" : "danger") ?>"><?= htmlspecialchars($user->status); ?></span>
          </td>
          <td><?= htmlspecialchars($user->created_at); ?></td>
          <td class="text-center">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $user->id; ?>">
              View
            </button>
            <?php
            include "view.php";
            if ($user->role_name !== "Admin" && $user->id !== Auth::getUser()->id):
              if (Auth::getUser()->role_name !== "User" && $user->status !== "inactive"):
            ?>
                <button type="button" class="btn btn-<?= $user->status === "active" ? "warning" : "success"; ?> btn-sm" data-bs-toggle="modal" data-bs-target="#banModal<?= $user->id; ?>">
                  <?= $user->status === "active" ? "Ban" : "Unban"; ?>
                </button>
              <?php
                include "ban.php";
              endif;
              if (Auth::getUser()->role_name === "Admin"):
              ?>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user->id; ?>">Delete </button>
            <?php
                include "delete.php";
              endif;
            endif;
            ?>
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

<?= $data["users"] ? Pagination::getPagination("user") : "" ?>