<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
}
?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css" />
    <title>ADD ITEMS</title>
</head>

<body>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>


    <div class="add-product-container">
        <h1>ADD PRODUCT TO THE SHOP</h1>
        <form class="add-product-form" action='./Config/submit.php' method="post" enctype="multipart/form-data">
            <div class="add-input-container">
                <label class="add-label">IMAGE: </label>
                <div class="inputs">
                    <input style="margin:7px 0 0 20px" type="file" name="image" required></input><br><br>
                </div>
            </div>
            <div class="add-input-container">
                <label class="add-label">NAME: </label>
                <div class="inputs">
                    <input class="input" type="text" name="name" required></input><br><br>
                </div>
            </div>
            <div class="add-input-container">
                <label class="add-label">PRICE: </label>
                <div class='inputs'>

                    <input class="input" type="text" name="price" required></input><br><br>
                </div>

            </div>
            <div class="add-input-container">
                <label class="add-label">CATEGORY: </label>
                <div class='inputs'>
                    <input class="input" type="text" name="category" required></input><br><br>
                </div>

            </div>
            <input class="add-button" type="submit" name="submit">
        </form>
    </div>



    <script src="./JS/storage.js"></script>
</body>

</html>