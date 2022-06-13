<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
} elseif ($_SESSION["a_level"] != "system") {
  header("location:../index.php");
  exit();
}


$allowed =  array('png', 'PNG', 'jpg', 'jpeg');
$ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

if (!in_array($ext, $allowed)) {
  echo '<script type="text/javascript" language="javascript">
							alert("นามสกุลไฟล์ไม่ถูกต้อง กรุณาอัพโหลดไฟล์ตามนามสกุล .png .PNG .jpg . jpeg ");
							window.history.back()
							</script>';
  exit();
}

$query3 = "SELECT MAX(`a_id`)as maxid FROM `tb_admin` WHERE 1";
$result3 = mysqli_query($condb, $query3);
$row3 = mysqli_fetch_array($result3);
$namim = $row3['maxid'] + 1;
$path = "";
if ($_FILES['upload']) {
  $file = $_FILES['upload'];
  $path = "images/" . $namim . '.' . $ext;

  if (!move_uploaded_file($file['tmp_name'], $path)) {
    $path = "";
  }
}

$sql = "INSERT INTO tb_admin (a_username, a_password, a_name, a_surname, a_sex, a_phone, a_home, image, line_token, a_level) 
VALUES ('" . $_POST["a_username"] . "','" . md5($_POST["a_password"]) . "','" . $_POST["a_name"] . "','" . $_POST["a_surname"] . "',
'" . $_POST["a_sex"] . "','" . $_POST["a_phone"] . "','" . $_POST["a_home"] . "',
'" . $path . "','" . $_POST["line_token"] . "','admin')";
//echo $sql;
$query = mysqli_query($condb, $sql);



header("location:admin.php?add=pass");
exit();
mysqli_close($condb);
?>