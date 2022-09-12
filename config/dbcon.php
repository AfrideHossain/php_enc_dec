<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "php_enc_db";
try {
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    echo "<script> console.log('Database connected'); </script>";
} catch (Exception $e) {
    echo "<script> console.error('An error occured while connecting to the database.'); </script>";
    exit();
}
