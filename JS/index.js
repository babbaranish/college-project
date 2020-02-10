//All selected elements
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

  addItemToCart(title, price, imageSrc);
}
// ADD TO CART FUNCTION HEHE
function addItemToCart(title, price, imageSrc) {
  const cartRow = document.createElement("div");

  const cartItems = document.getElementsByClassName("cart-items")[0];
  var cartItemNames = cartItems.getElementsByClassName("title-name");
  for (var i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].innerText == title) {
      alert("This item is already added to the cart");
      return;
    }
  }

  cartItems.innerHTML += `
    <div class="item">  
    <img class="img" src="${imageSrc}" alt="">
      <div class="title-container">
        <span class="title-name">${title}</span><br>
        <span class="price">${price}</span>
      </div>
    </div>
  `;
  cartItems.appendChild(cartRow);
  updateCartValue();
}

//toggle cart event listener
cartIcon[0].addEventListener("click", function() {
  cartDrop[0].classList.toggle("visible");
});

function updateCartValue() {
  const cartItem = document.getElementsByClassName("cart-items")[0];
  const cartValue = cartItem.childElementCount / 2; //dividing by 2 coz flexbox added its div to seperate elements hehe ez
  document.querySelector("#cart-value").innerHTML = cartValue;
}
