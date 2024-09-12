<?php

class Slug
{
  private static function getDataBySlug(string $table, string $slug)
  {
    $model = new Model();

    $query = "SELECT id FROM $table WHERE slug = :slug";

    $model->prepare($query);
    $model->bind(":slug", $slug);

    $model->execute();

    return $model->rowCount();
  }

  public static function createSlug(string $table, string $data): string
  {
    $slug = strtolower(str_replace(" ", "-", $data));

    if (self::getDataBySlug($table, $slug) !== 0) {
      $i = 1;
      $s = $slug;

      while (self::getDataBySlug($table, $s) !== 0) {
        $i++;
        $s = $slug . $i;
      }

      return $slug .= $i;
    }

    return $slug;
  }
}
