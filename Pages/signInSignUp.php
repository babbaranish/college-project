<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign in sign up</title>
    <link rel="icon" href="../assets/icon.ico">
    <link rel="stylesheet" href="../CSS/styles.css" />
</head>

<body>
    <!--NAV-BAR-->
    <nav class="navbar">
        <a class="logo-container" href="../index.php">
            <img src="../assets/crown.svg" alt="shop_home icon" />
        </a>
        <ul class="links-container">
            <li class="links">
                <a href="./shopPage.php">SHOP</a>
            </li>
            <li class="links">
                <a href="#">SIGN IN</a>
            </li>
            <li class="cart-icon-container">
                <img class="cart-icon" src="../assets/cart.svg" alt="cart icon" />
                <span style="position: absolute;font-size: 10px;font-weight: bold;bottom: 7px;left: 10px;;">0</span>
            </li>
        </ul>
        <div class="cart-dropdown">
            <div class="cart-items"></div>
            <a href='./checkout.php'>
                <button class="cart-button">GO TO CHECKOUT</button>
            </a>
        </div>
    </nav>

    <section class="sign-in-sign-up">
        <div class="sign-in">
            <h2>I already have an account</h2>
            <span>Sign in with your email and password</span>
            <form action="">
                <div class="input-container">
                    <input id="email" class="input" type="email" required>
                    <label class="email-label label">E-mail</label>
                </div>
                <div class="input-container">
                    <input id="password" class="input" type="password" required>
                    <label class="password-label label">Password</label>
                </div>
                <div class="button-container">
                    <button type="submit" class="sign-in-button">SIGN IN</button>
                </div>
            </form>
        </div>

        <div class="sign-up">
            <h2>I do not have a account</h2>
            <span>Sign up with your email and password</span>
            <form action="">
                <div class="input-container">
                    <input id="name" class="input" type="text" required>
                    <label class="name-label label">Full Name</label>
                </div>
                <div class="input-container">
                    <input id="sign-up-email" class="input" type="email" required>
                    <label class="sign-up-email-label label">E-mail</label>
                </div>
                <div class="input-container">
                    <input id="sign-up-password" class="input" type="password" required>
                    <label class="sign-up-password-label label">Password</label>
                </div>
                <div class="input-container">
                    <input id="conf-password" class="input" type="password" required>
                    <label class="conf-password-label label">Confirm Password</label>
                </div>
                <div class="button-container">
                    <button type="submit" class="sign-in-button">SIGN UP</button>
                </div>
            </form>
        </div>
    </section>

    <script src="../JS/index.js"></script>

</body>

</html>