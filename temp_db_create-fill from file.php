<?php
require_once("database.php");

function fill_from_file()
{
    $link_db=db_connect('');
    if(!mysqli_select_db($link_db,'WINE')) db_create_db();
    $prof_ar=array('Бухгалтер','Курьер','Менеджер');
    $link_db=db_connect('WINE');
//    mysqli_query($link_db,"CREATE TABLE Professions (Prof_name CHAR(30), PRIMARY KEY(Prof_name))") or die(mysqli_error($link_db));
//   mysqli_query($link_db,"INSERT INTO Professions (Prof_name) VALUES ('$prof_ar[0]'),('$prof_ar[1]'),('$prof_ar[2]')") or die(mysqli_error($link_db));
//    mysqli_query($link_db,"CREATE TABLE Workers (id INT AUTO_INCREMENT,Worker_Name CHAR(30),Worker_LastName CHAR(30),Worker_Prof CHAR(30),Salary INT,Avatar CHAR(255),  PRIMARY KEY(id))") or die(mysqli_error($link_db));
    //считка с файла
    $workers_data_ar = file('workers.txt');
    foreach ($workers_data_ar as $workers_data)
    {
        $w_ar=explode(',',$workers_data);
        $ran_p=rand(0,2);
        $ran_s=rand(10000,30000);
        mysqli_query($link_db,"INSERT INTO Workers (Worker_Name,Worker_LastName,Worker_Prof,Salary) VALUES ('$w_ar[0]','$w_ar[1]','$prof_ar[$ran_p]','$ran_s')");
        //check avatars
    }

    mysqli_query($link_db,"CREATE TABLE Payment (id_worker INT ,Salary INT, Date_s DATE, PRIMARY KEY(id_worker))") or die(mysqli_error($link_db));
    //inserts с рандомом даты(в теч 3х месяцев)+рандом зп
    mysqli_close($link_db);


}
fill_from_file();
?>