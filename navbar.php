<nav class="navbar">
    <a class="logo-container" href="index.php">
        <img src="./assets/crown.svg" alt="shop_home icon" />
    </a>
    <ul class="links-container">
        <?php
        if (isset($_SESSION['admin'])) {
            echo '<li class="links">
                            <a href="./admin.php">ADD PRODUCTS</a>
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
            <img class="cart-icon" src="./assets/cart.svg" alt="cart icon" />
            <span style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;">0</span>
        </li>
    </ul>
    <div class="cart-dropdown">
        <div class="cart-items"></div>
        <a href='./checkout.php'>
            <button class="cart-button">GO TO CHECKOUT</button>
        </a>
    </div>
</nav>