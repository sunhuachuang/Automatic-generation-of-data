<?php
session_start();

$table = $_GET['table'];
$number = (int) ($_GET['number']) ?: 1;
$values = $_POST['values'];

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

$format = [];
$format['param'] = [];
$format['fn'] = [];
$format['fields'] = array_keys($values);
$format['nulls'] = [];
foreach($values as $value) {
    array_push($format['param'], [$value['min'], $value['max']]);
    array_push($format['fn'], $value['fn']);
    array_push($format['nulls'], $value['nulls']);
}

$sql = "insert into " . $table . "(" . implode(',', $format['fields']) . ") values (" ;

$num = 0;//click times

$errors = [];
//insert
for($i = 0; $i < $number; $i++) {

    $value = [];
    foreach($format['fn'] as $key => $fn) {
        //nullable half happen
        if($format['nulls'][$key] === 'YES') {
            if(rand(0, 10) > 5){
                array_push($value, 'null');
                continue;
            }
        }

        if('getForeign' === $fn) {
            $foreign = getForeign([$mysqli, $table, $format['fields'][$key]]); //array
            if(!$foreign[0]) {
                $errors[] = 'table '.$foreign[1].' need create first, <a href="./insert.php?table='.$foreign[1].'">click to create</a>';
                continue;
            }
            array_push($value, $foreign[1]);
            continue;
        }
        array_push($value, $fn($format['param'][$key]) ?: '""');
    }
    $insertSql = $sql . implode(',', $value) . ")";
    echo $insertSql,'<br>';
    if($results = $mysqli->query($insertSql)) {
        $num += 1;
    }
}

$mysqli->close();
if($errors)
{
    print_r($errors);
}

echo $num, ' times ok','<a href="./action.php">click return index</a>';
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
    $end = $param[1];
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
        $time = date('Y-m-d', time());
        break;
    case 'datetime':
        $time = date('Y-m-d h:m:s', time());
        break;
    case 'timestamp':
        $time = date('ymdhms', time());
        break;
    case 'time':
        $time = date('h:m:s', time());
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

//get foreign key
//@param $mysqli, $table, $column
//@return null(need create) or value(not need create)
function getForeign($param)
{
    $mysqli = $param[0];
    $table  = $param[1];
    $column = $param[2];

    //show create table
    $query = "show create table ".$table;
    if(!$tableCreateResult = $mysqli->query($query)) {
        die('connect mysql failure--show create table:'.$query);
    }

    $resultQuery = [];
    while($row = mysqli_fetch_assoc($tableCreateResult)) {
        $resultQuery = $row;
    };
    $string = explode(') ENGINE', stristr($resultQuery['Create Table'], 'FOREIGN KEY'))[0];

    //it is not foreign, so return null
    if(!$string) {
        return [true, '""'];
    }

    $str = explode(',', explode("(`".$column."`) REFERENCES", $string)[1])[0];
    $foreign = explode("`", $str);
    $foreignTable = $foreign[1];
    $foreignColumn = $foreign[3];
    $foreignQuery = "select ".$foreignColumn." from ".$foreignTable;

    if(!$results = $mysqli->query($foreignQuery)) {
        die('connect mysql failure--select from foreign:'.$foreignQuery);
    }
    $values = [];
    while($row = mysqli_fetch_assoc($results)) {
        $values[] = $row[$foreignColumn];
    }
    if(!$values) {
        return [false, $foreignTable];
    }

    return [true, $values[array_rand($values)]];
}