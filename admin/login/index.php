<?php
$domain = $_SERVER['DOCUMENT_ROOT'];
include $domain.'/.htHidden/activity/checkVisitorType.php';
if (!isset($_GET['adminQoute'])) {
  header("Location: unauthorized.php");
}elseif (empty($_GET['adminQoute'])) {
    header("Location: unauthorized.php");
}elseif (!checkAdminQoute($_GET['adminQoute'])) {
  header("Location: unauthorized.php");
}
function checkAdminQoute($aq){
$hrs = (int) date('h');
$min = (int) date('i');
$day = (int) date('d');
$key = (int) $hrs*$min*$day;
$aq = (int) $aq;
  if ($aq === $key) {
    $adminQouteFound = true;
  }else {
    $adminQouteFound = false;
  }
  return $adminQouteFound;
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <link rel="stylesheet" href="assets/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Fastreed: Admin Login</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <span>admin</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Hello! let's get started</span>
        <span class="messageAndErrors">Sign In to continue</span>
      </div>
      <form class="loginElements loginForm" action="auth.php" method="post">
        <input class="fields" type="text" name="usernameOrEMail" value="" placeholder="Username/Email/Phone">
        <input class="fields" type="password" name="password" value="" placeholder="Password">
        <div class="g-recaptcha" data-callback='onSubmit' data-sitekey="6LcFdOMbAAAAAHQ3kaP4oBuyYnh2KRnYXR6CcrnP"></div>
        <br>
        <input type="hidden" name="adminQoute" value=" <?php echo $_GET['adminQoute']; ?> ">
        <input id="submit" class="submit"  type="submit" name="Submit" value="Login">
      </form>
      <div class="others">
        <a href="/login">User Login</a>
      </div>
    </div>
    <script src="assets/login.js?v=<?php echo getenv('cssVersion'); ?>" charset="utf-8"></script>
  </body>
</html>
