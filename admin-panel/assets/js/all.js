document.getElementById('fullscreen').onclick = function(){
  if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {
      document.documentElement.requestFullScreen();
      document.getElementById('fullscreen-icon').src = "../assets/svgs/minimize.svg";
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
      document.getElementById('fullscreen-icon').src = "../assets/svgs/minimize.svg";
    } else if (document.documentElement.webkitRequestFullScreen) {
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
      document.getElementById('fullscreen-icon').src = "../assets/svgs/minimize.svg";
    } else if (document.documentElement.msRequestFullscreen) {
      document.documentElement.msRequestFullscreen();
      document.getElementById('fullscreen-icon').src = "../assets/svgs/minimize.svg";
    }
  } else {
    document.getElementById('fullscreen-icon').src = "../assets/svgs/fullscreen.svg";
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  }
}
let navinfo = document.getElementById('navinfo');
let sideMenu = document.getElementById('sideMenu');
let sideMenuList = document.querySelectorAll('.sideMenusList');
let menus = document.querySelectorAll('.menus');
let menuProfile = document.getElementById('sideMenu-profile');
let menusIcon = document.querySelectorAll('.menusIcon');

document.addEventListener("DOMContentLoaded", function(event) {
  if (screen.width < 570) {
      sideMenu.style.display = "none";
  }
});

function toggleNav(){
  // when not collapsed
  if (screen.width <= 570) {
    if (sideMenu.style.display === "none") {
      expandNav();

    }else {
      collapseNav();
      sideMenu.style.display = "none";
    }
  }else if (navInfo.innerHTML === "notCollapsed") {
      collapseNav();
  }
  else {
      expandNav();
  }

  function expandNav() {
    navInfo.innerHTML = "notCollapsed";
    sideMenu.style.display= "flex";
    sideMenu.style.width= "auto";
    sideMenu.style.minWidth= "255px";
    logo.style.display = "inline";
    menus.forEach(a=>a.style.display = "flex");
    sideMenuList.forEach(a=>a.style.display = "flex");
    menuProfile.style.display= "block";
    menusIcon.forEach(a=>a.style.width = "50%");
  }

  function collapseNav() {
    navInfo.innerHTML = "collapsed";
    sideMenu.style.width= "auto";
    sideMenu.style.minWidth= "0px";
    menus.forEach(a=>a.style.display = "none");
    menusIcon.forEach(a=>a.style.width = "auto");
    sideMenuList.forEach(a=>a.style.display = "list-item");
    sideMenuList.forEach(a=>a.style.padding = "auto");
    menuProfile.style.display= "none";
  }
}
