<?php

error_reporting(0);

// $server = "localhost";
// $username = "id17493869_agridevs123";
// $password = "ihq4U4+cl_8fMA[_";
// $db = "id17493869_agridevs";

$server = "localhost";
$username = "root";
$password = "";
$db = "test";

$conn = new mysqli($server, $username, $password, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

// Function to generate random string
function generate_string($strength = 20) {
    $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}