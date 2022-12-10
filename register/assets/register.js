

function openEye(){
  var closed = document.getElementById('eyeClosed').style.display;
  var opened = document.getElementById('eyeOpened').style.display;
  if (closed == 'block') {
    document.getElementById('eyeClosed').style.display = "none";
    document.getElementById('eyeOpened').style.display = "block";
    document.getElementById('newPassword').type = "text";

    let confirmPass = document.getElementById('confirmPassword');
    if (confirmPass) {
      confirmPass.type = "text";
    }
  }else {
    document.getElementById('eyeOpened').style.display = "none";
    document.getElementById('eyeClosed').style.display = "block";
    document.getElementById('newPassword').type = "password";

    let confirmPassword = document.getElementById('confirmPassword');
    if (confirmPassword) {
      confirmPassword.type = "password";
    }
  }
}


function checkUsername(){
  let userInputField = document.getElementById('username');
  let userError = document.getElementById('USB');
  let userInput = userInputField.value;
  let uValid = false;
  if (userInput.length < 8) {
    uValid = false;
    userError.innerHTML = "Username Too Short";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (hasWhiteSpace(userInput)) {
      uValid = false;
      userError.innerHTML = "Spaces Not Allowed ";
      userError.style.color = "red";
      userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else {
    uValid = true;
    userError.innerHTML = "Username OK";
    userError.style.color = "green";
    userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
  }
  return uValid;
}


checkUsernameExists();

function checkUsernameExists(){
  var response = $.getJSON('/register.php?email=mdshafiqmalik98@gmail.com', function(data){
    console.log(data.result);
    console.log("heello");
  });
}


function hasWhiteSpace(data){
  return data.includes(' ');
}

function hasSpecialChars(str) {
  const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
  return specialChars.test(str);
}

function hideError(a){
  let error = document.getElementById('adminErros');
  error.style.display = "none";
}
