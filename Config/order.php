<?php
session_start();
include_once './db.php';
// when someone press submit button then this query will run
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($db, $_REQUEST['name']); // mysqli_real_escape_string will Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
    $mobile = mysqli_real_escape_string($db, $_REQUEST['mobile']);
    $city = mysqli_real_escape_string($db, $_REQUEST['city']);
    $pincode = mysqli_real_escape_string($db, $_REQUEST['pincode']);
    $address = ltrim(mysqli_real_escape_string($db, $_REQUEST['address']));
    //insert query
    $query = "INSERT INTO orders(name,mobile,city,pincode,address) VALUES ('$name','$mobile','$city',$pincode,'$address')";
    $email = $_SESSION['user'];
    $updateUserQuery = "UPDATE users SET mobile='$mobile', city='$city', pincode=$pincode, address='$address' WHERE email='$email'";
    if (!empty($name) and !empty($mobile) and !empty($city) and !empty($pincode) and !empty($address)) {
        if (mysqli_query($db, $query)) {
            //unset the shopping cart session i.e. clear the cart ez
            mysqli_query($db, $updateUserQuery);
            unset($_SESSION['shopping_cart']);
            // redirect to the shopping cart page.
            header('location:../checkout.php?success=1');
        } else {
            // redirect to the shopping cart page.
            header('location:../checkoutAddress.php?error=1');
        }
    } else {
        header('location:../checkoutAddress.php?form=1');
    }
}