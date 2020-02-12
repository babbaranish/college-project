const updateCartValue1 = () => {
  const cartItem = document.getElementsByClassName("cart-items")[0];
  const cartValue = Math.floor(cartItem.childElementCount / 2); //dividing by 2 coz flexbox added its div to seperate elements hehe ez
  console.log(cartItem);
  console.log(cartValue);
  document.querySelector("#cart-value").innerHTML = cartValue;
};
if (localStorage.length > 0) {
  const cartRow = document.createElement("div");
  const cartItems = document.getElementsByClassName("cart-items")[0];
  cartItems.innerHTML += localStorage.getItem("cart");
  cartItems.appendChild(cartRow);
  updateCartValue1();
}
