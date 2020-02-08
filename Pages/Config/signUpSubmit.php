<?php
session_start();
if (isset($_POST['submit'])) {
    include_once './db.php';
    //SIGN UP DATA
    $name = mysqli_real_escape_string($db, $_REQUEST['name']);
    $email = strtolower(mysqli_real_escape_string($db, $_REQUEST['email']));
    $password = mysqli_real_escape_string($db, $_REQUEST['pwd']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $conPassword = mysqli_real_escape_string($db, $_REQUEST['conPwd']);
    $hashedConPassword = password_hash($conPassword, PASSWORD_DEFAULT);
    $DBemail = mysqli_query($db, "SELECT email FROM users WHERE email='$email' LIMIT 1");
    $EmailData = mysqli_fetch_assoc($DBemail);
    if ($password !== $conPassword) {
        header('location:../signInSignUp.php?error1=2');
    } else {
        if ($EmailData) {
            if ($EmailData['email'] == $email) {
                echo 'EMAIL ALREADY EXIST USE ANOTHER EMAIL. REDIRECTING TO SIGN UP PAGE';
                header("refresh:3;url=../signInSignUp.php");
            }
        } else {
            $query = "INSERT INTO users (name,email,password,confPassword) VALUES ('$name','$email','$hashedPassword','$$hashedConPassword')";
            if (mysqli_query($db, $query)) {
                header("Location: ../signInSignUp.php?success=1");
            } else {
                echo 'ERROR IN SIGN UP PROCESS. REDIRECTING TO SIGN UP PAGE';
                // header("refresh:3;url=../signInSignUp.php");
            }
        }
    }
}