<?php
require_once('connection/connect.php');


$check_submit = "";
$a_username = "";

if (isset($_POST["submit"])) {
  $sql = "SELECT * FROM tb_admin WHERE a_username = '" . mysqli_real_escape_string($condb, $_POST['a_username']) . "' and a_password = '" . mysqli_real_escape_string($condb, md5($_POST['a_password'])) . "'";
  $query = mysqli_query($condb, $sql);
  $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

  if (!$result) {
    $a_username = $_POST['a_username'];
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="bi bi-info-circle"></i> ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบใหม่อีกครั้ง</span>';
    $check_submit .= '</div>';
  } else {
    $_SESSION["a_username"] = $result["a_username"];
    $_SESSION["a_level"] = $result["a_level"];
    $_SESSION["a_home"] = $result["a_home"];

    if ($_SESSION["a_level"] == 'member') {
      header("location:index.php");
      exit();
    }else if ($_SESSION["a_level"] == 'admin') {
      header("location:admin/index.php");
      exit();
    }else{
      header("location:admin/booking_report.php");
      exit();
    }

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
    <div class="row justify-content-md-center ">
      <div class="col-md-5 mb-4 " >
        <div class="card  mt-2 shadow p-3 mb-5 bg-white rounded">
          <h2 class="row justify-content-md-center">Log In</h2>
          <div class="card-body">
            <div class="row justify-content-md-center mb-2">
              <div class="col col-lg-6">
                <img src="images/login.png" style="width: 100%;">
              </div>
            </div>
            <form method="post">
              <div class="mb-3">
                <label class="form-label">ชื่อผู้ใช้</label>
                <input type="text" class="form-control border border-secondary" name="a_username"  value="<?php echo $a_username; ?>"placeholder="ระบุชื่อผู้ใช้" required />
              </div>
              <div class="mb-3 ">
                <label class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control border border-secondary" name="a_password" placeholder="ระบุรหัสผ่าน " required />
              </div>
              <button type="submit" class="btn btn-primary mx-auto d-block" name="submit">เข้าสู่ระบบ</button>
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
<?php
