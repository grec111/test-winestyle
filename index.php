<?php
require_once("database.php");
fill_from_file();
$month=$_GET['month'];
echo json_encode(get_table($month));
//get_table('2017-05-01');
?>