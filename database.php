<?php
define('local_host', 'localhost');
define('us_er', 'root');
define('pass_word', '');

function db_create_db()
{
    $link_db = db_connect('');
    mysqli_query($link_db, "CREATE DATABASE WINE") or die(mysqli_error($link_db));
    mysqli_close($link_db);
    return true;
}

function db_connect($data_base)
{
    $link_db = mysqli_connect(local_host, us_er, pass_word, $data_base) or die("Ошибка " . mysqli_error($link_db));
    if (!mysqli_set_charset($link_db, "utf8"))
        die("Ошибка " . mysqli_error($link_db));
    return $link_db;
}

function fill_from_file()
{
    $link_db = db_connect('');
    if (!mysqli_select_db($link_db, 'WINE')) {
        db_create_db();
    } else return true;
    $prof_ar = array('Бухгалтер', 'Курьер', 'Менеджер');
    $link_db = db_connect('WINE');
    //create tables
    mysqli_query($link_db, "CREATE TABLE Professions (Prof_name CHAR(30), PRIMARY KEY(Prof_name))COLLATE='utf8_general_ci'");
    mysqli_query($link_db, "CREATE TABLE Workers (id INT AUTO_INCREMENT,Worker_Name CHAR(30),Worker_LastName CHAR(30),Worker_Prof CHAR(30),Salary INT,Avatar CHAR(30),  PRIMARY KEY(id))COLLATE='utf8_general_ci'");
    mysqli_query($link_db, "CREATE TABLE Payment (id_worker INT ,Salary INT,Bonus INT, Date_s DATE)COLLATE='utf8_general_ci'");
    //fill tables
    mysqli_query($link_db, "INSERT INTO Professions (Prof_name) VALUES ('$prof_ar[0]'),('$prof_ar[1]'),('$prof_ar[2]')");
    //data from file(names)
    $workers_data_ar = file('workers.txt');
    $id_inc = 1;
    foreach ($workers_data_ar as $workers_data) {
        $w_ar = explode(',', $workers_data);
        $ran_p = rand(0, 2);
        $ran_s = rand(10, 30) * 1000;
        $ava = '/css/images/' . $id_inc . '.jpg';
        mysqli_query($link_db, "INSERT INTO Workers (Worker_Name,Worker_LastName,Worker_Prof,Salary,Avatar) VALUES ('$w_ar[0]','$w_ar[1]','$prof_ar[$ran_p]','$ran_s','$ava')");
        //random payments for all - for 3 montths
        $bonus = 0;
        if (rand(0, 7) == 3) {
            $bonus = $ran_s / 10;
            $ran_s += $bonus;
        }
        mysqli_query($link_db, "INSERT INTO Payment (id_worker ,Salary ,Bonus , Date_s) VALUES ('$id_inc','$ran_s','$bonus','2017-06-01')");
        if (rand(0, 7) == 3) {
            $bonus = $ran_s / 10;
            $ran_s += $bonus;
        }
        mysqli_query($link_db, "INSERT INTO Payment (id_worker ,Salary ,Bonus , Date_s) VALUES ('$id_inc','$ran_s','$bonus','2017-05-01')");
        if (rand(0, 7) == 3) {
            $bonus = $ran_s / 10;
            $ran_s += $bonus;
        }
        mysqli_query($link_db, "INSERT INTO Payment (id_worker ,Salary ,Bonus , Date_s) VALUES ('$id_inc','$ran_s','$bonus','2017-07-01')");
        $id_inc++;
    }
    mysqli_close($link_db);
    return true;
}

function get_table($month)
{
    $link_db = db_connect('WINE');
    $query = "SELECT * FROM Workers INNER JOIN Payment ON Workers.id=Payment.id_worker WHERE Payment.Date_s='$month'";
    if ($res_quer = mysqli_query($link_db, $query)) {
        $temp_row = mysqli_num_rows($res_quer);
        while ($temp_row > 0) {
            $work_table_view[] = mysqli_fetch_assoc($res_quer);
            $temp_row--;
        }
        return $work_table_view;
    }
    return false;
}

function get_prof_data()
{
    $link_db = db_connect('WINE');
    $query = "SELECT Prof_name FROM Professions";
    $res_quer=mysqli_query($link_db,$query);
    $ar_prof = array();
    while ($row = mysqli_fetch_assoc($res_quer)) {
        $ar_prof[] = $row['Prof_name'];
    }
    return $ar_prof;
}
function clean($str)
{
    $str = trim($str);
    $str = stripslashes($str);
    $str = strip_tags($str);
    $str = htmlspecialchars($str);
    if ($str="") return false;
    return $str;
}
function new_assoc($new_assoc)
{
    $new_assoc_data=explode(',',$new_assoc);
    for ($i=0;$i++;$i<5)
        if (!clean($new_assoc_data[$i])) return false;
    $link_db = db_connect('WINE');
    $new_assoc_data[3]=intval($new_assoc_data[3]);
    $query = "INSERT INTO Workers (Worker_Name,Worker_LastName,Worker_Prof,Salary,Avatar) VALUES ('$new_assoc_data[0]','$new_assoc_data[1]','$new_assoc_data[2]','$new_assoc_data[3]','$new_assoc_data[4]')";
    if(mysqli_query($link_db,$query)) return true;
    return false;
}
?>

