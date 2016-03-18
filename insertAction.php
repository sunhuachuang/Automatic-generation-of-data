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
echo '<hr';


/***********************
 * function to create *
 ***********************/

//create name
//@param 0 =>column name, 1 => table name
function getName($param)
{
    $name  = $param[0];
    $table = $param[1];
    if($name == 'username' || $table == 'user' || $table == 'users') {
        $array = ['demo', 'user', 'vistor', 'guest', 'admin', 'Tom', 'Jack'];
        $preKey = array_rand($array);
        $preName = $array[$preKey];
        return '"' . $preName . mt_rand(0000, 9999) . '"';
    }

    if($name == 'name') {
        return '"' . $table . mt_rand(0000, 9999) . '"';
    }

    return '"' . $name . mt_rand(0000, 9999) . '"';
}

//create email
//@param 0=>min 1=>max default(2,10)
function getEmail($param)
{
    $min = max($param[0], 2) - 12; //except @example.com
    $max = min($param[1], 10);
    $string = 'abcdefghigklmnopqrstuvwxyz0123456789';
    return '"' . substr(str_shuffle($string), 0, mt_rand($min, $max)) . '@example.com"';
}

//create age
//@param 0=>min 1=>max default(1,150)
function getAge($param)
{
    $min = max($param[0], 1);
    $max = min($param[1], 150);
    return '"' . mt_rand($min, $max) . '"';
}

//create string
//@param $min int minlength, $max int maxlength
function getRandomString($param)
{
    $min = $param[0];
    $max = $param[1];
    $string = 'abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ';//can insert from outside
    return '"' . substr(str_shuffle($string), 0, mt_rand($min, $max)) . '"';
}

function getBoolean($param)
{
    return getRandomNumber([-0.9, 1.1]);
}

//create number
//@param array $start int, $end int
function getRandomNumber($param)
{
    $start = $param[0];
    $start = $param[1];
    return '"' . mt_rand($start, $end) . '"';
}

//create float
//@param array $start float, $end float, $d int
function getRandomFloat($param)
{
    $start = $param[0];
    $end   = $param[1];
    $d     = $param[2] ?: 2;
    $m = str_repeat(9, $d);
    return  '"' . mt_rand($start, $end).'.'.rand(0, $m) . '"';
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