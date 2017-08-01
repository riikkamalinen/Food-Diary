<?php
require_once("config.inc.php");


if (!is_logged()) {
  $main_layout->print_login();
  exit();
}

// TODO: Korvaa jollain mukavalla funktiopaketilla
$page = "";
if (isset($_GET["page"]))
  $page = $_GET["page"];

if (in_array($page, get_contents())) {
  require_once($GLOBALS["content_root"] . $page . "/layout.tmpl.php");
} else {
  require_once($GLOBALS["content_root"] . "etusivu/layout.tmpl.php");
}

function get_contents() {
  $return_value = array();
  $contents = array_diff(scandir($GLOBALS["content_root"]), array("..", "."));
  foreach ($contents as $item) {
    if (is_dir($GLOBALS["content_root"] . $item))
      array_push($return_value, $item);
  }
  return $return_value;
}


?>
