<?php

require_once 'config.php';
error_reporting(0);

$email = $_POST["email"];
$answer =$_POST["answer"];

// Check whether the user is authenticated
$sql = "SELECT * from user where email = '".$email."' and answer = '".$answer."'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

if ($row == null){
    echo json_encode("invalid");
} else {
    echo json_encode("success");
}