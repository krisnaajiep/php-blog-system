</div>
<footer class="mt-5 border-top bg-white mt-auto">
  <p class="text-center mt-2">Copyright 2024</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?= BASE_URL; ?>/assets/js/script.js"></script>
<?php if (Validator::hasValidationErrors("update_profile")): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const editProfileModal = document.getElementById('editProfileModal');
      const modal = new bootstrap.Modal(editProfileModal);
      modal.show();
    });
  </script>
<?php elseif (Validator::hasValidationErrors("update_password")): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const changePasswordModal = document.getElementById('changePasswordModal');
      const modal = new bootstrap.Modal(changePasswordModal);
      modal.show();
    });
  </script>
<?php elseif (Validator::hasValidationErrors("create_post")): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const changePasswordModal = document.getElementById('createPostModal');
      const modal = new bootstrap.Modal(changePasswordModal);
      modal.show();
    });
  </script>
<?php elseif (Validator::hasValidationErrors("update_post")): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const changePasswordModal = document.getElementById('editPostModal' + <?= $data["post_id"]; ?>);
      const modal = new bootstrap.Modal(changePasswordModal);
      modal.show();
    });
  </script>
<?php elseif (Validator::hasValidationErrors("create_category")): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const changePasswordModal = document.getElementById('createCategoryModal');
      const modal = new bootstrap.Modal(changePasswordModal);
      modal.show();
    });
  </script>
<?php elseif (Validator::hasValidationErrors("update_category")): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const changePasswordModal = document.getElementById('editCategoryModal' + <?= $data["category_id"]; ?>);
      const modal = new bootstrap.Modal(changePasswordModal);
      modal.show();
    });
  </script>
<?php endif; ?>
</body>

</html>