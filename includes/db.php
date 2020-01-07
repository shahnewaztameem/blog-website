<?php
    
    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_password'] = "";
    $db['db_name'] = "cms";
    
    foreach($db as $key => $value){
        define(strtoupper($key),$value,false);
    }
    $connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    
	$query = "SET NAMES utf8";
	mysqli_query($connection,$query);
?>