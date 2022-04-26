<?php
define("siteURL", (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]");
include "lib/simple_html_dom.php";
include "lib/helper.php";
include "lib/route.php";
$getRoute  = new urlRoute();
include "controller/controller" . $getRoute->getController() . ".php";
$export->index();
