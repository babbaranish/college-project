<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="./CSS/styles.css" />
    <title>ADD ITEMS</title>
</head>

<body>
    <!--NAV-BAR-->
    <nav class="navbar">
        <a class="logo-container" href="index.html">
            <img src="./assets/crown.svg" alt="shop_home icon" />
        </a>
        <ul class="links-container">
            <li class="links">
                <a href="./Pages/shopPage.html">SHOP</a>
            </li>
            <li class="links"><a href="./Pages/signInSignUp.html">SIGN IN</a></li>
            <li class="cart-icon-container">
                <img class="cart-icon" src="./assets/cart.svg" alt="cart icon" />
                <span style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;;">0</span>
            </li>
        </ul>
        <div class="cart-dropdown">
            <div class="cart-items"></div>
            <a href='./Pages/checkout.html'>
                <button class="cart-button">GO TO CHECKOUT</button>
            </a>
        </div>
    </nav>

    <center>
        <h1>ADD PRODUCT TO THE SHOP</h1>
        <form action='./Pages/submit.php' method="post" enctype="multipart/form-data">
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


</body>

</html>