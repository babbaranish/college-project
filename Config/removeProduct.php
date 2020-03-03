<?php
include_once './db.php';
$productName = $_REQUEST['name'];
$category = $_REQUEST['category'];
$allowedCategories = array(1 => 'mens', 2 => 'womens', 3 => 'sneakers', 4 => 'hats', 5 => 'jackets');
if (in_array($category, $allowedCategories)) {
    $query = 'DELETE FROM ' . $category . ' WHERE product = "' . $productName . '"';
    if (mysqli_query($db, $query)) {
        echo 'PRODUCT DELETED. REDIRECTING TO ADMIN PAGE';
        header("refresh:3;url=../admin.php");
    } else {
        echo 'NO PRODUCT FOUND. REDIRECTING TO ADMIN PAGE';
        header("refresh:3;url=../admin.php");
    }
} else {
    echo 'ENTER RIGHT PRODUCT OR CATEGORY. REDIRECTING TO ADMIN PAGE';
    header("refresh:3;url=../admin.php");
}