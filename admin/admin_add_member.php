<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
} elseif ($_SESSION["a_level"] != "admin") {
  header("location:../index.php");
  exit();
}


$sql = "INSERT INTO tb_admin (a_username, a_password, a_name, a_surname, a_sex, a_phone, a_home, a_level) 
VALUES ('" . $_POST["a_username"] . "','" . md5($_POST["a_password"]) . "','" . $_POST["a_name"] . "','" . $_POST["a_surname"] . "',
'" . $_POST["a_sex"] . "','" . $_POST["a_phone"] . "','" . $_POST["a_home"] . "','" . $_POST["a_level"] . "')";
//echo $sql;
$query = mysqli_query($condb, $sql);



header("location:admin.php?add=pass");
exit();
mysqli_close($condb);
?>