<?php
require_once("database.php");
fill_from_file();
$month=$_GET['month'];
if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$month))
{
    echo json_encode(get_table($month));
}else{
    echo 'Error-Not Found-404-Fatality';
}

//get_table('2017-05-01');
?>