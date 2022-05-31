<?php
require_once('connection/connect.php');


if ($_SESSION == NULL) {
  header("location:login.php");
  exit();
}

$check_submit = "";

$sql = "SELECT * FROM tb_admin WHERE a_username = '".$_SESSION['a_username']."'";
$query = mysqli_query($condb,$sql);
$result = mysqli_fetch_array($query);

if (isset($_GET['update'])) {
  if ($_GET['update'] == "pass") {
    $check_submit = '<div class="alert alert-success" role="alert">';
    $check_submit .= '<span><i class="bi bi-check2-circle"></i> บันทึกข้อมูลเรียบร้อยแล้ว</span>';
    $check_submit .= '</div>';
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
  
  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />    


</head>
<body class="default">
  <?php include ('includes/navbar.php');?>
  <div class="container-fluid">
    <div class="col-md-12 mt-4">
      <div class="row justify-content-md-center">
        <div class="col-md-auto"><?php echo $check_submit;?></div>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-5 mb-4">
        <div class="card border-dark mt-2">
          <h5 class="card-header"><i class="fa-solid fa-address-card"></i>  ข้อมูลส่วนตัวของฉัน</h5>
          <div class="card-body">
            <h5 class="card-text">ชื่อผู้ใช้ : <span class="badge bg-secondary"><?php echo $result[1 ]; ?></span></h5>
            <h5 class="card-text">ชื่อ - นามสกุล : <span class="badge bg-secondary"><?php echo $result[3].' '.$result[4]; ?></span></h5>
            <h5 class="card-text">เพศ : <span class="badge bg-secondary"><?php echo $result[5]; ?></span></h5>
            <h5 class="card-text">เบอร์โทรศัพท์ : <span class="badge bg-secondary"><?php echo $result[6]; ?></span></h5>
            <h5 class="card-text">ระดับผู้ใช้ : <span class="badge bg-secondary"><?php if ($result[10] == "member") {echo "สมาชิก";}elseif($result[10] == "admin"){echo "แอดมิน";}else{echo "ผู้ดูแลระบบ";} ?></span></h5>
            <div class="mt-3">
              <a href="profile_edit.php" class="btn btn-success">แก้ไขข้อมูล <i class="fas fa-user-edit"></i></a>
              <a href="change_password.php" class="btn btn-warning">เปลี่ยนรหัสผ่าน <i class="fas fa-key"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <?php mysqli_close($condb);?>
</body>
</html>
