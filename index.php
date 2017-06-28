<?php
require_once("database.php");
fill_from_file();

if (isset($_GET['month'])) {
    $month=$_GET['month'];
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$month))
    {
        echo json_encode(get_table($month));
        //   unset($_GET['month']);
    }
}



//$_GET['prof']="yes";
if (isset($_GET['prof']))
{
    echo json_encode(get_prof_data());
//    unset($_GET['prof']);

}
?>