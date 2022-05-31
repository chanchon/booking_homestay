<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
}elseif ($_SESSION["a_level"] != "admin" &&  $_SESSION["a_level"] != "system") {
  header("location:../index.php");
  exit();
}


$id = $_GET["id"];
$sql = "DELETE FROM tb_booking WHERE b_id = '".$id."' ";
$query = mysqli_query($condb,$sql);

if (mysqli_affected_rows($condb)) {
  header("location:index.php?delete=pass");
  exit();
}
?>

