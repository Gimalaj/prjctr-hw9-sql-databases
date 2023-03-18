<?php

$host = 'mysql';
$user = 'root';
$pass = 'qazSedcS123';
$dbname = 'prjctr';

// Array of first names
$firstNames = ['John', 'Mary', 'David', 'Jennifer', 'Michael', 'Sarah', 'Robert', 'Elizabeth', 'William', 'Jessica', 'Sofia', 'Candy', 'Ronald', 'Andy', 'Bill'];

// Array of last names
$lastNames = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor', 'Cooper', 'Pitt'];

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, '3306');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    echo "Connection success \n";
}

if (isset($_GET["current_users"])) {
    $result = $conn->query("SELECT COUNT(*) FROM users");
    $numRows = $result->fetch_row()[0];
    echo "Total users $numRows \n";
}

// Select all users with random birth year. Year should be in range from 1900 to 2022
if (isset($_GET["rand_year"])) {
    $rand_year = $_GET["rand_year"];
    $start_time = microtime(true);
    $result = $conn->query("SELECT * FROM users WHERE YEAR(birthday) = FLOOR(RAND() * (2023 - 1900)) + 1900;");
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    echo "\n Here is execution time of select users $execution_time that were born in random year";
}

// Select all users that were born in a specific range of years
if (isset($_GET["range"])) {
    $range = $_GET["range"];
    $start_time = microtime(true);
    $result = $conn->query("SELECT * FROM users WHERE YEAR(birthday) BETWEEN " . $range . ";");
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    echo "\n Here is execution time of select users $execution_time born in a specific range of years";
}

// Select all users that were born in a random month
if (isset($_GET["rand_month"])) {
    $rand_month = $_GET["rand_month"];
    $start_time = microtime(true);
    $result = $conn->query("SELECT * FROM users WHERE MONTH(birthday) = FLOOR(RAND() * 12) + 1;");
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    echo "\n Here is execution time of select users $execution_time born in a random month";
}

 if (isset($_GET["hash"])) {
        mysqli_query($conn, "SET GLOBAL `innodb_adaptive_hash_index` = ".$_GET["hash"]);
        exit;
    }

if (isset($_GET["insert"])) {
        mysqli_query($conn, "SET GLOBAL `innodb_flush_log_at_trx_commit` = ".$_GET["insert"]);
        $time_script = microtime(true);
        for($i = 1; $i <= 10000 ; $i++) {
            // Generate random name
            $firstName = $firstNames[rand(0, count($firstNames) - 1)];
            $lastName = $lastNames[rand(0, count($lastNames) - 1)];
            $name = $firstName . ' ' . $lastName;

            // Generate random birthday between January 1, 1900, and December 31, 2022
            $start = strtotime('1900-01-01');
            $end = strtotime('2022-12-31');
            $randomDate = date('Y-m-d', rand($start, $end));

            $values = "('$name','$randomDate')";

            mysqli_query($conn,"INSERT INTO users (name,birthday) VALUES ".$values);

        }
        $result = (microtime(true) - $time_script) / 10000;

        echo "avg insert time ".$result."<br>";
        exit;
    }
?>