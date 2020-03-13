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
            //if the user or admin isn't logged in then it'll display sign in button else sign out
            if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
                echo ' <a href="./Config/signout.php">SIGN OUT</a>';
            } else {
                echo ' <a href="./signInSignUp.php">SIGN IN</a>';
            }
            ?>
        </li>
        <?php
        if (isset($_SESSION['admin'])) {
            echo '';
        } else {
            echo '<a href="./checkout.php">
                <li class="cart-icon-container">
                    <img class="cart-icon" src="./assets/cart.svg" alt="cart icon" />
                    <span style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;">';
            //count the items available in shopping_cart and echo the total numbers of item
            if (!empty($_SESSION["shopping_cart"])) {
                $total = 0;
                foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    $total +=  1;
                }
                echo $total;
            } else {
                echo 0;
            }
            echo '</span>';
        }
        ?>



        </li>
        </a>
    </ul>
</nav>