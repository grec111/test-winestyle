<?php
define('local_host','localhost');
define('us_er','root');
define('pass_word','');

function db_create_db()
{
    $link_db=db_connect('');
    mysqli_query($link_db,"CREATE DATABASE WINE") or die(mysqli_error($link_db));
    mysqli_close($link_db);
    return true;
}
function db_connect($data_base){
    $link_db = mysqli_connect(local_host, us_er, pass_word ,$data_base) or die("Ошибка " . mysqli_error($link_db));
    if(!mysqli_set_charset($link_db,"utf8"))
        die("Ошибка " . mysqli_error($link_db));
    return $link_db;
}
?>