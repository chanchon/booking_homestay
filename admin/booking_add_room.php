<?php
require_once('../connection/connect.php');
include('../includes/date.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
} elseif ($_SESSION["a_level"] != "admin" &&  $_SESSION["a_level"] != "system") {
  header("location:../index.php");
  exit();
}




$id = $_GET["id"];

$sql = "SELECT * FROM tb_booking WHERE b_id = '" . $id . "'";
$query = mysqli_query($condb, $sql);
$result = mysqli_fetch_array($query, MYSQLI_ASSOC);

if (isset($_POST["submit"])) {
  $sql_2 = "UPDATE tb_booking SET room = '" . $_POST['room'] . "', guest ='"  . $_POST['guest'] . "',package ='" . $_POST['package'] . "' ,status = '" . $_POST['status'] . "' WHERE b_id = '" . $id . "'";
  $query_2 = mysqli_query($condb, $sql_2);

  header("location:index.php?update=pass");
  exit();
}



?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/dashboard.css">
  <link rel="icon" type="image/png" sizes="50x50" href="../images/icon.png">

  <title>ระบบหลังบ้าน</title>
</head>

<body>
  <?php include('includes/header.php'); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include('includes/sidebarMenu.php'); ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">เพิ่มข้อมูลห้องพัก</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">ย้อนกลับ</button>
          </div>
        </div>
        <div class="row justify-content-md-center">
          <div class="col-6">
            <div class="card">
              <h5 class="card-header"><?php echo 'เพิ่มห้อง ID : ' . $result['b_id']; ?></h5>
              <div class="card-body">
                <form method="post">
                  <div class="mb-3">
                    <label for="form-control">สถานะ</label>
                      <select class="form-select" name="status">
                        <option value="ยังไม่ชำระ" <?php if ($result["status"] == 'ยังไม่ชำระ') {echo " selected";} ?>>ยังไม่ชำระ</option>
                        <option value="ชำระแล้ว" <?php if ($result["status"] == 'ชำระแล้ว') {echo " selected";} ?>>ชำระแล้ว</option>
                        <option value="ยกเลิก" <?php if ($result["status"] == 'ยกเลิก') {echo " selected";} ?>>ยกเลิก</option>
                      </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $result['name']; ?>"  disabled/>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control phone_th" name="phone" value="<?php echo $result['phone']; ?>" disabled />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">จำนวนคนที่เข้าพัก</label>
                    <input type="text" class="form-control" name="guest" value="<?php echo $result['guest']; ?>"  />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ที่พัก</label>
                    <input type="text" class="form-control" name="้home" value="<?php echo $result['home']; ?>" disabled />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เช็กอิน</label>

                    <input type="text" class="form-control" name="้package" value="<?php echo thai_date($result['checkin']); ?>" disabled />              
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เช็กเอาท์</label>
                    <input type="text" class="form-control" name="้package" value="<?php echo thai_date($result['checkout']);?>" disabled />  
                  </div>
                  <div class="mb-3">
                    <label class="form-label">แพ็กเกจ</label>
                    <input type="text" class="form-control" name="้package" value="<?php echo $result['package']; ?>"  />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ห้อง</label>
                    <input type="text" class="form-control" name="room" value="<?php echo $result['room']; ?>" />
                  </div>
                  <div align="center" >
                  <button type="submit" name="submit" class="btn btn-primary btn-lg">บันทึก</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <!--js.mask link-->
  <script src="../assets/js/jquery.mask.min.js"></script>
  <script>
    //ล็อกเบอร์์โทร
    $(document).ready(function() {
      $('.phone_th').mask('000-0000000');
    });
  </script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <?php mysqli_close($condb); ?>
</body>

</html>