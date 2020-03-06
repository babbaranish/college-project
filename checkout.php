<?php
session_start();
include_once('Config/db.php');
if (!isset($_SESSION['user']) and !isset($_SESSION['admin'])) {
    header('location:./signInSignUp.php');
}

?>

<html>

<head>

    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css" />
    <title>Check out</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->


</head>

<body>
    <!-- Checkout Form popup -->
    <div class="popup-container">
        <div class="form-container">
            <form method="post" action="./Config/order.php">
                <div class="input-container">
                    <label for="name">Name</label>
                    <input type="text" name='name'>
                </div>
                <div class="input-container">
                    <label for="mobile">Mobile</label>
                    <input type="text" name='mobile' maxlength="10">
                </div>
                <div class="input-container">
                    <label for="city">City</label>&nbsp;&nbsp;
                    <input type="text" name='city'>
                </div>
                <div class="input-container">
                    <label for="pincode">Pincode</label>
                    <input type="text" name='pincode' maxlength="6">
                </div>
                <div class="input-container">
                    <label for="address">Address</label>
                    <textarea type="text" name='address' rows="3"></textarea>
                </div>
                <div class="input-container">
                    <button class="checkout-submit" type="submit" name='submit'>PLACE ORDER</button>
                </div>
            </form>
            <span onclick='remove()' style="font-size:25px; cursor:pointer">&#10005;</span>

        </div>

    </div>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>

    <div class="checkout-container">
        <div class="checkout-titles">
            <div class="product"><span> Product</span></div>
            <div class="description"><span>Description</span></div>
            <div class="quantity"><span>Quantity</span></div>
            <div class="price"><span> Price </span></div>
            <div class="remove"><span>Remove</span></div>
        </div>
        <?php
        // if shopping cart is not empty then this will run
        if (!empty($_SESSION["shopping_cart"])) {
            $total = 0;
            // get all the value stored in shopping cart
            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                $query = 'SELECT * FROM hats ';
                $dataFromDB = mysqli_query($db, $query);
        ?>
        <div class="checkout-titles checkout-items">
            <!-- creates the product image column -->
            <div class="product" style="padding-right:15px;">
                <?php
                        while ($data = mysqli_fetch_assoc($dataFromDB)) {
                            // check if the id of item is same as the id in hats table
                            if ($values['item_id'] == $data['id']) {
                                echo '<img class="checkout-img"  width="100%" src="data:image/png;base64,' . base64_encode($data['image']) . '" /> ';
                            }
                        } ?>

                <?php
                        $query = 'SELECT * FROM jackets ';
                        $dataFromDB = mysqli_query($db, $query);
                        while ($data = mysqli_fetch_assoc($dataFromDB)) {
                            // check if the id of item is same as the id in jackets table
                            if ($values['item_id'] == $data['id']) {
                                echo '<img class="checkout-img"  width="100%" src="data:image/png;base64,' . base64_encode($data['image']) . '" />';
                            }
                        } ?>

                <?php
                        $query = 'SELECT * FROM sneakers ';
                        $dataFromDB = mysqli_query($db, $query);
                        while ($data = mysqli_fetch_assoc($dataFromDB)) {
                            // check if the id of item is same as the id in sneakers table
                            if ($values['item_id'] == $data['id']) {
                                echo '<img class="checkout-img"  width="100%" src="data:image/png;base64,' . base64_encode($data['image']) . '" />';
                            }
                        } ?>


                <?php
                        $query = 'SELECT * FROM womens ';
                        $dataFromDB = mysqli_query($db, $query);
                        while ($data = mysqli_fetch_assoc($dataFromDB)) {
                            // check if the id of item is same as the id in womens table
                            if ($values['item_id'] == $data['id']) {
                                echo '<img class="checkout-img"  width="100%" src="data:image/png;base64,' . base64_encode($data['image']) . '" />';
                            }
                        } ?>

                <?php
                        $query = 'SELECT * FROM mens ';
                        $dataFromDB = mysqli_query($db, $query);
                        while ($data = mysqli_fetch_assoc($dataFromDB)) {
                            // check if the id of item is same as the id in mens table
                            if ($values['item_id'] == $data['id']) {
                                echo '<img class="checkout-img"  width="100%" src="data:image/png;base64,' . base64_encode($data['image']) . '" />';
                            }
                        } ?>
            </div>

            <!-- creates the product name column -->
            <div class="description"><?php echo $values["item_name"]; ?></div>
            <!-- creates the product quantity column -->
            <div class="quantity"><?php echo $values["item_quantity"]; ?></div>
            <!-- creates the product price column -->
            <div class="price">$<?php echo $values["item_price"]; ?></div>
            <!-- creates the product remove column -->
            <div class="remove">
                <a href="session.php?action=delete&id=<?php echo $values['item_id']; ?>">
                    <span style="font-size:25px">&#10005;</span>
                </a>
            </div>
        </div>
        <?php
                $total = $total + (1 * $values["item_price"]);
                //end foreach loop
            }

            ?>
        <div class="total-container">
            Total $<span id='total-price'>
                <?php
                if ($total > 0) {
                    echo $total;
                } else {
                    echo 0;
                }
            } //end if 
                ?></span>
            <div class="cod">
                <button onclick="hello()" class="cod-btn">
                    PAY ON DELIVERY
                </button>
            </div>
            <div id="paypal-button-container"></div>
        </div>
    </div>




    <script src="./JS/index.js"></script>
    <script>
    const popup = document.querySelector('.popup-container');
    const total = document.querySelector('#total-price');
    const codBtn = document.querySelector('.cod-btn');
    if (total == null) {
        codBtn.style = 'display:none'
    }

    function hello() {
        popup.style = 'display:flex';
    }

    function remove() {
        popup.style = 'display:none'
    }
    </script>

</body>

</html>