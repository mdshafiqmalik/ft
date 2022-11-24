<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Fastreed: Admin Panel</title>
  </head>
  <body>
    <div class="top-div">
      <!--  Navbar -->
      <nav>
        <div id="nav-G1" class="nav-G1">
          <div class="nav-logo">
            <a id="logo" href="/">FastReed <span>.com/admin</span> </a>
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
        </div>
      </nav>
      <div class="mainBody">

        <div id="sideMenu" class="sideMenu">
          <div id="navInfo" hidden>notCollapsed</div>
          <ul class="sideMenusList" id="sideMenus">

            <li class="sideMenusList" id="sideMenu-profile" >
              <a id="sideProfile" href="#">
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
              <div class="mainMenu">
                  <a class="menus" href="#">Home</a>
                  <div class="menusIcon">
                    <img height="22px" width="22px" src="../assets/svgs/home.svg" alt="">
                  </div>
              </div>
              <div class="subMenu"></div>
            </li>

            <li class="sideMenusList">
              <div class="mainMenu">
                  <a class="menus"  href="#">Stats</a>
                  <div class="menusIcon">
                    <img height="22px" width="22px" src="../assets/svgs/stats.svg" alt="">
                  </div>
              </div>
              <div class="subMenu">  </div>
            </li>

            <li class="sideMenusList">
              <div class="mainMenu">
                  <a class="menus"  href="#">Users</a>
                  <div class="menusIcon">
                    <img height="22px" width="22px" src="../assets/svgs/user.svg" alt="">
                  </div>
              </div>
              <div class="subMenu">  </div>
            </li>

            <li class="sideMenusList">
              <div class="mainMenu">
                  <a class="menus"  href="#">Settings</a>
                  <div class="menusIcon">
                    <img height="22px" width="22px" src="../assets/svgs/settings.svg" alt="">
                  </div>
              </div>
              <div class="subMenu">  </div>
            </li>

            <li class="sideMenusList dropdownMenu">
              <div class="mainMenu" onclick="expandMenus(6)">
                <span hidden> 1 </span>
                <a class="menus"  href="#">Category</a>
                <img  class="dropdownIcon-b" height="10px" width="10px" src="../assets/svgs/dropdown.svg" alt="">
                <div class="menusIcon">
                  <img class="dropdownIcon-a" height="10px" width="10px" src="../assets/svgs/dropdown.svg" alt="">
                  <img height="22px" width="22px" src="../assets/svgs/channel.svg" alt="">

                </div>
              </div>
              <div class="subMenu">
                <ul display="none"class="subMenu-ul">
                  <li> <a href="#">Cricket</a> </li>
                  <li><a href="#">Vollyball</a></li>
                </ul>
              </div>
            </li>

            <li class="sideMenusList">
              <div class="mainMenu">
                  <a class="menus"  href="#">Logout</a>
                  <div class="menusIcon">
                    <img height="22px" width="22px" src="../assets/svgs/power.svg" alt="">
                  </div>
              </div>
              <div class="subMenu">  </div>
            </li>


          </ul>
        </div>

        <div class="pageBody">
          <div class="div1">

          </div>
          <div class="div2">

          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="/assets/js/all.js?v=<?php echo getenv('cssVersion'); ?>" charset="utf-8"></script>
</html>
