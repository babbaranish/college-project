<?php
include_once("./db.php");
//QUERY FOR MENS 
$queryMens = "SELECT * FROM mens LIMIT 4";
$dataFromMens = mysqli_query($db, $queryMens);
//QUERY FOR WOMENS 
$queryWomens = "SELECT * FROM womens LIMIT 4";
$dataFromWomens = mysqli_query($db, $queryWomens);
// QUERY FOR SNEAKERS
$querySneakers = "SELECT * FROM sneakers LIMIT 4";
$dataFromSneakers = mysqli_query($db, $querySneakers);
// QUERY FOR JACKETS
$queryJackets = "SELECT * FROM jackets LIMIT 4";
$dataFromJackets = mysqli_query($db, $queryJackets);
//QUERY FOR HATS
$queryHats = "SELECT * FROM hats LIMIT 4";
$dataFromHats = mysqli_query($db, $queryHats);
?>
<html>

<head>
    <title>Shop Collections</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>

<body>
    <!--NAV-BAR-->
    <nav class="navbar">
        <a class="logo-container" href="../index.php">
            <img src="../assets/crown.svg" alt="shop_home icon" />
        </a>
        <ul class="links-container">
            <li class="links">
                <a href="#">SHOP</a>
            </li>
            <li class="links">
                <a href="./signInSignUp.html">SIGN IN</a>
            </li>
            <li class="cart-icon-container">
                <img class="cart-icon" src="../assets/cart.svg" alt="cart icon">
                <span style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;;">0</span>
                </img>
            </li>
        </ul>
        <div class="cart-dropdown">
            <div class="cart-items"></div>
            <a href='./checkout.html'>
                <button class="cart-button">GO TO CHECKOUT</button>
            </a>
        </div>
    </nav>
    <!--MENS SECTION-->
    <section class="mens-container">
        <h1 class="shop-title-container">
            <a href='./mens.html'>MENS</a>
        </h1>
        <div class="mens-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromMens)) {

                echo '<div class="mens-item-container">
                    <img class="img" src="data:image/png;base64,' . base64_encode($data['image']) . '" />';
                echo '<div class="title-container">
                            <span class="title-name">' . $data['product'] . '</span>
                            <span class="price">$' . $data['price'] . '</span>
                        </div>
                        <button class="custom-btn">ADD TO CART</button>
                    </div>';
            }
            ?>
        </div>
    </section>

    <!--WOMENS SECTION-->
    <section class="womens-container">
        <h1 class="shop-title-container">
            <a href='./womens.html'>WOMENS</a>
        </h1>
        <div class="womens-img-container">
            <?php
            while ($data1 = mysqli_fetch_assoc($dataFromWomens)) {
                echo '<div class="womens-item-container">
                    <img class="img" src="data:image/png;base64,' . base64_encode($data1['image']) . '" />
                    <div class="title-container">
                        <span class="title-name">' . $data1['product'] . '</span>
                        <span class="price">$' . $data1['price'] . '</span>
                    </div>
                    <button class="custom-btn">ADD TO CART</button>
                </div>';
            }
            ?>
        </div>
    </section>

    <!--SNEAKERS SECTION-->
    <section class="item-container">
        <h1 class="shop-title-container">
            <a href='./sneakers.html'>SNEAKERS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromSneakers)) {
                echo '<div class="item-container">
                    <img class="img" src="data:image/png;base64,' . base64_encode($data['image']) . '" />
                    <div class="title-container">
                        <span class="title-name">' . $data['product'] . '</span>
                        <span class="price">$' . $data['price'] . '</span>
                    </div>
                    <button class="custom-btn">ADD TO CART</button>
                </div>';
            }
            ?>
        </div>
    </section>

    <!--JACKETS SECTION-->
    <section class="item-container">
        <h1 class="shop-title-container">
            <a href='./jackets.html'>JACKETS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromJackets)) {
                echo '<div class="item-container">
                    <img class="img" src="data:image/png;base64,' . base64_encode($data['image']) . '" />
                    <div class="title-container">
                        <span class="title-name">' . $data['product'] . '</span>
                        <span class="price">$' . $data['price'] . '</span>
                    </div>
                    <button class="custom-btn">ADD TO CART</button>
                </div>';
            }
            ?>
        </div>
    </section>

    <!--HATS SECTION-->
    <section class="item-container">
        <h1 class="shop-title-container">
            <a href='./hats.html'>HATS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromHats)) {
                echo '<div class="item-container">
                    <img class="img" src="data:image/png;base64,' . base64_encode($data['image']) . '" />
                    <div class="title-container">
                        <span class="title-name">' . $data['product'] . '</span>
                        <span class="price">$' . $data['price'] . '</span>
                    </div>
                    <button class="custom-btn">ADD TO CART</button>
                </div>';
            }
            ?>
        </div>
    </section>
    <script src="../JS/index.js"></script>
</body>

</html>