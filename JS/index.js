const addToCartBtn = document.querySelector(".custom-btn");
console.log(addToCartBtn);

for (let i = 0; i < addToCartBtn.length; i++) {
  let button = addToCartBtn[i];
  button.addEventListener("click", addToCartClicked);
}

function addToCartClicked(event) {
  const button = event.target;
  const shopItem = button.parentElement;
  const title = shopItem.getElementsByClassName("title-name")[0].innerText;

  addItemToCart(title);
}
// ADD TO CART FUNCTION HEHE
const addItemToCart = title => {
  const cartItems = document.getElementsByClassName("cart-items")[0];
  var cartItemNames = cartItems.getElementsByClassName("title-name");
  for (var i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].innerText == title) {
      alert("This item is already added to the cart");
      return;
    }
  }
};
