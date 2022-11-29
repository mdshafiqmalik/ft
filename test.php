<?php
$confirmPassword = "Rajedit@5119";
$hashPassword =  password_hash($confirmPassword, PASSWORD_DEFAULT);
echo "$hashPassword";
 ?>
