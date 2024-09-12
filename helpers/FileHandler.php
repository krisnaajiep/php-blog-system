<?php

class FileHandler
{
  private static $target_dir, $target_file;

  public static function upload(string $dir, array $file, string $old_file = "")
  {
    if ($file["error"] === 4) {
      return $old_file;
    } else {
      self::remove("image", $dir, $old_file);
    }

    if (strpos($file["type"], "image") !== false) {

      try {
        self::$target_dir = BASE_DIR . "/assets/img/" . $dir . "/";

        list($image_name, $image_extension) = explode(".", $file["name"]);
        $image_name = uniqid($image_name);
        $file_name = implode(".", [$image_name, $image_extension]);

        self::$target_file = self::$target_dir . basename($file_name);

        if (!move_uploaded_file($file["tmp_name"], self::$target_file))
          throw new Exception("Error Uploading Image.", 1);

        return $file_name;
      } catch (\Throwable $th) {
        Flasher::setFlash($th->getMessage(), "Please try again.", "warning");
        return false;
      }
    }
  }

  public static function remove(string $type, string $dir, string $file_name): void
  {
    if ($type === "image" && $file_name !== "default.jpg") {
      $file = BASE_DIR . "/assets/img/" . $dir . "/" . $file_name;
      if (file_exists($file) && $file_name !== "default.jpg")
        unlink($file);
    }
  }
}
