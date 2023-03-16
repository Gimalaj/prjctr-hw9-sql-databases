<?php

$host = 'mysql';
$user = 'root';
$pass = 'qazSedcS123';
$dbname = 'prjctr';

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, '3306');

// Array of first names
$firstNames = ['John', 'Mary', 'David', 'Jennifer', 'Michael', 'Sarah', 'Robert', 'Elizabeth', 'William', 'Jessica', 'Sofia', 'Candy', 'Ronald', 'Andy', 'Bill'];

// Array of last names
$lastNames = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor', 'Cooper', 'Pitt'];

// Get the current number of rows in the users table
$result = $conn->query("SELECT COUNT(*) FROM users");
$numRows = $result->fetch_row()[0];

// Loop to insert random users until there are 40 million users in the table
while ($numRows < 40000000) {

    // Generate random name
    $firstName = $firstNames[rand(0, count($firstNames) - 1)];
    $lastName = $lastNames[rand(0, count($lastNames) - 1)];
    $name = $firstName . ' ' . $lastName;

    // Generate random birthday between January 1, 1900, and December 31, 2022
    $start = strtotime('1900-01-01');
    $end = strtotime('2022-12-31');
    $randomDate = date('Y-m-d', rand($start, $end));

    // Insert user into the table
    $sql = "INSERT INTO users (name, birthday) VALUES ('$name', '$randomDate')";

    if ($conn->query($sql) === TRUE) {
        $numRows++;
        echo "User $numRows created successfully\n";
    } else {
        echo "Error creating user: " . $conn->error . "\n";
    }
}

echo "Done inserting users!";

?>