
function openEye(){
  let eyeIcon = document.querySelector(".spPassword img");
  let spPasswordInput = document.querySelector(".spPassword input");
  if (eyeIcon.dataset.status == "closed"){
    spPasswordInput.type=  "text";
    eyeIcon.setAttribute("data-status", "opened");
    eyeIcon.src = "/assets/svgs/eye_show.svg";
  }else {
    eyeIcon.src = "/assets/svgs/eye_closed.svg";
    eyeIcon.setAttribute("data-status", "closed");
    spPasswordInput.type=  "passsword";
  }
}
