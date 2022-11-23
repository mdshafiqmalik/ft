<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Admin Panel</title>
  </head>
  <body>
    <div class="top-div">
      <!--  Navbar -->
      <nav>
        <div id="nav-G1" class="nav-G1">
          <div class="nav-logo nav-contents">
            <a id="logo" href="/">FastReed <span>.com</span> </a>
            <div id="small-logo"> <a href="/admin-panel"><img width="40px" height="48px" src="../assets/images/favicon.png" alt=""></a> </div>
          </div>

          <div onclick="toggleNav()" id="nav-left-menu">
            <img src="../assets/svgs/menu_lines.svg" alt="">
          </div>
        </div>

        <div id="nav-G2" class="nav-G2">
          <div id="nav-profile">
            <img id="nav-profile-img" src="../assets/images/face1.jpg" alt="">
          </div>
          <div id="fullscreen">
            <img id="fullscreen-icon" src="../assets/svgs/fullscreen.svg" alt="">
          </div>


          <!-- <div id="nav-right-menu">
            <img src="../assets/svgs/menu_lines.svg" alt="">
          </div> -->
        </div>
      </nav>
      <div class="mainBody">

        <div id="sideMenu" class="sideMenu">
          <div id="navInfo" hidden>notCollapsed</div>
          <ul class="sideMenusList" id="sideMenus">
            <li class="sideMenusList" id="sideMenu-profile" >
              <a href="#">
                <div class="image">
                  <img src="../assets/images/face1.jpg" alt="">
                </div>
                <div class="about">
                  <span class="name">David Grey H.</span>
                  <span class="desig">Project Admin</span>
                </div>
                <div class="greenTickBadge">
                  <img src="../assets/svgs/verified.svg" alt="">
                </div>
              </a>
            </li>
            <li class="sideMenusList">
              <a class="menus" href="#">Home</a>
              <div class="menusIcon">
                <img   height="22px" width="22px" src="../assets/svgs/home.svg" alt="">
              </div>
            </li>
            <li class="sideMenusList">
              <a class="menus"  href="#">Stats</a>
              <div class="menusIcon">
                <img  height="22px" width="22px" src="../assets/svgs/stats.svg" alt="">
              </div>
            </li>
            <li class="sideMenusList">
              <a class="menus"  href="#">Users</a>
              <div class="menusIcon">
                <img   height="22px" width="22px" src="../assets/svgs/user.svg" alt="">
              </div>
            </li>
            <li class="sideMenusList">
              <a class="menus"  href="#">Settings</a>
              <div class="menusIcon">
                <img   height="22px" width="22px" src="../assets/svgs/settings.svg" alt="">
              </div>
            </li>
            <li class="sideMenusList">
              <a class="menus"  href="#">Logout</a>
              <div class="menusIcon">
                <img   height="22px" width="22px" src="../assets/svgs/power.svg" alt="">
              </div>
            </li>

            <li class="sideMenusList">
              <a class="menus"  href="#">Stats</a>
              <div class="menusIcon">
                <img  height="22px" width="22px" src="../assets/svgs/stats.svg" alt="">
              </div>
            </li>
            <li class="sideMenusList">
              <a class="menus"  href="#">Users</a>
              <div class="menusIcon">
                <img   height="22px" width="22px" src="../assets/svgs/user.svg" alt="">
              </div>
            </li>
            <li class="sideMenusList">
              <a class="menus"  href="#">Settings</a>
              <div class="menusIcon">
                <img   height="22px" width="22px" src="../assets/svgs/settings.svg" alt="">
              </div>
            </li>
            <li class="sideMenusList">
              <a class="menus"  href="#">Logout</a>
              <div class="menusIcon">
                <img   height="22px" width="22px" src="../assets/svgs/power.svg" alt="">
              </div>
            </li>
          </ul>
        </div>

        <div class="pageBody">

        </div>
      </div>
    </div>
  </body>
  <script src="assets/js/all.js?v=<?php echo getenv('cssVersion'); ?>" charset="utf-8"></script>
</html>
