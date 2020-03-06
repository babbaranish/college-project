<?php
session_start();
include_once './db.php';
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($db, $_REQUEST['name']);
    $mobile = mysqli_real_escape_string($db, $_REQUEST['mobile']);
    $city = mysqli_real_escape_string($db, $_REQUEST['city']);
    $pincode = mysqli_real_escape_string($db, $_REQUEST['pincode']);
    $address = mysqli_real_escape_string($db, $_REQUEST['address']);
    $query = "INSERT INTO orders(name,mobile,city,pincode,address) VALUES ('$name','$mobile','$city',$pincode,'$address')";
    if (mysqli_query($db, $query)) {
        echo "<h1>ORDER PLACED SUCCESSFULLY. YOU WILL GET AN EMAIL SHORTLY. </h1>";
        unset($_SESSION['shopping_cart']);
        header("refresh:3;url=../checkout.php");
    } else {
        echo "<h1>THERE'S SOME ISSUE IN PLACING ORDER.</h1>";
        header("refresh:3;url=../checkout.php");
    }
}