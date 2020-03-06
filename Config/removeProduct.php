<?php
include_once './db.php';
$productName = $_REQUEST['name'];
$category = $_REQUEST['category'];
// product categories which are allowed to be enter in the shop
$allowedCategories = array(1 => 'mens', 2 => 'womens', 3 => 'sneakers', 4 => 'hats', 5 => 'jackets');
// if the category is in array then this query will run hehe
if (in_array($category, $allowedCategories)) {
    $query = 'DELETE FROM ' . $category . ' WHERE product = "' . $productName . '"';
    if (mysqli_query($db, $query)) {
        echo 'PRODUCT DELETED. REDIRECTING TO ADMIN PAGE';
        header("refresh:3;url=../admin.php");
    } else {
        echo 'NO PRODUCT FOUND. REDIRECTING TO ADMIN PAGE';
        header("refresh:3;url=../admin.php");
    }
} else {   //runs if wrong category is entered hehe
    echo 'ENTER RIGHT PRODUCT OR CATEGORY. REDIRECTING TO ADMIN PAGE';
    header("refresh:3;url=../admin.php");
}