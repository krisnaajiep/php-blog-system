<?php
if ($data["posts"]):

  if (!empty(Request::get("category_name"))) {
    echo '<h4 class="mb-4">Post Category: ' . Request::get("category_name") . '</h4>';
  } else if (!empty(Request::get("author_name"))) {
    echo '<h4 class="mb-4">Post by: ' . Request::get("author_name") . '</h4>';
  }

  if (Request::get("page") == 1 || empty(Request::get("page"))):
?>
    <div class="hero mb-4">
      <div class="card text-bg-dark">
        <a href="<?= BASE_URL; ?>/home?category_name=<?= $data["posts"][0]->category_name; ?>">
          <div class="card-img-overlay rounded-bottom-0 h-auto align-self-start py-1">
            <h5 class="text-center text-white"><?= htmlspecialchars($data["posts"][0]->category_name) ?></h5>
          </div>
        </a>
        <img src="<?= BASE_URL; ?>/assets/img/featured_images/<?= $data["posts"][0]->featured_image; ?>" class="card-img" alt="<?= $data["posts"][0]->featured_image; ?>" width="1200" height="600">
        <div class="card-img-overlay rounded-top-0 align-self-end">
          <h5 class="card-title"><?= htmlspecialchars($data["posts"][0]->title) ?></h5>
          <p class="card-text"><?= strip_tags(substr($data["posts"][0]->content, 0, 250)); ?>... <a href="<?= BASE_URL; ?>/home/post/<?= $data["posts"][0]->slug; ?>" class="text-white d-block">Read more..</a></p>
          <p class="card-text"><small>published at <?= htmlspecialchars($data["posts"][0]->published_at) ?> by <a href="<?= BASE_URL; ?>/home?author_name=<?= $data["posts"][0]->author_name; ?>" class="text-white"><?= htmlspecialchars($data["posts"][0]->author_name) ?></a></small></p>
        </div>
      </div>
    </div>
  <?php
    unset($data["posts"][0]);
  endif;
  ?>
  <section class="posts mb-3" id="posts">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($data["posts"] as $post): ?>
        <div class="col-md-4">
          <div class="card h-100">
            <a href="<?= BASE_URL; ?>/home?category_name=<?= $post->category_name; ?>">
              <div class="card-img-overlay rounded-bottom-0 rounded-end-0 h-auto align-self-start w-25 py-1 text-center ">
                <h6 class="text-white d-inline-block"><?= htmlspecialchars($post->category_name) ?></h6>
              </div>
            </a>
            <img src="<?= BASE_URL; ?>/assets/img/featured_images/<?= $post->featured_image; ?>" class="card-img-top" alt="<?= $post->featured_image; ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($post->title) ?></h5>
              <p class="card-text"><?= strip_tags(substr($post->content, 0, 200)); ?>...</p>
              <a href="<?= BASE_URL; ?>/home/post/<?= $post->slug; ?>">Read more..</a>
            </div>
            <div class="card-footer">
              <small class="text-body-secondary">Published at <?= htmlspecialchars($post->published_at) ?> by <a href="<?= BASE_URL; ?>/home?author_name=<?= $post->author_name; ?>"><?= htmlspecialchars($post->author_name) ?></a></small>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </section>

<?php
  echo $data["posts"] ? Pagination::getPagination("home") : "";
else:
?>
  <h4 class="text-center">Not found.</h4>
<?php endif; ?>