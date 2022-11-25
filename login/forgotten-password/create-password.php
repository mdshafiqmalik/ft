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
        <div class="spPassword">
          <input class="fields passwordV" type="password" name="current-password" value="" placeholder="New Password" autocomplete="current-password">
        </div>
        <div class="spPassword">
          <input class="fields passwordV" type="password" name="current-password" value="" placeholder="Verify Password" autocomplete="current-password">
          <img id="eyeClosed" onclick="openEye()" style="display:block;" src="/assets/svgs/eye_closed.svg" alt="">
          <img id="eyeOpened" onclick="openEye()" style="display:none;" src="/assets/svgs/eye_show.svg" alt="">
        </div>
        <input id="submit" type="submit" name="Submit" value=" Reset Password">
      </form>
    </div>
    <script src="/assets/js/register.js" charset="utf-8"></script>
  </body>
</html>
