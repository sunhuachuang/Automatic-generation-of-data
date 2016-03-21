<?php
session_start();

$table = $_GET['table'];
$number = (int) ($_GET['number']) ?: 1;

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

//column
$columnsQuery = "SHOW COLUMNS FROM ".$table;

if(!$results = $mysqli->query($columnsQuery)) {
    die('failure:'.$columnsQuery);
}

/* row example
    [Field] => id
    [Type] => int(11)
    [Null] => NO
    [Key] => PRI & MUL
    [Default] =>
    [Extra] => auto_increment
 */
$list = [
    'fields' => [],
    'types'  => [],
    'nulls'  => [],
    'keys'   => [],
    'defaults' => [],
];
while($row = mysqli_fetch_assoc($results)){
    if ($row['Extra'] == 'auto_increment') {
        continue;
    }
    array_push($list['fields'],   $row['Field']);
    array_push($list['types'],    $row['Type']);
    array_push($list['nulls'],    $row['Null']);
    array_push($list['keys'],     $row['Key']);
    array_push($list['defaults'], $row['Default']);
}

$format = format($table, $list);

$values = array_merge($list, $format);
$columnNumber = count($values['fields']);

include './view/insert.html.php';

//@param $list array
//@return $f ['fields'=>[], 'fn'=>[]]
function format($table, $list)
{
    $f = [];
    $f['fields'] = $list['fields'];
    $f['fn'] = [];
    $f['param'] = [];

    foreach($list['types'] as $key => $type) {
        //MUL
        if($list['keys'][$key] === 'MUL') {
            array_push($f['fn'], 'getForeign');
            array_push($f['param'], [null, null]);
            continue;
        }

        $tmp = explode('(', $type);
        $t = $tmp[0];
        $l = substr($tmp[1], 0, -1);
        switch ($t)
        {
        case 'int':
            if(stristr($f['fields'][$key], 'age')) {
                array_push($f['fn'], 'getAge');
                array_push($f['param'], [1, 150]);
                break;
            }

            $min = $l == 11 ? 0 : -2147483648;//11 maybe mean > 0
            $max = 2147483647;
            array_push($f['fn'], 'getRandomNumber');
            $start = max('-'.str_repeat(9, $l), $min);
            $end   = min(str_repeat(9, $l), $max);
            array_push($f['param'], [$start, $end]);
            break;

        case 'smallint':
            if(stristr($f['fields'][$key], 'age')) {
                array_push($f['fn'], 'getAge');
                array_push($f['param'], [1, 150]);
                break;
            }
            $min = -32768;
            $max = 32767;
            array_push($f['fn'], 'getRandomNumber');
            $start = max('-'.str_repeat(9, $l), $min);
            $end   = min(str_repeat(9, $l), $max);
            array_push($f['param'], [$start, $end]);
            break;

        case 'tinyint':
            $v = $f['fields'][$key];//boolean
            if($l ==1 || stristr($v, 'flag') || stristr($v, 'is') || stristr($v, 'or') || stristr($v, 'bool')) {
                array_push($f['fn'], 'getBoolean');
                array_push($f['param'], [0, 1]);
                break;
            }
            if(stristr($f['fields'][$key], 'age')) {
                array_push($f['fn'], 'getAge');
                array_push($f['param'], [1, 150]);
                break;
            }
            $min = -128;
            $max = 127;
            array_push($f['fn'], 'getRandomNumber');
            $start = max('-'.str_repeat(9, $l), $min);
            $end   = min(str_repeat(9, $l), $max);
            array_push($f['param'], [$start, $end]);
            break;

        case 'mediumint':
            if(stristr($f['fields'], 'age')) {
                array_push($f['fn'], 'getAge');
                array_psuh($f['param'], [1, 150]);
                break;
            }
            $min = -8388608;
            $max = 8388607;
            array_push($f['fn'], 'getRandomNumber');
            $start = max('-'.str_repeat(9, $l), $min);
            $end   = min(str_repeat(9, $l), $max);
            array_push($f['param'], [$start, $end]);
            break;

        case 'bigint':
            $min = -9223372036854775808;
            $max = 9223372036854775807;
            array_push($f['fn'], 'getRandomNumber');
            $start = max('-'.str_repeat(9, $l), $min);
            $end   = min(str_repeat(9, $l), $max);
            array_push($f['param'], [$start, $end]);
            break;

        case 'decimal':
        case 'double':
        case 'float':
            $d = explode(',', $l);// like 3,2(999.99)
            array_push($f['fn'], 'getRandomFloat');
            $start = 0;
            $end = $d[0] ? str_repeat(9, $d[0] - $d[1]) : 99999999;//default (10, 2)

            array_push($f['param'], [$start, $end, $d[1]]);
            break;

        case 'char':
        case 'varchar':
            if(stristr($f['fields'][$key], 'name')) {
                array_push($f['fn'], 'getName');
                array_push($f['param'], [$f['fields'][$key], $table]);
                break;
            }

            if(stristr($f['fields'][$key], 'email')) {
                array_push($f['fn'], 'getEmail');
                array_push($f['param'], [1, $l]);
                break;
            }

            array_push($f['fn'], 'getRandomString');
            array_push($f['param'], [1, $l]);
            break;

        case 'tinytext':
            if(stristr($f['fields'][$key], 'name')) {
                array_push($f['fn'], 'getName');
                array_push($f['param'], [$f['fields'][$key], $table]);
                break;
            }

            if(stristr($f['fields'][$key], 'email')) {
                array_push($f['fn'], 'getEmail');
                array_push($f['param'], [1, $l]);
                break;
            }

            array_push($f['fn'], 'getRandomString');
            array_push($f['param'], [1, 255]);
            break;

        case 'text':
        case 'blob':
            array_push($f['fn'], 'getRandomString');
            array_push($f['param'], [1, 65535]);
            break;

        case 'mediumtext':
        case 'mediumblob':
            array_push($f['fn'], 'getRandomString');
            array_push($f['param'], [1, 16777215]);
            break;

        case 'longtext':
        case 'longblob':
            array_push($f['fn'], 'getRandomString');
            array_push($f['param'], [1, 4294967295]);
            break;

        case 'date':
        case 'datetime':
        case 'timestamp':
        case 'time':
            array_push($f['fn'], 'getRandomTime');
            array_push($f['param'], [$t]);
            break;

        case 'enum':
        case 'set':
            array_push($f['fn'], 'getRandomEnum');
            array_push($f['param'], [$l]);
            break;
        }
    }

    return $f;
}
