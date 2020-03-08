<?php session_start();

$connect = mysqli_connect("localhost", "root", "", "shop");
//check if add_to_cart is pressed
if (isset($_POST["add_to_cart"])) {
	if (isset($_SESSION["shopping_cart"])) {  // if session is set to shoppingcart then this will run
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id"); //Return the values from a single column in the input array
		if (!in_array($_GET["id"], $item_array_id)) {   // if get id is already in or not if not in then this will run and set the values to the shopping_cart session
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'		=>	$_GET["id"],
				'item_name'		=>	$_POST["hidden_name"],
				'item_img' 		=> $_POST['item_image'],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
			echo '<script> console.log($item_array)';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else {
			$count = count($_SESSION["shopping_cart"]);
			for ($i = 0; $i < $count; $i++) {
				if ($_SESSION["shopping_cart"][$i]['item_id'] == $_GET["id"]) {
					$_SESSION["shopping_cart"][$i]['item_quantity'] += 1;
					$_SESSION["shopping_cart"][$i]['item_price'] = $_SESSION["shopping_cart"][$i]['item_price'] * $_SESSION["shopping_cart"][$i]['item_quantity'];
				}
			}

			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	} else {  // if not in session then this will run and add all the values to the session
		$item_array = array(
			'item_id'		=>	$_GET["id"],
			'item_name'		=>	$_POST["hidden_name"],
			'item_img' 		=> $_POST['item_image'],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		echo '<script> console.log($item_array)';
	}
}
// if action=delete then this will run and delete the product from session
if (isset($_GET["action"])) {
	if ($_GET["action"] == "delete") {
		foreach ($_SESSION["shopping_cart"] as $keys => $values) {
			if ($values["item_id"] == $_GET["id"]) { // check the id of product and unset that product ez
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}
	}
}