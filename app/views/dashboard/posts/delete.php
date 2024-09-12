<!-- Delete Post Modal -->
<div class="modal fade" id="deleteModal<?= $post->id; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="bi bi-exclamation-triangle-fill fs-1 text-danger"></i>
        <h6>Are you sure want to delete this post permanently?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form action="<?= BASE_URL; ?>/post/delete" method="post">
          <input type="hidden" name="slug" value="<?= $post->slug; ?>">
          <input type="hidden" name="author_id" value="<?= $post->author_id; ?>">
          <input type="hidden" name="featured_image" value="<?= $post->featured_image; ?>">
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>