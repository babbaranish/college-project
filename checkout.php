<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:./signInSignUp.php');
}
?>

<html>

<head>

    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css" />
    <title>Check out</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <style>

    </style>

</head>

<body>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>


    <div class="checkout-container">
        <div class="checkout-titles">
            <div class="product"><span> Product</span></div>
            <div class="description"><span>Description</span></div>
            <div class="quantity"><span>Quantity</span></div>
            <div class="price"><span> Price </span></div>
            <div class="remove"><span>Remove</span></div>
        </div>




        <div class="total-container">
            Total $<span id='total-price'>0</span>
        </div>
        <div style="width:50%; margin-left: auto;margin-top:30px; " id="paypal-button-container"></div>
    </div>

    <script src="./JS/storage.js"></script>
    <script src="./JS/index.js"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=Ablhq3zYMRmCW8rPE6HXsiHeHRhdMAOCXzxT5ThxPrbnLZaPDZ33fboc_7nB45UPJ4KQSKSZRR5lxzaF&currency=INR">
    </script>

    <script>
    const totalPrice = document.getElementById('total-price').innerText;
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'rect',
            label: 'pay',
            height: 40
        },
    }).render('#paypal-button-container');
    </script>
</body>

</html>