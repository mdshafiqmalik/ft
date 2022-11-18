<?php
include '.htHidden/g_vars.php';
$GLOBALS['root'] = $domain;
include $domain.'/cookies/';
if (isset($_GET['message'])) {
  $Message ='<div >
  <span id="errorMessage" style="color: red">'.$_GET['message'].'</span></div>
  ';
}else {
  $Message = '';
}

if (isset($_GET['redirect'])) {
  $redirect = $_GET['redirect'];
}else {
  $redirect = "";
}

if (isset($_GET['IDfield'])) {
  $adminId = $_GET['IDfield'];
}else {
  $adminId = '';
}
if (isset($_SESSION['adminLoginID'])) {
  header("Location: /admin/");
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style.css">
    <meta name="robots" content="noindex">
    <title>Fastreed - Admin Login</title>
    <style media="screen">

    </style>
  </head>
  <body>
    <div class="mainCont">
      <form class="" action="auth.php" method="post">
        <span>Admin Login</span>
        <?php echo $Message; ?>
        <div class="adminID">
          <input type="text" name="usernameOrEMail" value="<?php echo $adminId ?>" placeholder="Email/ID/Phone">
        </div>

        <div class="adminPassword">
          <input type="password" name="password" value="" placeholder="Enter Password">
        </div>
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
        <div class="submit">
          <input type="submit" name="submit" value="LOGIN">
        </div>
      </form>
    </div>
    <script>
     if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
       }
    </script>
  </body>
</html>
