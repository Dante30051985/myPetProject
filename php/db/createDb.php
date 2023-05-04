<?php
include_once 'createTable.php';


function existsDb($host, $user, $passw, $database) {
    $db = new mysqli($host, $user, $passw, $database);
 
    if ($db->connect_error) {
        die("Ошибка подwwключения: " . $db->connect_error);
    }
    
    $sql = "SHOW DATABASES LIKE '".$database."'";
    $resultCheckedDb = $db->query($sql);

    if ($resultCheckedDb->num_rows > 0) {

        $sql = "SHOW TABLES from '".$database."' ";
        $resultCheckedTable = $db->query($sql);

        if ($resultCheckedTable == null) {

            $link = connectionBase($host, $user, $passw, $database);
            createTable($link); 
            return $link;
        }
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
