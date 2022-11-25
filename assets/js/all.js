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
let subMenus = document.querySelector(`.subMenu .subMenu-ul`);
let dropdownIcon_b = document.querySelector(`.dropdownIcon-b`);
let dropdownIcon_a = document.querySelector(`.dropdownIcon-a`);

addEventListener("resize", (makeResponsive) => {});

window.onload = function (){
  responsiveNess();
}

// onresize = (makeResponsive) => {
//   responsiveNess();
// };


function toggleNav(){
  // when not collapsed
  if (screen.width <= 570) {
    if (sideMenu.style.width === "0px") {
      expandNav();
    }else {
      collapseNav();
      sideMenu.style.width = "0px";
    }
  }else if (navInfo.innerHTML === "notCollapsed") {
      collapseNav();
  }
  else {
      expandNav();
  }
}
function responsiveNess() {
  if (screen.width <= 570) {
      collapseNav();
      sideMenu.style.width = "0px";
      dropdownIcon_b.style.display = "none";
  }else  {
    dropdownIcon_a.style.display = "none";
    collapseNav();
  }
}

function expandNav() {
  navInfo.innerHTML = "notCollapsed";
  sideMenuList.forEach(a=>a.style.alignItems = "initial");
  sideMenu.style.width= "260px";
  menus.forEach(a=>a.style.display = "flex");
  sideMenuList.forEach(a=>a.style.display = "flex");
  menuProfile.style.display= "block";
  dropdownIcon_b.style.display = "flex";
  dropdownIcon_a.style.display = "none";
}

function collapseNav() {
  navInfo.innerHTML = "collapsed";
  menuProfile.style.display= "none";
  sideMenu.style.width= "80px";
  sideMenuList.forEach(a=>a.style.alignItems = "center");
  sideMenuList.forEach(a=>a.style.padding = "1.125rem 1.25rem 1.125rem 1.25rem");
  menus.forEach(a=>a.style.display = "none");
  menusIcon.forEach(a=>a.style.width = "auto");
  subMenus.style.position ="absolute";
  subMenus.style.boxShadow= "-1px 3px 5px 0px grey";
  dropdownIcon_b.style.display = "none";
  dropdownIcon_a.style.display = "flex";
}

function expandMenus(x){
  let menu = document.querySelector(`.sideMenu ul li:nth-child(${x})`);
  let status = document.querySelector(`.sideMenu ul li:nth-child(${x}) span`);
  if (status.innerHTML==1) {
    dropdownIcon_a.style.transform = "rotate(0deg)";
    dropdownIcon_b.style.transform = "rotate(0deg)";
    subMenus.style.display = "flex";
    status.innerHTML=0;
  }else {
    dropdownIcon_a.style.transform = "rotate(-90deg)";
    dropdownIcon_b.style.transform = "rotate(-90deg)";
    status.innerHTML=1;
    subMenus.style.display = "none";
  }
}
