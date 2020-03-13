<?php
session_start();
include_once('Config/db.php');
if (!isset($_SESSION['user'])) {
    header('location:./signInSignUp.php');
}
$email = $_SESSION['user'];
$query = "SELECT * FROM users where email='$email'";
$userData = mysqli_query($db, $query);
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
    <?php
    if (isset($_GET['error'])) {
        echo "<script> alert('There is issue placing your order, Please try again.');</script>";
    }
    ?>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>
    <!-- Checkout Form popup -->
    <div class="popup-container">
        <div class="form-container">
            <form method="post" action="./Config/order.php">
                <?php
                if (isset($_GET['form'])) {
                    echo '<span style="color:red;margin-bottom:10px;font-weight:bold;">FILL ALL THE DATAILS</span>';
                }
                ?>

                <?php
                while ($data = mysqli_fetch_assoc($userData)) {

                ?>
                <div class="input-container">
                    <label for="name">Name</label>
                    <input type="text" name='name' value="<?php echo $data['name'] ?>" required>
                </div>
                <div class="input-container">
                    <label for="mobile">Mobile</label>
                    <input type="text" name='mobile' value="<?php echo $data['mobile'] ?>"
                        title="Enter minimum 10 digits" pattern="[6-9]+[0-9]{9,}" maxlength="10" required>
                </div>
                <div class="input-container">
                    <label for="city">City</label>&nbsp;&nbsp;
                    <input type="text" name='city' value="<?php echo $data['city'] ?>" required>
                </div>
                <div class="input-container">
                    <label for="pincode">Pincode</label>
                    <input type="text" name='pincode' maxlength="6" value="<?php echo $data['pincode'] ?>"
                        pattern="[0-9]{6,}" required>
                </div>
                <div class="input-container">
                    <label for="address">Address</label>
                    <input type="text" name='address' rows="3" value="<?php echo $data['address'] ?>" required>
                </div>
                <div class="input-container">
                    <button class="checkout-submit" type="submit" name='submit'>PLACE ORDER</button>
                </div>
                <?php
                }
                ?>
            </form>
        </div>

    </div>
</body>

</html>