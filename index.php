<?php
require_once("config.inc.php");

$main_layout->print_head();
if (is_logged()) $main_layout->print_header();
include_once("content_loader.php");
if (is_logged()) $main_layout->print_footer();;
$main_layout->print_bottom();

?>
