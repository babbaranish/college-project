<?php
session_start();
if (isset($_SESSION['user'])) {
    header('location: ../index.php');
}
if (isset($_GET['success'])) {
    echo "<script> alert('SUCCESSFULLY SIGN UP ');</script>";
}
?>
<html>

<head>
    <title>Sign in sign up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icon.ico">
    <link rel="stylesheet" href="./CSS/styles.css" />
</head>

<body>
    <!--NAV-BAR-->
    <?php include_once('navbar.php') ?>


    <section class="sign-in-sign-up">
        <div class="sign-in">
            <h2>I already have an account</h2>
            <span>Sign in with your email and password</span>
            <?php
            if (isset($_GET['error'])) {
                echo '<span style="color:red;margin-top:10px;font-weight:bold;">ENTER CORRECT EMAIL AND PASSWORD</span>';
            } else {
                echo "";
            }
            ?>
            <form action="./Config/signInSubmit.php" method="POST" name="form1">
                <div class="input-container">
                    <input id="email" class="input" type="email" name="email1" required>
                    <label class="email-label label">E-mail</label>
                </div>
                <div class="input-container">
                    <input id="password" class="input" type="password" type="password" name="pwd1" required>
                    <label class="password-label label">Password</label>
                </div>
                <div class="button-container">
                    <button type="submit" class="sign-in-button" name="submit1">SIGN IN</button>
                </div>
            </form>
        </div>

        <div class="sign-up">
            <h2>I do not have a account</h2>
            <span>Sign up with your email and password</span>
            <?php
            if (isset($_GET['error1'])) {
                echo '<span style="color:red;margin-bottom:-30px;font-weight:bold;">PASSWORD NOT MATCHED</span>';
            } else {
                echo "";
            }
            ?>
            <form action="./Config/signUpSubmit.php" method="POST" name="form2">
                <div class="input-container">
                    <input id="name" class="input" type="text" name="name" required>
                    <label class="name-label label">Full Name</label>
                </div>
                <div class="input-container">
                    <input id="sign-up-email" class="input" type="email" name="email" required>
                    <label class="sign-up-email-label label">E-mail</label>
                </div>
                <div class="input-container">
                    <input id="sign-up-password" class="input" type="password" name="pwd" required>
                    <label class="sign-up-password-label label">Password</label>
                </div>
                <div class="input-container">
                    <input id="conf-password" class="input" type="password" name="conPwd" required>
                    <label class="conf-password-label label">Confirm Password</label>
                </div>
                <div class="button-container">
                    <button type="submit" class="sign-in-button" name="submit">SIGN UP</button>
                </div>
            </form>

        </div>
    </section>
    <script src="./JS/click.js"></script>
    <script src="./JS/index.js"></script>
    <script>
    const pass1 = document.querySelector('#sign-up-password');
    const pass = document.querySelector('#conf-password');
    pass.addEventListener('focusout', function() {
        if (pass1.value !== pass.value) {
            alert("PASSWORD NOT SAME")
        }
    });
    </script>
    <script src="./JS/storage.js"></script>

</body>

</html>