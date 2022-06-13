<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
    header("location:../login.php");
    exit();
  } elseif ($_SESSION["a_level"] != "admin") {
    header("location:../index.php");
    exit();
  }


  $sql = "INSERT INTO tb_package (package_name, package_price) VALUES ('" . $_POST["package_name"] . "','". $_POST["package_price"]."')";
  $query = mysqli_query($condb, $sql);


header("location:index.php?add=pass");
exit();
mysqli_close($condb);
?>  