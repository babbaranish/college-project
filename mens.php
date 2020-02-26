<?php
include_once './Config/db.php';
session_start();
$query = 'SELECT * FROM mens';
$dataFromDB = mysqli_query($db, $query);

?>
<html>

<head>
    <title>Mens</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css">
</head>

<body>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>

    <!-- MENS COLLECTION PAGE -->
    <div class="mens-container">
        <h1 class="mens-title-container">
            <center>MENS</center>
        </h1>
        <div class="mens-img-container">
            <?php
            while ($data = mysqli_fetch_assoc($dataFromDB)) {
                echo '
                    <div class="mens-item-container">
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
    <script src="./JS/storage.js"></script>
    <script src="./JS/index.js"></script>

</body>

</html>