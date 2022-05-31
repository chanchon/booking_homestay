<?php
require_once('connection/connect.php');


if ($_SESSION == NULL) {
  header("location:login.php");
  exit();
}

$check_submit = "";

$sql = "SELECT a_id, a_password FROM tb_admin WHERE a_username = '" . $_SESSION['a_username'] . "'";
$query = mysqli_query($condb, $sql);
$result = mysqli_fetch_array($query);

if (isset($_POST['save'])) {
  if (md5($_POST['password_old']) != $result[1]) {
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="bi bi-info-circle"></i> รหัสผ่านเดิมไม่ถูกต้อง</span>';
    $check_submit .= '</div>';
  } elseif ($_POST['password_new'] != $_POST['confirm_password']) {
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="bi bi-info-circle"></i> รหัสผ่านใหม่ ไม่ต้องกับ ยืนยันรหัสผ่านใหม่</span>';
    $check_submit .= '</div>';
  } else {
    $sql_2 = "UPDATE tb_admin SET a_password = '" . md5($_POST["password_new"]) . "' WHERE a_username = '" . $_SESSION['a_username'] . "'";
    $query_2 = mysqli_query($condb, $sql_2);

    header("location:profile.php?update=pass");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="50x50" href="images/icon.png">

</head>

<body class="default">
  <?php include('includes/navbar.php'); ?>
  <div class="container-fluid">
    <div class="col-md-12 mt-4">
      <div class="row justify-content-md-center">
        <div class="col-md-auto"><?php echo $check_submit; ?></div>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-5 mb-4">
        <div class="card border-dark mt-2">
          <h5 class="card-header">เปลี่ยนรหัสผ่าน ID : <?php echo $result[0]; ?></h5>
          <div class="card-body">
            <div class="row justify-content-md-center mb-2">
              <div class="col col-lg-6">
                <img src="images/password.png" style="width: 100%;">
              </div>
            </div>
            <form method="post">
              <div class="mb-3">
                <label class="form-label">รหัสผ่านเดิม</label>
                <input type="password" class="form-control" name="password_old" required />
              </div>
              <div class="mb-3">
                <label class="form-label">รหัสผ่านใหม่</label>
                <input type="password" class="form-control" name="password_new" required />
              </div>
              <div class="mb-3">
                <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                <input type="password" class="form-control" name="confirm_password" required />
              </div>
              <div align="right">
                <button type="button" class="btn btn-secondary " onclick="window.location.href='profile.php'">ย้อนกลับ</button>
                <button type="submit" class="btn btn-primary " name="save">บันทึกข้อมูล</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <?php mysqli_close($condb); ?>
</body>

</html>