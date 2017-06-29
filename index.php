<?php
require_once("database.php");
//вызов загрузки ьаблицы по указанному месяц
if (isset($_GET['month'])) {
    $month = $_GET['month'];
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $month)) {
        fill_from_file();
        echo json_encode(get_table($month));
    }
    unset($_GET['month']);
}
//подгрузка професии
if (isset($_GET['prof'])) {
    echo json_encode(get_prof_data());
    unset($_GET['prof']);
}
//добавляем нового сотрдуника
if (isset($_GET['new_assoc'])) {
    echo new_assoc($_GET['new_assoc']);
    unset($_GET['new_assoc']);
}
//выписуем премию
if (isset($_GET['prem_bonus'])) {
    echo prem_bonus($_GET['prem_bonus']);
    unset($_GET['prem_bonus']);
}

?>