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
  const registerAPI =`/.htHidden/API/Internal/register.php?username=${userInput}`;
  let uValid;
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
    checkUsernameExists(registerAPI);
    async function checkUsernameExists(url){
      const response = await fetch(url);
      var data = await response.json();
      uValid = data.Result;
      if (uValid) {
        userError.innerHTML = "Username Taken";
        userError.style.color = "red";
        userInputField.style.boxShadow = "0px 0px 3px 0px red";
      }else {
        userError.innerHTML = "Username OK";
        userError.style.color = "green";
        userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
      }
    }
  }
  return uValid;
}



function checkEmail(){
  let userInputField = document.getElementById('email');
  let userError = document.getElementById('ESB');
  let userInput = userInputField.value;
  let eValid;
  var re = /\S+@\S+\.\S+/;
  var isMail = re.test(userInput);
  const registerAPI =`/.htHidden/API/Internal/register.php?email=${userInput}`;
  if (hasWhiteSpace(userInput)) {
    userError.innerHTML = "Spaces not allowed";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (!isMail) {
    userError.innerHTML = "Invalid Email";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (hasSpecialChars(userInput)) {
    userError.innerHTML = `Invalid Email`;
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else {
    checkEmailExists(registerAPI);
    async function checkEmailExists(url){
      const response = await fetch(url);
      var data = await response.json();
      eValid = data.Result;
      if (eValid) {
        userError.innerHTML = "Email Taken";
        userError.style.color = "red";
        userInputField.style.boxShadow = "0px 0px 3px 0px red";
      }else {
        userError.innerHTML = "Email OK";
        userError.style.color = "green";
        userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
      }
    }
  }
}


function checkPassword(){
  let userInputField = document.getElementById('password');
  let userError = document.getElementById('PSB');
  let userInput = userInputField.value;
  let pValid;
  if (userInput.length < 8) {
    userError.innerHTML = "Password Too Short";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if ( hasWhiteSpace(userInput)) {
    userError.innerHTML = "Spaces not allowed";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else {
    
  }
}

function hasNumber(string){
  return /\d/.test(string);
}

function hasWhiteSpace(data){
  return data.includes(' ');
}

function hasSpecialChars(str) {
  const specialChars = /[`!#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~]/;
  return specialChars.test(str);
}

function hasAllSpecialChars(str) {
  const specialChars = /[`!#@$%^&*()_+\-=\[\]{};':"\\|.,<>\/?~]/;
  return specialChars.test(str);
}

function hideError(a){
  let error = document.getElementById('adminErros');
  error.style.display = "none";
}
