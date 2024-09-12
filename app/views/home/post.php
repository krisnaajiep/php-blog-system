<section class="content mb-5">
  <a class="link-offset-3" href="<?= BASE_URL; ?>/home">
    <i class="bi bi-arrow-left"></i>
    Back to Homepage
  </a>
  <div class="row mt-4">
    <div class="col">
      <figure class="figure">
        <img src="<?= BASE_URL; ?>/assets/img/featured_images/<?= $data["post"]->featured_image; ?>" class="figure-img img-fluid rounded" alt="<?= $data["post"]->featured_image; ?>" width="1200" height="600">
        <figcaption class="figure-caption"><?= htmlspecialchars($data["post"]->image_caption) ?></figcaption>
      </figure>
    </div>
  </div>

  <h2><?= htmlspecialchars($data["post"]->title) ?></h2>

  <small class="text-body-secondary">Published at <?= htmlspecialchars($data["post"]->published_at) ?> by <a href="<?= BASE_URL; ?>/home?author_name=<?= $data["post"]->author_name; ?>"><?= htmlspecialchars($data["post"]->author_name) ?></a> in <a href="<?= BASE_URL; ?>/home?category_name=<?= $data["post"]->category_name; ?>"><?= htmlspecialchars($data["post"]->category_name) ?></a></small>

  <div class="content mt-3">
    <?= $data["post"]->content; ?>
  </div>
</section>