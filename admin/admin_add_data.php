<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
} elseif ($_SESSION["a_level"] != "admin" &&  $_SESSION["a_level"] != "system") {
  header("location:../index.php");
  exit();
}






$allowed =  array('png', 'PNG', 'jpg', 'jpeg');
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
/*if (!in_array($ext, $allowed)) {
  echo '<script type="text/javascript" language="javascript">
        alert("นามสกุลไฟล์ไม่ถูกต้อง กรุณาอัพโหลดไฟล์ตามนามสกุล .png .PNG .jpg . jpeg ");
        window.history.back()
        </script>';
  exit();
}*/
$sql = "INSERT INTO tb_admin (a_username, a_password, a_name, a_surname, a_sex, a_phone, a_home, image, line_group, a_level) VALUES ('" . $_POST["a_username"] . "','" . md5($_POST["a_password"]) . "','" . $_POST["a_name"] . "','" . $_POST["a_surname"] . "','" . $_POST["a_sex"] . "','" . $_POST["a_level"] . "','" . $_POST["a_phone"] . "','" . $_POST["image"] . "','" . $_POST["line_group"] . "','" . $_POST["a_level"] . "')";
$query = mysqli_query($condb, $sql);
$nameim = $row['maxid'] + 1;
$path = "";
if ($_FILES['file']) {
  $file = $_FILES['file'];
  $path = "../images/" . $nameim . "." . $ext;

  if (!move_uploaded_file($file['tmp_name'], $path)) {
    $path = "";
  }
}





header("location:admin.php?add=pass");
exit();

mysqli_close($condb);
