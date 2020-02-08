<?php
session_start();
?>

<html>

<head>

    <link rel="icon" href="../assets/icon.ico">
    <link rel="stylesheet" href="../CSS/styles.css" />
    <title>Check out</title>
</head>

<body>
    <!--NAV-BAR-->
    <nav class="navbar">
        <a class="logo-container" href="../index.php">
            <img src="../assets/crown.svg" alt="shop_home icon" />
        </a>
        <ul class="links-container">
            <li class="links">
                <a href="./shopPage.php">SHOP</a>
            </li>
            <li class="links">
                <?php
                if (isset($_SESSION['user'])) {
                    echo ' <a href="./Config/signout.php">SIGN OUT</a>';
                } else {
                    echo ' <a href="./signInSignUp.php">SIGN IN</a>';
                }
                ?>
            </li>
            <li class="cart-icon-container">
                <img class="cart-icon" src="../assets/cart.svg" alt="cart icon" />
                <span style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;;">0</span>
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
            <div class="product">Product</div>
            <div class="description">Description</div>
            <div class="quantity">Quantity</div>
            <div class="price">Price</div>
            <div class="remove">Remove</div>
        </div>
        <div class="total-container">
            Total <span>$0</span>
        </div>
    </div>



    <script src="../JS/index.js"></script>
</body>

</html>