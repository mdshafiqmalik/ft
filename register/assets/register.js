let registerButton =  document.getElementById("submit");
registerButton.style.background = "Linear-gradient(to right, #917ba2, #8f6285)";

function onSubmit(token){

  if (checkUsername() && checkEmail() && checkPassword()) {
    let registerButton =  document.getElementById("submit");
    registerButton.style.background = "Linear-gradient(to right, #917ba2, #8f6285)";
  }else {
    let registerButton =  document.getElementById("submit");
    registerButton.style.background = "linear-gradient(to right, rgb(79, 0, 141), rgb(104, 3, 82))";
  }
}

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

function optionalView(){
  var closed = document.getElementById('optArrow').style.transform;
  var optionalFields = document.getElementById('optionalFields').style;
  if (closed == 'rotateX(0deg)') {
    document.getElementById('optArrow').style.transform = "rotateX(180deg)";
    optionalFields.display = "flex";
  }else {
    document.getElementById('optArrow').style.transform = "rotateX(0deg)";
    optionalFields.display = "none";
  }
}

function checkUsername(){
  let userInputField = document.getElementById('username');
  let userError = document.getElementById('USB');
  let userInput = userInputField.value;
  const registerAPI =`/.htHidden/API/Internal/register.php?username=${userInput}`;
  let uValid;
  let messageStatus;
  if (userInput.length === 0) {
    uValid = false;
    userError.innerHTML = "Username is required &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (userInput.length < 6) {
    uValid = false;
    userError.innerHTML = "Username Too Short &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (hasWhiteSpace(userInput)) {
      uValid = false;
      userError.innerHTML = "Spaces Not Allowed  &#10006;";
      userError.style.color = "red";
      userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else if (hasUnameSC(userInput)) {
      uValid = false;
      userError.innerHTML = "This char is not allowed  &#10006;<br>( _ ) underscore is allowed only";
      userError.style.color = "red";
      userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else {
    checkUsernameExists(registerAPI);
    async function checkUsernameExists(url){
      userError.innerHTML = " Checking....";
      userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
      userError.style.color = "green";
      const response = await fetch(url);
      var data = await response.json();
      uValid = data.Result;
      messageStatus = data.Status;
      if (uValid) {
        userError.innerHTML = messageStatus+" &#10006;";
        userError.style.color = "red";
        userInputField.style.boxShadow = "0px 0px 3px 0px red";
      }else {
        userError.innerHTML = messageStatus+" &#10004;";
        userError.style.color = "green";
        userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
      }
    }
  }
  return uValid;
}


if (document.getElementById('inviteID').value.length != 0) {
  checkInviteID();
}
function checkInviteID(){
  let userInputField = document.getElementById('inviteID');
  let userInput = userInputField.value;
  let userError = document.getElementById('EII');
  let iValid;
  if (userInput.length === 0) {
    iValid = true; // No Invite ID
    userError.style.display = "none";
  }
  else if (userInput.length < 10) {
    iValid = false; // No Invite ID
    userError.style.display = "block";
    userError.innerHTML = "10 Chars needed &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else {
    userError.style.display = "block";
    const registerAPI =`/.htHidden/API/Internal/register.php?inviteID=${userInput}`;
    checkInviteID(registerAPI);
    async function checkInviteID(url){
      userError.innerHTML = "Validating....";
      userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
      userError.style.color = "green";
      const response = await fetch(url);
      var data = await response.json();
      iValid = data.Result;
      if (iValid) {
        userError.innerHTML = "Invalid Invite Code &#10006;";
        userError.style.color = "red";
        userInputField.style.boxShadow = "0px 0px 3px 0px red";
      }else {
        userError.innerHTML = "Invite Code Found &#10004;";
        userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
        userError.style.color = "green";


      }
    }
  }
  return iValid;
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
    userError.innerHTML = "Spaces not allowed &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    eValid =false;
  }else if (!isMail) {
    userError.innerHTML = "Invalid Email &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    eValid =false;
  }else if (hasEmailChars(userInput)) {
    userError.innerHTML = "Invalid Email &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    eValid =false;
  }else {
    checkEmailExists(registerAPI);
    async function checkEmailExists(url){
      userError.innerHTML = " Checking....";
      userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
      userError.style.color = "green";
      const response = await fetch(url);
      var data = await response.json();
      eValid = data.Result;
      var status  = data.Status;
      if (eValid) {
        userError.innerHTML = status+" &#10006;";
        userError.style.color = "red";
        userInputField.style.boxShadow = "0px 0px 3px 0px red";
        eValid = false;
      }else {
        userError.innerHTML = status+" &#10004;";
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
    userError.innerHTML = "Minimum 8 chars &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    pValid = false;
  }else if ( hasWhiteSpace(userInput)) {
    userError.innerHTML = "Spaces not allowed &#10006;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    pValid = false;
  }else if (hasUpperandLowerCase(userInput) &&  hasAllSpecialChars(userInput) && hasNumber(userInput)) {
    userError.innerHTML = "Strong Password &#10004;";
    userError.style.color = "green";
    userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
    pValid = true;
  }else if (hasLowerCase(userInput) && hasUpperCase(userInput) ) {
    userError.innerHTML = "Medium Password &#10004;";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px orange";
    pValid = true;
  }else if ( (hasLowerCase(userInput) || hasUpperCase(userInput))&& hasAllSpecialChars(userInput)) {
    userError.innerHTML = "Medium Password &#10004;";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px orange";
    pValid = true;
  }else if ( (hasLowerCase(userInput) || hasUpperCase(userInput))&& hasNumber(userInput)) {
    userError.innerHTML = "Medium Password &#10004;";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px orange";
    pValid = true;
  }else if ((hasAllSpecialChars(userInput) && hasNumber(userInput))) {
    userError.innerHTML = "Medium Password &#10004;";
    userError.style.color = "orange";
    userInputField.style.boxShadow = "0px 0px 3px 0px orange";
    pValid = true;
  }else {
    userError.innerHTML = "Weak Password &#10004;";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
    pValid = true;
  }
  return pValid;
}


function hasNumber(string){
  return /\d/.test(string);
}
function hasLowerCase(str){
  let x = /[A-Z]/.test(str);
  return x;
}

function hasUpperCase(str){
  let x = /[a-z]/.test(str);
  return x;
}

function hasUpperandLowerCase(str){
  let has = (hasLowerCase(str) && hasUpperCase(str));
  return has;
}

function hasWhiteSpace(data){
  return data.includes(' ');
}

function hasEmailChars(str) {
  const specialChars = /[`!#$%^&*()+\-=\[\]{};':"\\|,<>\/?~]/;
  return specialChars.test(str);
}

function hasUnameSC(str) {
  const specialChars = /[`!@#$%^&*()+\-=\[\]{};':"\\|,<>\/?~]/;
  return specialChars.test(str);
}


function hasAllSpecialChars(str) {
  const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
  return specialChars.test(str);
}

function hideError(a){
  let error = document.getElementById('adminErros');
  error.style.display = "none";
}
