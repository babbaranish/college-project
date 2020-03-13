<?php
session_start();
if (isset($_POST['submit'])) {
    include_once './db.php';
    //SIGN UP DATA
    $name = mysqli_real_escape_string($db, $_REQUEST['name']); //Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
    $email = strtolower(mysqli_real_escape_string($db, $_REQUEST['email']));
    $password = mysqli_real_escape_string($db, $_REQUEST['pwd']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //Creates a password hash.
    $conPassword = mysqli_real_escape_string($db, $_REQUEST['conPwd']);
    $hashedConPassword = password_hash($conPassword, PASSWORD_DEFAULT); // Creates a conPassword hash.
    $DBemail = mysqli_query($db, "SELECT email FROM users WHERE email='$email' LIMIT 1");
    $EmailData = mysqli_fetch_assoc($DBemail);
    // if passwords don't matched then sends an error code 2 which will be executed on signinsignup page
    if ($password !== $conPassword) {
        header('location:../signInSignUp.php?error1=2');
    } else {  // check if the email is already saved in DB if saved then echo already exist and redirects the page to signinsignup 
        if ($EmailData) {
            if ($EmailData['email'] == $email) {
                header("location:../signInSignUp.php?email=0");
            }
        } else {  // if email doesn't exist then create new user in DB
            $query = "INSERT INTO users (name,email,password,confPassword) VALUES ('$name','$email','$hashedPassword','$hashedConPassword')";
            if (mysqli_query($db, $query)) {
                header("Location: ../signInSignUp.php?success=1");
            } else {
                echo 'ERROR IN SIGN UP PROCESS. REDIRECTING TO SIGN UP PAGE';
                header("refresh:3;url=../signInSignUp.php");
            }
        }
    }
}