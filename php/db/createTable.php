<?php

function createTable($link) {

    $queryUsers = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `login` VARCHAR(50) NOT NULL,
        `email` VARCHAR(50) NOT NULL,
        `password` VARCHAR(255) NOT NULL
       ) ENGINE=InnoDB";
    $link->query($queryUsers);

    $queryUsersMore = "CREATE TABLE IF NOT EXISTS `users_more` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `id_user` INT(50) NOT NULL,
        `id_vk` INT(50) NOT NULL,
        `photo_vk` VARCHAR(255) NOT NULL,
        `first_name_vk` VARCHAR(255) NOT NULL,
        `last_name_vk` VARCHAR(255) NOT NULL,
        `country_vk` VARCHAR(255) NOT NULL,
        `city_vk` VARCHAR(255) NOT NULL,
        `private_profile_vk` TINYINT(1) NOT NULL,
        `see_profile_vk` TINYINT(1) NOT NULL
       ) ENGINE=InnoDB";
    $link->query($queryUsersMore);

}

?>