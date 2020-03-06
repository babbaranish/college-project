<?php
include_once "./Config/db.php";
session_start();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css">
</head>

<body>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>

    <!--MENS SECTION-->
    <section class="item-container">
        <h1 class="item-title-container">
            <a href="./mens.php">MENS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromMens)) {

            ?>
            <form method="post" action="session.php?id=<?php echo $data["id"]; ?>">
                <div class="item-container">
                    <?php echo '<img class="img" name="item_image" src="data:image/png;base64,' . base64_encode($data['image']) . '" />'; ?>
                    <div class="title-container">
                        <span name="product-name" class="title-name"><?php echo $data['product'] ?></span>
                        <span name="pro-price" class="price">$<?php echo $data['price'] ?></span>
                        <input type="hidden" name="hidden_name" value="<?php echo $data["product"]; ?>" />
                        <input type="hidden" name="hidden_price" value="<?php echo $data["price"]; ?>" />
                        <input type="hidden" name="quantity" value="<?php echo 1 ?>" />

                    </div>
                    <button type="submit" id="addtoCart" name="add_to_cart" class="custom-btn">ADD TO CART</button>
                </div>
            </form>
            <?php
            }
            ?>
        </div>
    </section>

    <!--WOMENS SECTION-->
    <section class="item-container">
        <h1 class="item-title-container">
            <a href="./womens.php">WOMENS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromWomens)) {

            ?>
            <form method="post" action="session.php?id=<?php echo $data["id"]; ?>">
                <div class="item-container">
                    <?php echo '<img class="img" name="item_image" src="data:image/png;base64,' . base64_encode($data['image']) . '" />'; ?>
                    <div class="title-container">
                        <span name="product-name" class="title-name"><?php echo $data['product'] ?></span>
                        <span name="pro-price" class="price">$<?php echo $data['price'] ?></span>
                        <input type="hidden" name="hidden_name" value="<?php echo $data["product"]; ?>" />
                        <input type="hidden" name="hidden_price" value="<?php echo $data["price"]; ?>" />
                        <input type="hidden" name="quantity" value="<?php echo 1 ?>" />

                    </div>
                    <button type="submit" id="addtoCart" name="add_to_cart" class="custom-btn">ADD TO CART</button>
                </div>
            </form>
            <?php
            }
            ?>
        </div>
    </section>

    <!--SNEAKERS SECTION-->
    <section class="item-container">
        <h1 class="item-title-container">
            <a href="./sneakers.php">SNEAKERS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromSneakers)) {

            ?>
            <form method="post" action="session.php?id=<?php echo $data["id"]; ?>">
                <div class="item-container">
                    <?php echo '<img class="img" name="item_image" src="data:image/png;base64,' . base64_encode($data['image']) . '" />'; ?>
                    <div class="title-container">
                        <span name="product-name" class="title-name"><?php echo $data['product'] ?></span>
                        <span name="pro-price" class="price">$<?php echo $data['price'] ?></span>
                        <input type="hidden" name="hidden_name" value="<?php echo $data["product"]; ?>" />
                        <input type="hidden" name="hidden_price" value="<?php echo $data["price"]; ?>" />
                        <input type="hidden" name="quantity" value="<?php echo 1 ?>" />

                    </div>
                    <button type="submit" id="addtoCart" name="add_to_cart" class="custom-btn">ADD TO CART</button>
                </div>
            </form>
            <?php
            }
            ?>
        </div>
    </section>

    <!--JACKETS SECTION-->
    <section class="item-container">
        <h1 class="item-title-container">
            <a href="./jackets.php">JACKETS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromJackets)) {

            ?>
            <form method="post" action="session.php?id=<?php echo $data["id"]; ?>">
                <div class="item-container">
                    <?php echo '<img class="img" name="item_image" src="data:image/png;base64,' . base64_encode($data['image']) . '" />'; ?>
                    <div class="title-container">
                        <span name="product-name" class="title-name"><?php echo $data['product'] ?></span>
                        <span name="pro-price" class="price">$<?php echo $data['price'] ?></span>
                        <input type="hidden" name="hidden_name" value="<?php echo $data["product"]; ?>" />
                        <input type="hidden" name="hidden_price" value="<?php echo $data["price"]; ?>" />
                        <input type="hidden" name="quantity" value="<?php echo 1 ?>" />

                    </div>
                    <button type="submit" id="addtoCart" name="add_to_cart" class="custom-btn">ADD TO CART</button>
                </div>
            </form>
            <?php
            }
            ?>
        </div>
    </section>

    <!--HATS SECTION-->
    <section class="item-container">
        <h1 class="item-title-container">
            <a href="./hats.php">HATS</a>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromHats)) {

            ?>
            <form method="post" action="session.php?id=<?php echo $data["id"]; ?>">
                <div class="item-container">
                    <?php echo '<img class="img" name="item_image" src="data:image/png;base64,' . base64_encode($data['image']) . '" />'; ?>
                    <div class="title-container">
                        <span name="product-name" class="title-name"><?php echo $data['product'] ?></span>
                        <span name="pro-price" class="price">$<?php echo $data['price'] ?></span>
                        <input type="hidden" name="hidden_name" value="<?php echo $data["product"]; ?>" />
                        <input type="hidden" name="hidden_price" value="<?php echo $data["price"]; ?>" />
                        <input type="hidden" name="quantity" value="<?php echo 1 ?>" />

                    </div>
                    <button type="submit" id="addtoCart" name="add_to_cart" class="custom-btn">ADD TO CART</button>
                </div>
            </form>
            <?php
            }
            ?>
        </div>
    </section>
    <script src="./JS/index.js"></script>
</body>

</html>