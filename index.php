<?php

session_start();

require_once "config/config.php";
require_once "helpers/Request.php";
require_once "helpers/Validator.php";
require_once "helpers/FileHandler.php";
require_once "helpers/Flasher.php";
require_once "core/App.php";
require_once "core/Controller.php";
require_once "core/Model.php";
require_once "helpers/Auth.php";
require_once "helpers/Cookie.php";
require_once "helpers/Pagination.php";
require_once "helpers/Slug.php";

$app = new App();
