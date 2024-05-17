function validateSignUp(form) {
    document.getElementById("statusMsg").innerText = "";
  
    fail += validateUsername(form.username.value);
    fail += validatePassword(form.password.value);
    fail += validateEmail(form.email.value);
  
    if (fail == "") return true;
  
    document.getElementById("statusMsg").innerText = fail;
  
    return false;
}
  
function validateLogin(form) {
    document.getElementById("statusMsg").innerText = "";
    fail = validateUsername(form.username.value);
    fail += validatePassword(form.password.value);
  
    if (fail == "") return true;
  
    document.getElementById("statusMsg").innerText = fail;
  
    return false;
}
  
function validateUsername(field) {
    if (field == "") return "No Username was entered.\n";
    else if (field.length < 5)
      return "Usernames must be at least 5 characters.\n";
    else if (/[^a-zA-Z0-9_-]/.test(field))
      return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n";
    return "";
  }
  
function validatePassword(field) {
    if (field == "") return "No Password was entered.\n";
    else if (field.length < 6)
      return "Passwords must be at least 6 characters.\n";
    else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) || !/[0-9]/.test(field))
      return "Passwords require one each of a-z, A-Z and 0-9.\n";
    return "";
  }
  
function validateEmail(field) {
    if (field == "") return "No Email was entered.\n";
    else if (
      !(field.indexOf(".") > 0 && field.indexOf("@") > 0) ||
      /[^a-zA-Z0-9.@_-]/.test(field)
    )
      return "The Email address is invalid.\n";
    return "";
}

function validateInputMessage(form) {
  var textprompt = document.getElementById("input-text");
  var option = form.querySelector('input[name="option"]:checked'); // Get the checked radio button
  var statusMsg = document.getElementById("statusMsg");

  if(textprompt.length < 0){
    statusMsg.innerText = "Please input your prompt."; 
    return false; // Prevent form submission
  }else{
    statusMsg.innerText = ""; // Clear any previous error message
    return true; // Allow form submission
  }

  // if (option === null) {
  //     statusMsg.innerText = "Please select an option."; // No option selected
  //     return false; // Prevent form submission
  // } else {
  //     statusMsg.innerText = ""; // Clear any previous error message
  //     return true; // Allow form submission
  // }
}