<?php

session_start();

//session
$host = $_SESSION['host'];
$database = $_SESSION['database'];
$name = $_SESSION['name'];
$password = $_SESSION['password'];

$mysqli = new mysqli($host, $name, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error.'<a href="./index.html">click</a> to return');
}

if(!$mysqli->set_charset("utf8")) {
    die('set utf8 failure <a href="./index.html">click</a> to return');
}
