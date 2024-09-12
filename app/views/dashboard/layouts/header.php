<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Simple Blog Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-body-tertiary vh-100 d-flex flex-column">
  <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
    <div class="container">
      <a class="navbar-brand" href="<?= BASE_URL; ?>/dashboard">Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?= Request::get("url") === "post" || Request::get("url") === "post/index" ? "active" : "" ?>" href="<?= BASE_URL; ?>/post">Posts</a>
          </li>
          <?php if (Auth::getUser()->role_name !== "User"): ?>
            <li class="nav-item">
              <a class="nav-link <?= Request::get("url") === "categories" || Request::get("url") === "categories/index" ? "active" : "" ?>" href="<?= BASE_URL; ?>/category">Categories</a>
            </li>
          <?php endif ?>
          <li class="nav-item">
            <a class="nav-link <?= Request::get("url") === "user" || Request::get("url") === "user/index" ? "active" : "" ?>" href="<?= BASE_URL; ?>/user">Users</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars(Auth::getUser()->username); ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item <?= Request::get("url") === "dashboard" || Request::get("url") === "dashboard/index" ? "active" : "" ?>" href="<?= BASE_URL; ?>/dashboard">Profile</a></li>
              <li><a class="dropdown-item <?= Request::get("url") === "dashboard/settings" ? "active" : "" ?>" href="<?= BASE_URL; ?>/dashboard/settings">Settings</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL; ?>">Go to homepage</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL; ?>/user/logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
  </nav>
  <div class="container mt-4">