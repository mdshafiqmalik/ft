<?php
$var = "hello";
echo "hello";
$cookieSet = setcookie('visitorID', "ghjh", time() + (86400 * 30), "/");
var_dump($cookieSet);
 ?>