<?php

require_once 'config.php';
error_reporting(0);

// Get all values from the request
$email = $_POST["email"];
$password = $_POST["password"];
$answer = $_POST["answer"];

$sql = "SELECT email from user where email= '".$email."'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

// If user account already exists in DB
if ($row != null) {
    echo json_encode("exists");
} else {
    $authToken = generate_string(); 
    $password = md5($password);
    $sql = $conn->prepare("INSERT INTO user (email, password, sessionToken, answer) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $email, $password, $authToken, $answer);
    $result = $sql->execute();

    if ($result) {
        $output = array("authToken" => $authToken);
        echo json_encode($output);
    }
    else {
        echo json_encode("fail");
        //echo  $conn->error;
    }
}

$conn->close();