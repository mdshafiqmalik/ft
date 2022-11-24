<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <link rel="stylesheet" href="/login/assets/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Fastreed: Forgotten Password</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <br> <span>Password Reset</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Create new password</span>
        <span class="messageAndErrors"></span>
      </div>
      <form class="loginElements loginForm" action="" method="post">
        <input class="fields" type="current-password" name="current-password" value="" placeholder="New Password">
        <input class="fields" type="current-password" name="current-password" value="" placeholder="Verify Password">
        <input id="submit" type="submit" name="Submit" value=" Reset Password">
      </form>
    </div>
  </body>
</html>
