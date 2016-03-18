<?php

$host = $_POST['host'] ?: 'localhost';
$database = $_POST['database'] ?: false;
$name = $_POST['name'] ?: 'root';
$password = $_POST['password'] ?: false;

if(!$database || !$password) {
    die('no password or database');
}

session_start();

$mysqli = new mysqli($host, $name, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

//session
$_SESSION['host'] = $host;
$_SESSION['database'] = $database;
$_SESSION['name'] = $name;
$_SESSION['password'] = $password;

//$tableQuery = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE ". $database;
$tableQuery = "SHOW TABLES from ".$database;
if(!$results = $mysqli->query($tableQuery)) {
    die('failure');
}

$tables = [];
while($row = mysqli_fetch_assoc($results)){
    $tables[] = $row;
}

$name = 'Tables_in_'.$database;

$mysqli->close();
include './view/action.html.php';
