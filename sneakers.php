<?php
include_once './Config/db.php';
session_start();
$query = 'SELECT * FROM sneakers';
$dataFromDB = mysqli_query($db, $query);
?>

<html>

<head>
    <title>Sneakers</title>
    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css">
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
                            <a href="../admin.php">ADD PRODUCTS</a>
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
                <img class="cart-icon" src="./assets/cart.svg" alt="cart icon">
                <span id='cart-value'
                    style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;;">0</span>
                </img>
            </li>
        </ul>
        <div class="cart-dropdown">
            <div class="cart-items"></div>
            <a href='./checkout.php'>
                <button class="cart-button">GO TO CHECKOUT</button>
            </a>
        </div>
    </nav>

    <div class="item-container">
        <h1 class="item-title-container">
            <center>SNEAKERS</center>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromDB)) {
                echo '
                    <div class="item-container">
                    <img class="img" src="data:image/png;base64,' . base64_encode($data['image']) . '" />
                        <div class="title-container">
                            <span class="title-name">' . $data['product'] . '</span>
                            <span class="price">$' . $data['price'] . '</span>
                        </div>
                        <button class="custom-btn">ADD TO CART</button>
                    </div>
                    ';
            }
            ?>
        </div>
    </div>
    <script src="./JS/index.js"></script>

</body>

</html>