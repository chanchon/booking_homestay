<?php
require_once('connection/connect.php');


if ($_SESSION == NULL) {
  header("location:login.php");
  exit();
}

$sql = "SELECT * FROM tb_admin WHERE a_username = '" . $_SESSION['a_username'] . "'";
$query = mysqli_query($condb, $sql);
$result = mysqli_fetch_array($query);

if (isset($_POST["save"])) {
  $sql_2 = "UPDATE tb_admin SET a_name = '" . $_POST["a_name"] . "' , a_surname = '" . $_POST["a_surname"] . "' , a_sex = '" . $_POST["a_sex"] . "' , a_phone = '" . $_POST["a_phone"] . "' WHERE a_username = '" . $_SESSION['a_username'] . "'";
  $query_2 = mysqli_query($condb, $sql_2);

  header("location:profile.php?update=pass");
  exit();
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
    <div class="row justify-content-md-center">
      <div class="col-md-5 mb-4">
        <div class="card border-dark mt-2">
          <h5 class="card-header">แก้ไขข้อมูลผู้ใช้ ID : <?php echo $result[0]; ?></h5>
          <div class="card-body">
            <div class="row justify-content-md-center mb-2">
              <div class="col col-lg-6">
                <img src="images/register.png" style="width: 100%;">
              </div>
            </div>
            <form method="post">
              <div class="mb-3">
                <label class="form-label">ชื่อผู้ใช้</label>
                <input type="text" class="form-control" value="<?php echo $result[1]; ?>" disabled />
              </div>
              <div class="mb-3">
                <label class="form-label">ชื่อ</label>
                <input type="text" class="form-control" name="a_name" value="<?php echo $result[3]; ?>" required />
              </div>
              <div class="mb-3">
                <label class="form-label">นามสกุล</label>
                <input type="text" class="form-control" name="a_surname" value="<?php echo $result[4]; ?>" required />
              </div>
              <div class="mb-3">
                <label class="form-label">เพศ</label>
                <select class="form-select" name="a_sex">
                  <option value="ชาย" <?php if ($result[5] == 'ชาย') {
                                        echo " selected";
                                      } ?>>ชาย</option>
                  <option value="หญิง" <?php if ($result[5] == 'หญิง') {
                                          echo " selected";
                                        } ?>>หญิง</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control" name="a_phone" value="<?php echo $result[6]; ?>" />
              </div>
              <div align="right" >
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