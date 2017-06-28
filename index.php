<?php
require_once("database.php");
//fill_from_file();
if (isset($_GET['month'])) {
    $month = $_GET['month'];
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $month)) {
        fill_from_file();
        echo json_encode(get_table($month));
    }
    unset($_GET['month']);
}
if (isset($_GET['prof'])) {
    echo json_encode(get_prof_data());
    unset($_GET['prof']);
}
//$_GET['new_assoc']='test,test1,Бухгалтер,10';
if (isset($_GET['new_assoc'])) {

    $name = $_FILES['photoimg']['name'];
    $size = $_FILES['photoimg']['size'];
    $tmp = $_FILES['photoimg']['tmp_name'];
    echo $tmp;
//    $path = "uploads/";
    move_uploaded_file($tmp, url_to_images); //Stores the image in the uploads folder


    echo new_assoc($_GET['new_assoc']);
    unset($_GET['new_assoc']);
}
//fill_from_file();
//prem_bonus
//$_GET['prem_bonus']='Менеджер,777';
if (isset($_GET['prem_bonus'])) {
    echo prem_bonus($_GET['prem_bonus']);
    unset($_GET['prem_bonus']);
}

?>