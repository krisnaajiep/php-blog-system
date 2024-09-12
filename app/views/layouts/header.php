<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Simple Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/style.css">
</head>

<body>
  <div class="container d-flex flex-column pt-4 vh-100">
    <nav class="border-bottom pb-2 mb-4">
      <div class="row">
        <div class="col-md">
          <a class="text-decoration-none text-dark fs-2 fw-bold" href="<?= BASE_URL; ?>">Simple Blog</a>
          <a class="text-decoration-none ms-4" href="<?= BASE_URL; ?>/home/categories">Categories</a>
        </div>
        <?php if (Request::get("url") === null || Request::get("url") === "home" || Request::get("url") === "home/index"): ?>
          <div class="col-md mt-2">
            <form class="d-flex" role="search" method="get">
              <?php if (!empty(Request::get("category_name"))): ?>
                <input type="hidden" name="category_name" value="<?= Request::get("category_name"); ?>">
              <?php elseif (!empty(Request::get("author_name"))): ?>
                <input type="hidden" name="author_name" value="<?= Request::get("author_name"); ?>">
              <?php endif ?>
              <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
          </div>
        <?php endif; ?>
        <div class="col-md">
          <?php if (!Auth::getLogin()): ?>
            <ul class="nav justify-content-end pt-2">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= BASE_URL; ?>/auth">Sign In</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL; ?>/auth/signup">Sign Up</a>
              </li>
            </ul>
          <?php else: ?>
            <ul class="nav justify-content-end pt-2">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= htmlspecialchars(Auth::getUser()->username) ?>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?= BASE_URL; ?>/dashboard">Go to dashboard</a></li>
                  <li><a class="dropdown-item" href="<?= BASE_URL; ?>/user/logout">Logout</a></li>
                </ul>
              </li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </nav>