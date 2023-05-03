<?php
include_once 'createTable.php';


function existsDb($host, $user, $passw, $port, $database) {
    $db = new mysqli($host, $user, $passw);
 
    if ($db->connect_error) {
        die("Ошибка подключения: " . $db->connect_error);
    }
    
    $sql = "SHOW DATABASES LIKE '".$database."'";
    $resultCheckedDb = $db->query($sql);

    if ($resultCheckedDb->num_rows > 0) {

           $conDb = connectionBase($host, $user, $passw, $database);
           return $conDb;
  
    } else {
        createBase($db, $database);
        $link = connectionBase($host, $user, $passw, $database);
        createTable($link);
    }
}

function connectionBase($host, $user, $passw, $database) {
    $base = new mysqli($host, $user, $passw, $database);
    return $base;
}

function createBase($db, $database) {
$queryCreateDb = "CREATE DATABASE IF NOT EXISTS $database";
$db->query($queryCreateDb);
}
?>
