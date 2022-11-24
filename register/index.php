<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <link rel="stylesheet" href="assets/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Fastreed: User Regsitration</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="#">FastReed <span>register</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Create a new account</span>
        <span class="messageAndErrors">All fields required</span>
      </div>
      <form class="loginElements loginForm" action="" method="post">
        <input class="fields" type="text" name="username" value="" placeholder="Username">
        <input class="fields" type="email" name="username" value="" placeholder="Email">
        <input class="fields" type="current-password" name="current-password" value="" placeholder="Password">
        <input id="submit" class="submit" type="submit" name="Submit" value="Register">

      </form>
      <div class="others">
        <a href="#">Login Here</a>
      </div>
    </div>
  </body>
</html>
