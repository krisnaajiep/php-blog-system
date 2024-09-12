<!-- View User Modal -->
<div class="modal fade" id="viewModal<?= $user->id; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewModalLabel"><?= htmlspecialchars($user->full_name); ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <div class="row mb-4">
          <div class="col-4">
            <div class="card h-100">
              <div class="card-body text-center">
                <img src="<?= BASE_URL; ?>/assets/img/profile_pictures/<?= htmlspecialchars($user->profile_picture); ?>" alt="" class="rounded-circle mb-3" width="200">
                <span class="badge bg-<?= $user->role_name === "Admin" ? "primary" : ($user->role_name === "Moderator" ? "info" : "secondary") ?>"><?= htmlspecialchars($user->role_name); ?></span>
                <span class="badge bg-<?= $user->status === "active" ? "success" : ($user->status === "inactive" ? "warning" : "danger") ?>"><?= htmlspecialchars($user->status); ?></span>
              </div>
            </div>
          </div>
          <div class="col-8">
            <div class="card h-100">
              <h5 class="card-header">Profile</h5>
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <h6>Username :</h6>
                    <p class="card-text"><?= htmlspecialchars($user->username); ?></p>
                    <h6>Email :</h6>
                    <p class="card-text"><?= htmlspecialchars($user->email); ?></p>
                    <h6>Phone Number :</h6>
                    <p class="card-text"><?= htmlspecialchars($user->phone_number); ?></p>
                  </div>
                  <div class="col-6">
                    <h6>Address :</h6>
                    <p class="card-text"><?= htmlspecialchars($user->address); ?></p>
                    <h6>Joined at :</h6>
                    <p class="card-text"><?= htmlspecialchars(DateTime::createFromFormat("Y-m-d H:i:s", $user->created_at)->format("l, d F Y H:i:s")); ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card h-100">
              <h5 class="card-header">Bio</h5>
              <div class="card-body">
                <?= htmlspecialchars($user->bio); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <?php if (Auth::getUser()->role_name === "Admin" && $user->role_name !== "Admin"): ?>
          <div class="btn-group">
            <button type="button" class="btn btn-<?= $user->role_name === "Admin" ? "primary" : ($user->role_name === "Moderator" ? "info" : "secondary") ?>"><?= htmlspecialchars($user->role_name); ?></button>
            <button type="button" class="btn btn-<?= $user->role_name === "Admin" ? "primary" : ($user->role_name === "Moderator" ? "info" : "secondary") ?> dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <form action="<?= BASE_URL; ?>/user/updateRole" method="post">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="username" value="<?= $user->username; ?>">
                <input type="hidden" name="old_role_id" value="<?= $user->role_id; ?>">
                <input type="hidden" name="old_role_name" value="<?= $user->role_name; ?>">
                <?php foreach ($data["roles"] as $role): ?>
                  <li><button type="submit" class="dropdown-item <?= $role->id === $user->role_id ? "active" : ""; ?> <?= $role->name === "Moderator" && $role->id === $user->role_id ? "bg-info" : ($role->name === "User" && $role->id === $user->role_id ? "bg-secondary" : ""); ?>" name="role_id" value="<?= $role->id; ?>"><?= htmlspecialchars($role->name); ?></button></li>
                <?php endforeach ?>
              </form>
            </ul>
          </div>
        <?php endif ?>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>