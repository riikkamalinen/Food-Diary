<?php

require_once("config.inc.php");

if (isset($_GET["logout"])) {
  unset($_GET["logout"]);
  unset($_SESSION["user"]);
  $main_layout->print_login();
  exit();
}

try {
  $_SESSION["user"] = new User($_POST["username"], $_POST["password"]);
  $main_layout->print_header();
  require_once("content_loader.php");
  $main_layout->print_footer();
} catch (Exception $e) {
  $main_layout->print_login();
}

?>
