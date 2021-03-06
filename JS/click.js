//All selected elements
const label = document.querySelector(".password-label");
const passInput = document.getElementById("password");
const emailLabel = document.querySelector(".email-label");
const emailInput = document.querySelector("#email");
const nameInput = document.querySelector("#name");
const nameLabel = document.querySelector(".name-label");
const signUpEmail = document.querySelector("#sign-up-email");
const signUpEmailLabel = document.querySelector(".sign-up-email-label");
const signUpPassword = document.querySelector("#sign-up-password");
const signUpPasswordLabel = document.querySelector(".sign-up-password-label");
const confPassword = document.querySelector("#conf-password");
const confPasswordLabel = document.querySelector(".conf-password-label");

// check if length of password is greater or equal 0
// if length is greater than 1 than add shrink class
// if length is equals to 0 then remove the shrink class hehe
const checkPass = passInput => {
  if (passInput.value.length > 0) {
    label.classList.add("shrink1");
  }
  if (passInput.value.length == 0) {
    label.classList.toggle("shrink1");
  }
};
//check if length of email is greater or equal 0
// if length is greater than 1 than add shrink class
// if length is equals to 0 then remove the shrink class hehe
const checkEmail = emailInput => {
  if (emailInput.value.length > 0) {
    emailLabel.classList.add("shrink1");
  }
  if (emailInput.value.length == 0) {
    emailLabel.classList.toggle("shrink1");
  }
};
//check if length of name is greater or equal 0
// if length is greater than 1 than add shrink class
// if length is equals to 0 then remove the shrink class hehe
const checkName = nameLabel1 => {
  if (nameLabel1.value.length > 0) {
    nameLabel.classList.add("shrink1");
  }
  if (nameLabel1.value.length == 0) {
    nameLabel.classList.toggle("shrink1");
  }
};

//check if length of signUpEmail is greater or equal 0
// if length is greater than 1 than add shrink class
// if length is equals to 0 then remove the shrink class hehe
const checkSignUpEmail = signUpEmail => {
  if (signUpEmail.value.length > 0) {
    signUpEmailLabel.classList.add("shrink1");
  }
  if (signUpEmail.value.length == 0) {
    signUpEmailLabel.classList.toggle("shrink1");
  }
};
//check if length of signUpPassword is greater or equal 0
// if length is greater than 1 than add shrink class
// if length is equals to 0 then remove the shrink class hehe
const checkSignUpPass = signUpPass => {
  if (signUpPass.value.length > 0) {
    signUpPasswordLabel.classList.add("shrink1");
  }
  if (signUpPass.value.length == 0) {
    signUpPasswordLabel.classList.toggle("shrink1");
  }
};
//check if length of confirmPassword is greater or equal 0
// if length is greater than 1 than add shrink class
// if length is equals to 0 then remove the shrink class hehe
const checkConfPass = confPassword => {
  if (confPassword.value.length > 0) {
    confPasswordLabel.classList.add("shrink1");
  }
  if (confPassword.value.length == 0) {
    confPasswordLabel.classList.toggle("shrink1");
  }
};
//

//adding event listner to password input field when we click on the input field
passInput.addEventListener("focus", function() {
  checkPass(this);
});
//adding event listner to email input field when we click on the input field
emailInput.addEventListener("focus", function() {
  checkEmail(this);
});
//adding event listner to password input field when we focusout the input field
passInput.addEventListener("focusout", function() {
  checkPass(this);
});
//adding event listner to email input field when we focusout the input field
emailInput.addEventListener("focusout", function() {
  checkEmail(this);
});
//adding event listner to name input field when we focus the input field
nameInput.addEventListener("focus", function() {
  checkName(this);
});
//adding event listner to name input field when we focusout the input field
nameInput.addEventListener("focusout", function() {
  checkName(this);
});
//adding event listner to signUpEmail input field when we focus the input field
signUpEmail.addEventListener("focus", function() {
  checkSignUpEmail(this);
});
//adding event listner to signUpEmail input field when we focusout the input field
signUpEmail.addEventListener("focusout", function() {
  checkSignUpEmail(this);
});
//adding event listner to signUpPassword input field when we focus the input field
//
signUpPassword.addEventListener("focus", function() {
  checkSignUpPass(this);
});
//adding event listner to signUpPassword input field when we focusout the input field
signUpPassword.addEventListener("focusout", function() {
  checkSignUpPass(this);
});
//adding event listner to confirmPassword input field when we focus the input field
confPassword.addEventListener("focus", function() {
  checkConfPass(this);
});
//adding event listner to confirmPassword input field when we focusout the input field
confPassword.addEventListener("focusout", function() {
  checkConfPass(this);
});
