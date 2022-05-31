<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
}elseif ($_SESSION["a_level"] != "admin" &&  $_SESSION["a_level"] != "system") {
  header("location:../index.php");
  exit();
}

$id = $_POST["id"];

$sql = "UPDATE tb_admin SET a_password = '".md5($_POST['a_password'])."' WHERE a_id = '".$id."'";
$query = mysqli_query($condb,$sql);

header("location:admin.php?update=pass");
exit();

mysqli_close($condb);
?>
