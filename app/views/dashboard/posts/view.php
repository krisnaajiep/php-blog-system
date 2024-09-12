<!-- View Post Modal -->
<div class="modal fade" id="viewModal<?= $post->id; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewModalLabel"><?= htmlspecialchars($post->title); ?></h1>
        <span class="badge text-bg-<?= $post->status === "draft" ? "secondary" : ($post->status === "published" ? "success" : "warning") ?> ms-2 mt-1"><?= htmlspecialchars($post->status); ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <figure class="figure">
          <img src="<?= BASE_URL; ?>/assets/img/featured_images/<?= $post->featured_image; ?>" class="figure-img img-fluid rounded" alt="...">
          <figcaption class="figure-caption"><?= htmlspecialchars($post->image_caption); ?></figcaption>
        </figure>
        <div class="content mt-3 text-start">
          <?= $post->content; ?>
          <br>
          <p>Author: <?= htmlspecialchars($post->author_name) ?></p>
        </div>
      </div>
      <div class="modal-footer">
        <h6>Published at: <?= htmlspecialchars($post->published_at ?? '-') ?></h6>
      </div>
    </div>
  </div>
</div>