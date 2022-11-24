<?php
session_start();
unset($_SESSION['adminLoginID']);
if (isset($_GET['redirect'])) {
  $redirect = $_GET['redirect'];
  header("Location: $redirect");
}else {
  header("Location: /admin/login/?message=Sucessfully Logged Out");
}
 ?>
