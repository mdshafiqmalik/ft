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

let smallLogo = document.getElementById('small-logo');
let leftMenu = document.getElementById('nav-left-menu');
let sideMenu = document.getElementById('sideMenu');
let sideMenuList = document.querySelectorAll('.sideMenusList');
let menus = document.querySelectorAll('.menus');
let menuProfile = document.getElementById('sideMenu-profile');
let menusIcon = document.querySelectorAll('.menusIcon');

function toggleNav(){
  // when not collapsed
  if (navInfo.innerHTML === "expand") {
    navInfo.innerHTML = "collapsed";
    sideMenu.style.width= "auto";
    sideMenu.style.minWidth= "0px";
    menus.forEach(a=>a.style.display = "none");
    menusIcon.forEach(a=>a.style.width = "auto");
    sideMenuList.forEach(a=>a.style.display = "list-item");
    sideMenuList.forEach(a=>a.style.padding = "1rem");
    menuProfile.style.display= "none";
  // When collapsed
  }
  else {
    navInfo.innerHTML = "expand";
    sideMenu.style.display= "flex";
    sideMenu.style.width= "auto";
    sideMenu.style.minWidth= "260px";
    logo.style.display = "inline";
    menus.forEach(a=>a.style.display = "flex");
    sideMenuList.forEach(a=>a.style.display = "flex");
    menuProfile.style.display= "block";
    menusIcon.forEach(a=>a.style.width = "50%");
  }
}
