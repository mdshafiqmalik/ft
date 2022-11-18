<?php
function getIp(){
  $ip = $_SERVER['REMOTE_ADDR'];
  filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
  return $ip;
}
 ?>
