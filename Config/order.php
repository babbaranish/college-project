<?php
session_start();
include_once './db.php';
// when someone press submit button then this query will run
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($db, $_REQUEST['name']); // mysqli_real_escape_string will Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
    $mobile = mysqli_real_escape_string($db, $_REQUEST['mobile']);
    $city = mysqli_real_escape_string($db, $_REQUEST['city']);
    $pincode = mysqli_real_escape_string($db, $_REQUEST['pincode']);
    $address = mysqli_real_escape_string($db, $_REQUEST['address']);
    //insert query
    $query = "INSERT INTO orders(name,mobile,city,pincode,address) VALUES ('$name','$mobile','$city',$pincode,'$address')";
    if (mysqli_query($db, $query)) {
        echo "<h1>ORDER PLACED SUCCESSFULLY. YOU WILL GET AN EMAIL SHORTLY. </h1>";
        //unset the shopping cart session i.e. clear the cart ez
        unset($_SESSION['shopping_cart']);
        // redirect to the shopping cart page.
        header("refresh:3;url=../checkout.php");
    } else {
        echo "<h1>THERE'S SOME ISSUE IN PLACING ORDER.</h1>";
        // redirect to the shopping cart page.
        header("refresh:3;url=../checkout.php");
    }
}