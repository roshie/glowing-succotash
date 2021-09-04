<?php

require_once 'config.php';
error_reporting(0);

// Get all values from the request
$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT email from user where email= '".$email."'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

// If user account already exists in DB
if ($row == null) {
    echo json_encode("invalid");
} else {
    $password = md5($password);
    $sql = $conn->prepare("UPDATE user SET password = '".$password."' WHERE email = '".$email."'");
    $sql->bind_param("ssss", $email, $password, $authToken, $answer);
    $result = $sql->execute();

    if ($result) {
        echo json_encode("success");
    }
    else {
        echo json_encode("fail");
        //echo  $conn->error;
    }
}

$conn->close();