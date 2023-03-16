<?php

$host = 'mysql';
$user = 'root';
$pass = 'qazSedcS123';
$dbname = 'prjctr';

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, '3306');

// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//else {
//    echo "Connection success";
//}

$result = $conn->query("SELECT COUNT(*) FROM users");
$numRows = $result->fetch_row()[0];

//$limit = $conn->query("SELECT *FROM users LIMIT 10");

//echo "First 10 users $limit \n";

echo "Total users $numRows \n";

?>