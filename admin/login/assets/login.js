function onSubmit(token){
  if (checkUsername()) {
    if (checkPassword()) {
      document.getElementById("submit").disabled = false;
      document.getElementById("submit").style.background = "linear-gradient(to right, #4f008d, #680352)";
    }
  }
}


function checkPassword(){
  let userInputField = document.getElementById('password');
  let userError = document.getElementById('PSB');
  let userInput = userInputField.value;
  let uValid = false;
  if (userInput.length < 1) {
    uValid = false;
    userError.innerHTML = "Password is empty";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else {
    uValid = true;
    userError.innerHTML = "Password OK";
    userError.style.color = "green";
    userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
  }
  return uValid;
}

function checkUsername(){
  let userInputField = document.getElementById('username');
  let userError = document.getElementById('USB');
  let userInput = userInputField.value;
  let uValid = false;
  if (userInput.length < 6) {
    uValid = false;
    userError.innerHTML = "Username Too Short";
    userError.style.color = "red";
    userInputField.style.boxShadow = "0px 0px 3px 0px red";
  }else {
    if (hasWhiteSpace(userInput)) {
      uValid = false;
      userError.innerHTML = "Spaces Not Allowed ";
      userError.style.color = "red";
      userInputField.style.boxShadow = "0px 0px 3px 0px red";
    }else if (hasNumber(userInput)) {
      uValid = false;
      userError.innerHTML = "Numbers Not Allowed";
      userError.style.color = "red";
      userInputField.style.boxShadow = "0px 0px 3px 0px red";
    }else {
      uValid = true;
      userError.innerHTML = "Username OK";
      userError.style.color = "green";
      userInputField.style.boxShadow = "0px 0px 3px 0px #1dff00";
    }
  }
  return uValid;
}


function hasWhiteSpace(data){
  return data.includes(' ');
}
function hasNumber(string){
  return /\d/.test(string);
}

function hasSpecialChars(str) {
  const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
  return specialChars.test(str);
}
