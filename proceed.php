<?php
session_start();
require_once "config.php";
$id = $_SESSION['id'];


    $sql = "UPDATE users SET proceed = 1  WHERE id=$id";
    // Prepare statement
    $stmt = $link->prepare($sql);
    // execute the query
    $stmt->execute();

    
    header('location: play');


?>