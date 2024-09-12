<?php

class Pagination
{
  private static $limit, $page = 1, $start = 0, $pages;

  public static function setLimit($limit)
  {
    self::$limit = $limit;
  }

  public static function getLimit(): int
  {
    return self::$limit;
  }

  public static function getStart(): int
  {
    if (isset($_GET["page"])) self::$page = $_GET["page"];

    if (self::$page > 1) self::$start = (self::$page * self::$limit) - self::$limit;

    return self::$start;
  }

  public static function setPages(int $total)
  {
    self::$pages = ceil($total / self::$limit);
  }

  public static function getPagination(string $controller): string
  {
    $li = '';
    $previous = self::$page > 1 ?  self::$page - 1 : 1;
    $next = self::$page < self::$pages ? self::$page + 1 : self::$pages;

    $get = Request::get();

    unset($get["url"]);
    unset($get["page"]);

    $get_url =  [];

    foreach ($get as $key => $value) {
      $get_url[] = $key . "=" . $value;
    }

    $get_url_string = implode("&", $get_url);

    for ($i = 1; $i <= self::$pages; $i++) {
      $active = self::$page == $i ? 'active' : '';
      if (!empty(Request::get())) {
        $li .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . BASE_URL . '/' . $controller . '?' . $get_url_string . '&page=' . $i . '">' . $i . '</a></li>';
      } else {
        $li .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . BASE_URL . '/' . $controller . '?page=' . $i . '">' . $i . '</a></li>';
      }
    }

    if (!empty(Request::get())) {
      return '<ul class="pagination justify-content-end">
              <li class="page-item"><a class="page-link" href="' . BASE_URL . '/' . $controller . '?' . $get_url_string . '&page=' . $previous . '">Previous</a></li>
              ' . $li . '
              <li class="page-item"><a class="page-link" href="' . BASE_URL . '/' . $controller . '?' . $get_url_string . '&page=' . $next . '">Next</a></li>
            </ul>';
    } else {
      return '<ul class="pagination justify-content-end">
              <li class="page-item"><a class="page-link" href="' . BASE_URL . '/' . $controller . '?page=' . $previous . '">Previous</a></li>
              ' . $li . '
              <li class="page-item"><a class="page-link" href="' . BASE_URL . '/' . $controller . '?page=' . $next . '">Next</a></li>
            </ul>';
    }
  }
}
