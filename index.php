<?php
session_start();
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/styles.css" />
    <link rel="icon" href="./assets/icon.ico">
    <title>Project Shop</title>
</head>

<body>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>

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
    <script src="./JS/storage.js">

    </script>

</body>

</html>