<?php
$_SERVROOT = '../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';
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
        <a href="/">FastReed <span>admins</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Don't Go Ahead</span>
        <span class="messageAndErrors">It seems you are not an admin</span>
      </div>
      <div class="loginElements unauth">
        <?php if (isset($_SESSION['inviteCodeError'])){
          echo '<p id="unauth" >'.$_SESSION['inviteCodeError'].'</p>';
        }else {
          echo '<p id="unauth" >You Are Not Authorized To <br> Access
          This Service</p>';
        }

          ?>

       </div>
       <div class="others">
         <a href="/login">User Login</a>
       </div>
    </div>
    <script src="assets/login.js?v=<?php echo getenv('cssVersion'); ?>" charset="utf-8"></script>
  </body>
</html>
