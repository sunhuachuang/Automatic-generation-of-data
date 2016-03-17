<?php
session_start();

$table = $_GET['table'];
$number = (int) ($_GET['number']);
$values = $_POST['values'];

//session
$host = $_SESSION['host'];
$database = $_SESSION['database'];
$name = $_SESSION['name'];
$password = $_SESSION['password'];

$mysqli = new mysqli($host, $name, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$format = [];
$format['param'] = [];
$format['fn'] = [];
$format['fields'] = array_keys($values);

foreach($values as $value) {
    array_push($format['param'], [$value['min'], $value['max']]);
    array_push($format['fn'], $value['fn']);
}

$sql = "insert into " . $table . "(" . implode(',', $format['fields']) . ") values (" ;

$num = 0;//click times

//insert
for($i = 0; $i < $number; $i++) {

    $value = [];
    foreach($format['fn'] as $key => $fn) {
        array_push($value, $fn($format['param'][$key]) ?: null);
    }
    $insertSql = $sql . implode(',', $value) . ")";
    echo $insertSql,'<br>';
    if($results = $mysqli->query($insertSql)) {
        $num += 1;
    }
}

$mysqli->close();

echo $num, ' times ok';

//create string
//@param $min int minlength, $max int maxlength
function getRandomString($param)
{
    $min = $param[0];
    $max = $param[1];
    $string = 'abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ';//can insert from outside
    return '"' . substr(str_shuffle($string), 0, rand($min, $max)) . '"';
}

//create number
//@param array $start int, $end int
function getRandomNumber($param)
{
    $start = $param[0];
    $start = $param[1];
    return '"' . rand($start, $end) . '"';
}

//create float
//@param array $start float, $end float, $d int
function getRandomFloat($param)
{
    $start = $param[0];
    $end   = $param[1];
    $d     = $param[2];
    $m = str_repeat(9, $d);
    return  '"' . rand($start, $end).'.'.rand(0, $m) . '"';
}

//create time
//@param array $type string
function getRandomTime($param)
{
    $type = $param[0];
    $time = '';
    switch($type)
    {
    case 'date':
        $time = date('yyyy-mm-dd', time());
        break;
    case 'datetime':
        $time = date('yyyy-mm-dd hh:mm:ss', time());
        break;
    case 'timestamp':
        $time = date('yyyymmddhhmmss', time());
        break;
    case 'time':
        $time = date('hh:mm:ss', time());
        break;
    }
    return '"' . $time . '"';
}

//create enum
//@param $choice array
function getRandomEnum($param)
{
    return '"' . $param[array_rand($param)] . '"';
}