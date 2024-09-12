<div class="row border-bottom mb-4">
  <div class="col-6">
    <h2>Welcome Back, <?= htmlspecialchars(Auth::getUser()->full_name ?? '-'); ?></h2>
  </div>
  <div class="col-6 text-end">
    <!-- Edit Profile Button trigger modal -->
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProfileModal">
      Edit Profile
    </button>
    <?php include_once "includes/edit_profile.php" ?>
  </div>
</div>
<?php Flasher::getFlash() ?>
<div class="bg-white p-4 mb-5">
  <div class="row mb-4">
    <div class="col-4">
      <div class="card h-100">
        <div class="card-body text-center">
          <img src="<?= BASE_URL; ?>/assets/img/profile_pictures/<?= Auth::getUser()->profile_picture; ?>" alt="" class="rounded-circle mb-3" width="200">
          <h4><?= htmlspecialchars(Auth::getUser()->full_name ?? '-'); ?></h4><span class="badge bg-<?= Auth::getUser()->role_name === "Admin" ? "primary" : (Auth::getUser()->role_name === "Moderator" ? "info" : "secondary"); ?>"><?= htmlspecialchars(Auth::getUser()->role_name); ?></span>
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
              <p class="card-text"><?= htmlspecialchars(Auth::getUser()->username); ?></p>
              <h6>Email :</h6>
              <p class="card-text"><?= htmlspecialchars(Auth::getUser()->email); ?></p>
              <h6>Phone Number :</h6>
              <p class="card-text"><?= htmlspecialchars(Auth::getUser()->phone_number ?? '-'); ?></p>
              <h6>Address :</h6>
              <p class="card-text"><?= htmlspecialchars(Auth::getUser()->address ?? '-'); ?></p>
            </div>
            <div class="col-6">
              <h6>Status :</h6>
              <p class="card-text"><span class="badge bg-<?= Auth::getUser()->status === "active" ? "success" : (Auth::getUser()->status === "inactive" ? "warning" : "danger") ?>"><?= htmlspecialchars(Auth::getUser()->status); ?></span></p>
              <h6>Joined at :</h6>
              <p class="card-text"><?= Auth::getUser()->created_at; ?></p>
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
          <?= htmlspecialchars(Auth::getUser()->bio ?? '-'); ?>
        </div>
      </div>
    </div>
  </div>
</div>