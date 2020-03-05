<?php session_start();

$connect = mysqli_connect("localhost", "root", "", "shop");

if (isset($_POST["add_to_cart"])) {
	if (isset($_SESSION["shopping_cart"])) {
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if (!in_array($_GET["id"], $item_array_id)) {
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
			echo '<script>alert("Item Already Added")</script>';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	} else {
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

if (isset($_GET["action"])) {
	if ($_GET["action"] == "delete") {
		foreach ($_SESSION["shopping_cart"] as $keys => $values) {
			if ($values["item_id"] == $_GET["id"]) {
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}
	}
}