<?php

$adminEmail = "admin@gmail.com";
$adminPass = "admin";
session_start();
if (isset($_POST['submit1'])) {
    include_once './db.php';
    //SIGN IN DATA
    $email = strtolower(mysqli_real_escape_string($db, $_REQUEST['email1']));
    $password = mysqli_real_escape_string($db, $_REQUEST['pwd1']);
    $query = "SELECT email,password FROM users WHERE email='$email'";
    $result = mysqli_query($db, $query);
    $userData = mysqli_fetch_assoc($result);
    // if the email and password are equals to admins email and password then it will set the session to admin and redirect to homepage if not then check if the users password is correct or not if correct then set session to user and it will redirect to homepage else send error code 1 which will execute on signinsignup page
    if ($email == $adminEmail && $password == $adminPass) {
        $_SESSION['admin'] = $adminEmail;
        header('location:../index.php');
    } else if ($userData) {
        if (password_verify($password, $userData['password'])) {
            $_SESSION['user'] = $userData['email'];
            header('location:../index.php');
        } else {
            header('location:../signInSignUp.php?error=1');
        }
    } else {
        header('location:../signInSignUp.php?error=1');
    }
}