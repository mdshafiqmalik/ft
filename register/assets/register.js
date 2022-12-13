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

if (checkUsername() && checkEmail() && checkPassword()) {
  let registerButton =  document.getElementById("submit");
  registerButton.style.background = "linear-gradient(to right, rgb(79, 0, 141), rgb(104, 3, 82))";
  // background: linear-gradient(to right, rgb(79, 0, 141), rgb(104, 3, 82));
}else {
  let registerButton =  document.getElementById("submit");
  registerButton.style.background = "Linear-gradient(to right, #917ba2, #8f6285)";
  // background: linear-gradient(to right, #917ba2, #8f6285);
}

function checkUsername(){
  let userInputField = document.getElementById('username');
  let userError = document.getElementById('USB');
  let userInput = userInputField.value;
  const registerAPI =`/.htHidden/API/Internal/register.php?username=${userInput}`;
  let uValid;
  if (userInput.length === 0) {
    uValid = false;
    userError.innerHTML = "Username is required";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (userInput.length < 8) {
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
  if (userInput.length === 0) {
    uValid = false;
    userError.innerHTML = "Email is required";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (hasWhiteSpace(userInput)) {
    userError.innerHTML = "Spaces not allowed";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    eValid =false;
  }else if (!isMail) {
    userError.innerHTML = "Invalid Email";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    eValid =false;
  }else if (hasSpecialChars(userInput)) {
    userError.innerHTML = `Invalid Email`;
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    eValid =false;
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
        eValid = false;
      }else {
        userError.innerHTML = "Email OK";
        userError.style.color = "green";
        userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
        eValid = true;
      }
    }
  }
  return eValid;
}


function checkPassword(){
  let userInputField = document.getElementById('spPassword');
  let userIn = document.getElementById('newPassword');
  let userError = document.getElementById('PSB');
  let userInput = userIn.value;
  let pValid;
  if (userInput.length === 0) {
    uValid = false;
    userError.innerHTML = "Password is required";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (userInput.length < 8) {
    userError.innerHTML = "Minimum 8 chars";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    pValid = false;
  }else if ( hasWhiteSpace(userInput)) {
    userError.innerHTML = "Spaces not allowed";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    pValid = false;
  }else if (hasNumber(userInput) && hasAllSpecialChars(userInput) && hasUpperandLowerCase(userInput)) {
    userError.innerHTML = "Strong Password";
    userError.style.color = "green";
    userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
    pValid = true;
  }else if (hasUpperandLowerCase(userInput)) {
    userError.innerHTML = "Medium Password";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px orange";
    pValid = true;
  }else if ((hasUpperandLowerCase(userInput) && hasAllSpecialChars(userInput))) {
    userError.innerHTML = "Medium Password";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px orange";
    pValid = true;
  }else if ((hasAllSpecialChars(userInput) && hasNumber(userInput))) {
    userError.innerHTML = "Medium Password";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px orange";
    pValid = true;
  }
  else if ((hasUpperandLowerCase(userInput) && hasNumber(userInput))) {
    userError.innerHTML = "Medium Password";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
    pValid = true;
  }else {
    userError.innerHTML = "Weak Password";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
    pValid = true;
  }
  return pValid;
}

function hasLowerCase(str){                               return str.match(/^[a-z]*$/);
}

function hasUpperCase(str){                               return str.match(/^[A-Z]*$/);
}

function hasNumber(string){
  return /\d/.test(string);
}
function hasUpperandLowerCase(str){
  return (hasLowerCase(str) && hasUpperCase(str));
  const upandlow = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/;
  return upandlow.test(str);
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
