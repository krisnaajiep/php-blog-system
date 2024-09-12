<!-- Publish Post Modal -->
<div class="modal fade" id="publishModal<?= $post->id; ?>" tabindex="-1" aria-labelledby="publishModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="publishModalLabel"><?= $post->status === "published" ? "Archive" : "Publish"; ?> Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="bi bi-cloud-<?= $post->status === "published" ? "download" : "upload"; ?> fs-1 text-<?= $post->status === "published" ? "warning" : "success"; ?>"></i>
        <h6>Are you sure want to <?= $post->status === "published" ? "archive" : "publish"; ?> this post now?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form action="<?= BASE_URL; ?>/post/setStatus" method="post">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
          <input type="hidden" name="slug" value="<?= $post->slug; ?>">
          <input type="hidden" name="author_id" value="<?= $post->author_id; ?>">
          <input type="hidden" name="old_status" value="<?= $post->status; ?>">
          <input type="hidden" name="status" value="<?= $post->status !== "published" ? "published" : "archived"; ?>">
          <button type="submit" class="btn btn-<?= $post->status === "published" ? "warning" : "success"; ?>"><?= $post->status === "published" ? "Archive" : "Publish"; ?></button>
        </form>
      </div>
    </div>
  </div>
</div>