<?php
session_start();
?>
<html>

<head>
    <link rel="stylesheet" href="./CSS/styles.css" />
    <link rel="icon" href="./assets/icon.ico">
    <title>Project Shop</title>
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
            <a href='./checkout.php'>
                <button class="cart-button">GO TO CHECKOUT</button>
            </a>
        </div>
    </nav>

    <!--HOMEPAGE MENU-->
    <div class="menu-container">
        <a href="./hats.php">
            <div class=" menu-item">
                <div id="hats" class="background-image">
                    <div class="content">
                        <h1 class="title">HATS</h1>
                        <span class="subtitle">SHOP NOW</span>
                    </div>
                </div>
            </div>
        </a>
        <a href="./jackets.php">
            <div class=" menu-item">
                <div id="jackets" class="background-image">
                    <div class="content">
                        <h1 class="title">JACKETS</h1>
                        <span class="subtitle">SHOP NOW</span>
                    </div>
                </div>
            </div>
        </a>
        <a href="./sneakers.php">
            <div class=" menu-item">
                <div id="sneakers" class="background-image">
                    <div class="content">
                        <h1 class="title">SNEAKERS</h1>
                        <span class="subtitle">SHOP NOW</span>
                    </div>
                </div>
            </div>
        </a>
        <a href="./womens.php">
            <div class="large menu-item">
                <div id="womens" class="background-image">
                    <div class="content">
                        <h1 class="title">WOMENS</h1>
                        <span class="subtitle">SHOP NOW</span>
                    </div>
                </div>
            </div>
        </a>
        <a href="./mens.php">
            <div class="large menu-item">
                <div id="men" class="background-image">
                    <div class="content">
                        <h1 class="title">MEN</h1>
                        <span class="subtitle">SHOP NOW</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <script src="./JS/index.js"></script>

</body>

</html>