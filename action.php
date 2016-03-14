<?php

$host = $_POST['host'] ?: 'localhost';
$database = $_POST['database'];
$name = $_POST['name'] ?: 'root';
$password = $_POST['password'];

$mysqli = new mysqli($host, $name, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

//all column
$columnsQuery = "SHOW COLUMNS FROM user";

if(!$results = $mysqli->query($columnsQuery)) {
    echo 'failure';exit;
}

$list = array();
while($rows = mysqli_fetch_assoc($results)){
    $list[] = $rows;
}

print_r($list);

$mysqli->close();
