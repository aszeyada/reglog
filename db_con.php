<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
static $connection;

if ( !isset($connection) ) {
    $config = parse_ini_file('config.ini');

    $connection = mysqli_connect($config['DB_SERVER'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_NAME']);
}


if (!$connection) {
    die("Failed to connect to the database. " . mysqli_connect_error());
}
