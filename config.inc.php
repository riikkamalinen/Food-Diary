<?php

$relative_root = !isset($relative_root) ? "" : $relative_root;
$GLOBALS["site_root"] = "/PROD/intra2017_demo/";
$GLOBALS["class_root"] = $GLOBALS["site_root"]."class/";
$GLOBALS["template_root"] = $GLOBALS["site_root"]."templates/";
$GLOBALS["content_root"] = "contents/";

$base_class = "{$relative_root}class/Item.class.php";
$classes = array();
foreach (glob("{$relative_root}class/*.class.php") as $class) {
  array_push($classes, $class);
}
require_once($classes[array_search($base_class, $classes)]);
unset($classes[array_search($base_class, $classes)]);
foreach ($classes as $class_file) { require_once($class_file); }

session_start();

$main_layout = new Template(
  "{$relative_root}templates/main/header.tmpl.php",
  "{$relative_root}templates/main/footer.tmpl.php",
  "{$relative_root}templates/main/head.tmpl.php",
  "{$relative_root}templates/main/bottom.tmpl.php",
  "{$relative_root}templates/main/login.tmpl.php"
);

$GLOBALS["db_connection"] = new Database("localhost", "root", "", "intra2017");

function is_logged() {
  if (isset($_SESSION["user"])) {
    return $_SESSION["user"]->check_user();
  }
  return false;
}

?>
