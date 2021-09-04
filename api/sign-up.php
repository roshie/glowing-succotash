<?php

require_once 'config.php';
error_reporting(0);

// Get all values from the request
$fullName = $_POST["fullName"];
$email = $_POST["email"];
$password = $_POST["password"];
$phone = $_POST["phone"];
$city = $_POST["city"];
$country = "India";

$sql = "SELECT email from users where email= '".$username."'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

// If user account already exists in DB
if ($row != null) {
    echo json_encode("exists");
} else {
    $authToken = generate_string(); 
    $password = md5($password);
    $sql = $conn->prepare("INSERT INTO users (email, fullName, password, sessionToken, phone, city, country) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssss", $email, $fullName, $password, $authToken, $phone, $city, $country);
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