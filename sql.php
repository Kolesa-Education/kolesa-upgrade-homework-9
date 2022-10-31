<?php
$dbhost='localhost';
$dbuser ='root';
$dbpassword ='root';
$dbdatabase= 'adverts';
$dbport = 8888 ;


$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase, $dbport);
// $connection = new mysqli($dbhost, $dbuser, $dbpassword, $dbdatabase, $dbport);


if (!$link) {
    die('could not connect: ' . mysql_error());
}

$db_selected = mysqli_select_db($dbdatabase, $connection);

if(!db_selected) {
    die('cant use ' . $dbdatabase . ':' . mysql_error());
}

echo ' connected';

// if ($mysqli->connect_error) {
//     echo 'Errno: '.$mysqli->connect_errno;
//     echo '<br>';
//     echo 'Error: '.$mysqli->connect_error;
//     exit();
//   }

//   echo 'Success: A proper connection to MySQL was made.';
//   echo '<br>';
//   echo 'Host information: '.$mysqli->host_info;
//   echo '<br>';
//   echo 'Protocol version: '.$mysqli->protocol_version;

//   $mysqli->close();
//x