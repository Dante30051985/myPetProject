<?php

function createTable($link) {

    $queryUsers = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `login` VARCHAR(50) NOT NULL,
        `email` VARCHAR(50) NOT NULL,
        `password` VARCHAR(255) NOT NULL
       ) ENGINE=InnoDB";
    $link->query($queryUsers);

}

?>