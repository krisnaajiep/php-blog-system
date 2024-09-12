<?php

class DashboardController extends Controller
{
  public function __construct()
  {
    if (!Auth::getLogin()) header("Location: " . BASE_URL . "/auth/signin");
  }

  public function index(): string
  {
    return $this->view("dashboard/layouts/header")
      . $this->view("dashboard/index")
      . $this->view("dashboard/layouts/footer");
  }

  public function settings(): string
  {
    return $this->view("dashboard/layouts/header")
      . $this->view("dashboard/settings")
      . $this->view("dashboard/layouts/footer");
  }
}
