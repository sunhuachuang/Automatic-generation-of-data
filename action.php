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

$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>auto data creater</title>
</head>
<body>
  <form action="./insert.php">
    table_name:  <input type="text" name="table" value="user"></br>
    number:   <input type="text" name="number" value="1"></br>
    <input type="submit" />
  </form>
</body>
</html>
