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
const cartIcon = document.getElementsByClassName("cart-icon-container");
const cartDrop = document.getElementsByClassName("cart-dropdown");
const addToCartBtn = document.getElementsByClassName("custom-btn");

for (let i = 0; i < addToCartBtn.length; i++) {
  let button = addToCartBtn[i];
  button.addEventListener("click", addToCartClicked);
}

function addToCartClicked(event) {
  const button = event.target;
  const shopItem = button.parentElement;
  const title = shopItem.getElementsByClassName("title-name")[0].innerText;
  const price = shopItem.getElementsByClassName("price")[0].innerText;
  const imageSrc = shopItem.getElementsByClassName("img")[0].src;

  console.log(title, price);
  console.log(imageSrc);
  addItemToCart(title, price, imageSrc);
}
// ADD TO CART FUNCTION HEHE
function addItemToCart(title, price, imageSrc) {
  const cartRow = document.createElement("div");
  console.log(imageSrc);
  const cartItems = document.getElementsByClassName("cart-items")[0];
  var cartItemNames = cartItems.getElementsByClassName("title-name");
  for (var i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].innerText == title) {
      alert("This item is already added to the cart");
      return;
    }
  }
  const cartRowContent = `
    <div class="item">  
    <img class="img" src="${imageSrc}" alt="">
      <div class="title-container">
          <span class="title-name">${title}</span><br>
          <span class="price">${price}</span>
      </div>
    </div>
  `;
  cartItems.innerHTML = cartRowContent;
  cartItems.append(cartRow);
}

//toggle cart event listener
cartIcon[0].addEventListener("click", function() {
  cartDrop[0].classList.toggle("visible");
});
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
