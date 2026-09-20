<?php

try{
    $server_name = "localhost";
    $dbname = "my";
    $dbuser = "root";
    $dbpassword = "";

    // Data source name
    $dsn = "mysql:host=$server_name;dbname=$dbname";
    $conn = new PDO($dsn,$dbuser,$dbpassword);

    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    // echo "Connection success";

}catch (PDOException $e){
    die("Connection Fail:".Se->getMessage());
}

?>