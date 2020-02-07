<?php

//DB details
$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName     = 'shop';

//Create connection and select DB
$db = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
if (!$db) {
    die("Connection failed: ");
}