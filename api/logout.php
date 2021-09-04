<?php

require_once 'config.php';
error_reporting(0); 

$email = $_POST["email"];

// Remove the sesssionToken / AuthToken from DB
$sql = $conn->prepare("UPDATE users SET sessionToken = NULL WHERE email = ?");
$sql->bind_param("s", $email);
$result = $sql->execute(); 

$conn->close(); 

if ($result)
    echo json_encode('success') ;
else
    echo json_encode('fail') ;
