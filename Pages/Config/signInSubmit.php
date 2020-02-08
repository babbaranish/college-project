<?php
session_start();
if (isset($_POST['submit1'])) {
    include_once './db.php';
    //SIGN IN DATA
    $email = strtolower(mysqli_real_escape_string($db, $_REQUEST['email1']));
    $password = mysqli_real_escape_string($db, $_REQUEST['pwd1']);
    $query = "SELECT email,password FROM users WHERE email='$email'";
    $result = mysqli_query($db, $query);
    $userData = mysqli_fetch_assoc($result);
    if ($userData) {
        if (password_verify($password, $userData['password'])) {
            $_SESSION['user'] = $userData['email'];
            header('location:../../index.php');
        }
    } else {
        header('location:../signInSignUp.php?error=1');
        echo $userData['password'];
    }
}