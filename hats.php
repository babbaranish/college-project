<?php
include_once './Config/db.php';
session_start();
$query = 'SELECT * FROM hats';
$dataFromDB = mysqli_query($db, $query);
?>

<html>

<head>
    <title>Hats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css">
</head>

<body>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>


    <div class="item-container">
        <h1 class="item-title-container">
            <center>HATS</center>
        </h1>
        <div class="item-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromDB)) {

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
    </div>
    <script src="./JS/index.js"></script>

</body>

</html>