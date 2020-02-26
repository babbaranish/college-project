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
    <script src="./JS/storage.js"></script>

</body>

</html>