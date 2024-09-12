<!-- Ban User Modal -->
<div class="modal fade" id="banModal<?= $user->id; ?>" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="banModalLabel"><?= $user->status === "active" ? "Ban" : "Unban"; ?> User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>
        <h6>Are you sure want to <?= $user->status === "active" ? "ban" : "unban"; ?> this user?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form action="<?= BASE_URL; ?>/user/ban" method="post">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
          <input type="hidden" name="role_name" value="<?= $user->role_name; ?>">
          <input type="hidden" name="status" value="<?= $user->status; ?>">
          <input type="hidden" name="username" value="<?= $user->username; ?>">
          <button type="submit" class="btn btn-<?= $user->status === "active" ? "warning" : "success"; ?>"><?= $user->status === "active" ? "Ban" : "Unban"; ?></button>
        </form>
      </div>
    </div>
  </div>
</div>