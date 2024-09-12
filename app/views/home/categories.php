<?php if ($data["categories"]): ?>
  <section class="categories" id="categories">
    <div class="row mb-5">
      <?php foreach ($data["categories"] as $category): ?>
        <div class="col-md-3 mb-4">
          <a href="<?= BASE_URL; ?>/home?category_name=<?= $category->name; ?>">
            <div class="card text-bg-dark">
              <div class="card-img-overlay rounded-0 h-auto align-self-center py-1">
                <h5 class="text-center"><?= htmlspecialchars($category->name) ?></h5>
              </div>
              <img src="<?= BASE_URL; ?>/assets/img/category_thumbnails/<?= $category->thumbnail; ?>" class="card-img" alt="<?= $category->thumbnail; ?>" width="600">
            </div>
          </a>
        </div>
      <?php endforeach ?>
    </div>
  </section>
<?php else: ?>
  <h4 class="text-center">Not found.</h4>
<?php endif ?>