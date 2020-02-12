<?php
session_start();
?>

<html>

<head>

    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css" />
    <title>Check out</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->


</head>

<body>
    <!--NAV-BAR-->
    <nav class="navbar">
        <a class="logo-container" href="./index.php">
            <img src="./assets/crown.svg" alt="shop_home icon" />
        </a>
        <ul class="links-container">
            <?php
            if (isset($_SESSION['admin'])) {
                echo '<li class="links">
                            <a href="./admin.php">ADD PRODUCTS</a>
                        </li>';
            }
            ?>
            <li class="links">
                <a href="./shopPage.php">SHOP</a>
            </li>

            <li class="links">
                <?php
                if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
                    echo ' <a href="./Config/signout.php">SIGN OUT</a>';
                } else {
                    echo ' <a href="./signInSignUp.php">SIGN IN</a>';
                }
                ?>
            </li>
            <li class="cart-icon-container">
                <img class="cart-icon" src="./assets/cart.svg" alt="cart icon" />
                <span id='cart-value'
                    style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;;">0</span>
            </li>
        </ul>
        <div class="cart-dropdown">
            <div class="cart-items"></div>
            <a href='#'>
                <button class="cart-button">GO TO CHECKOUT</button>
            </a>
        </div>
    </nav>

    <div class="checkout-container">
        <div class="checkout-titles">
            <div class="product"><span> Product</span></div>
            <div class="description"><span>Description</span></div>
            <div class="quantity"><span>Quantity</span></div>
            <div class="price"><span>Price</span></div>
            <div class="remove"><span>Remove</span></div>
        </div>
        <div class="total-container">
            Total $<span id='total-price'>0</span>
        </div>
        <div style="width:50%; margin-left: auto;margin-top:30px; " id="paypal-button-container"></div>
    </div>


    <script
        src="https://www.paypal.com/sdk/js?client-id=Ablhq3zYMRmCW8rPE6HXsiHeHRhdMAOCXzxT5ThxPrbnLZaPDZ33fboc_7nB45UPJ4KQSKSZRR5lxzaF&currency=INR">
    </script>
    <script>
    const totalPrice = document.getElementById('total-price').innerText;
    console.log(totalPrice)
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'rect',
            label: 'pay',
            height: 40
        },


    }).render('#paypal-button-container');
    </script>

    <script src="./JS/storage.js"></script>
    <script src="./JS/index.js"></script>
</body>

</html>