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

    <center>
        <h1>ADD PRODUCT TO THE SHOP</h1>
        <form action='./Pages/Config/submit.php' method="post" enctype="multipart/form-data">
            <label style="margin-right:10px;font-size:20px;margin-left:60px;">IMAGE : </label>
            <input type="file" name="image" required></input><br><br>
            <label style="margin-right:10px;font-size:20px;">NAME : </label>
            <input type="text" name="name" required></input><br><br>
            <label style="margin-right:10px;font-size:20px;">PRICE : </label>
            <input type="text" name="price" required></input><br><br>
            <label style="margin-right:10px;font-size:20px;">CATEGORY : </label>
            <input type="text" name="category" required></input><br><br>
            <input
                style="height: 50px;letter-spacing:0.5px;line-height: 50px;padding: 0 35px 0 35px;font-size: 15px;background-color: black;color: white;font-family: 'Open Sans Condensed';border:none;cursor:pointer"
                type="submit" name="submit">
        </form>
    </center>


    <script src="./JS/storage.js"></script>
</body>

</html>