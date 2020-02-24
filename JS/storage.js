//update cart value
const updateCartValue1 = () => {
  const cartItem = document.getElementsByClassName("cart-items")[0];
  const cartValue = cartItem.childElementCount;
  document.querySelector("#cart-value").innerHTML = cartValue;
};
//check if cart have any item in it hehe
const cart = localStorage.getItem("cart");
if (cart.length > 0) {
  const cartItems = document.getElementsByClassName("cart-items")[0];
  cartItems.innerHTML += localStorage.getItem("cart");
  updateCartValue1();
}
