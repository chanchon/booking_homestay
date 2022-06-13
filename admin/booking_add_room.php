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
if (isset($_POST["submit"])) {

if( $_POST['package'] != NULL){
  $package = implode(",", $_POST['package']);
  
     
}

  $sql_2 = "UPDATE tb_booking SET room = '" . $_POST['room'] . "', guest ='"  . $_POST['guest'] . "', note ='"  . $_POST['note'] . "',package ='" . $package . "' ,status = '" . $_POST['status'] . "' WHERE b_id = '" . $id . "'";
    
  $query_2 = mysqli_query($condb, $sql_2);
  
  header("location:index.php?update=pass");
  exit();
  
}
$sql = "SELECT * FROM tb_booking WHERE b_id = '" . $id . "'";
$query = mysqli_query($condb, $sql);
$result = mysqli_fetch_array($query, MYSQLI_ASSOC);




?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/dashboard.css">
  <link rel="icon" type="image/png" sizes="50x50" href="../images/icon.png">



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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
                    <select class="form-select" id="status" name="status" onchange="changeStatus()">
                      <option value="ยังไม่ชำระ" <?php if ($result["status"] == 'ยังไม่ชำระ') {
                                                    echo " selected";
                                                  } ?>>ยังไม่ชำระ</option>
                      <option value="ชำระแล้ว" <?php if ($result["status"] == 'ชำระแล้ว') {
                                                  echo " selected";
                                                } ?>>ชำระแล้ว</option>
                      <option value="ยกเลิก" <?php if ($result["status"] == 'ยกเลิก') {
                                                echo " selected";
                                              } ?>>ยกเลิก</option>
                    </select>
                  </div>
                  <div class="mb-3" id="note">
                    <label class="form-label">เหตุผล</label>
                    <input type="text" class="form-control" name="note" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $result['name']; ?>" disabled />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control phone_th" name="phone" value="<?php echo $result['phone']; ?>" disabled />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">จำนวนคนที่เข้าพัก</label>
                    <input type="text" class="form-control" name="guest" value="<?php echo $result['guest']; ?>" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ที่พัก</label>
                    <input type="text" class="form-control" name="้home" value="<?php echo $result['home']; ?>" disabled />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เช็กอิน</label>

                    <input type="text" class="form-control" name="้checkin" value="<?php echo thai_date($result['checkin']); ?>" disabled />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เช็กเอาท์</label>
                    <input type="text" class="form-control" name="้checkout" value="<?php echo thai_date($result['checkout']); ?>" disabled />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">แพ็กเกจ</label>
                    <select name="package[]" class="multi-select" multiple title="เลือกแพ็กเกจ<?php echo $result['package']; ?>">
                      <option name="package[]" value="อาหาร 3 มื้อ">อาหาร 3 มื้อ</option>
                      <option name="package[]" value="นำเที่ยว">นำเที่ยว</option>
                      <option name="package[]" value="ทำกิจกรรม" <?php if($result['package'] == 'ทำกิจกรรม'){echo 'selected';}  ?> >ทำกิจกรรม</option>
                      <option name="package[]" value="ยกเลิกแพ็กเกจ">ยกเลิกแพ็กเกจ</option>

                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ห้อง</label>
                    <input type="text" class="form-control"  name="room">
                  </div>
                  <div align="center">
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




  <!--js.mask link-->
  <script src="../assets/js/jquery.mask.min.js"></script>
  <script>
    //ล็อกเบอร์์โทร
    $(document).ready(function() {
      $('.phone_th').mask('000-0000000');
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).ready(function() {
      $('.multi-select').selectpicker();
    });
  </script>
  <script>
    function changeStatus() {
      var status = document.getElementById("status");
      if (status.value == 'ยกเลิก') {
        document.getElementById("note").style.visibility = "visible";
      } else {
        document.getElementById("note").style.visibility = "hidden";
      }
    }
  </script>



  <!-- custom js file link  -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
<?php mysqli_close($condb); ?>
</body>

</html>