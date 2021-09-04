<?php

require_once 'config.php';
error_reporting(0);

$email = $_POST["email"];
$authToken =$_POST["authToken"];

// Check whether the user is authenticated
$sql = "SELECT * from users where email = '".$email."' and sessionToken = '".$authToken."'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

if ($row == null){
    echo json_encode("invalid");
} else {
    echo json_encode("success");
}