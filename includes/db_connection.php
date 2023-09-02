<?php

$host = "tz1ak";
$username = "root";
$password = "";
$dbname = "library1";


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка соединения с базой данных: " . $conn->connect_error);
}
