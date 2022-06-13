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


if (isset($_GET["add"])) {
  if ($_GET["add"] == "pass") {
    $check_submit = check_submit_p2("บันทึกข้อมูลเรียบร้อยแล้ว");
  }
}
if (isset($_GET["update"])) {
  if ($_GET["update"] == "pass") {
    $check_submit = check_submit_p2("บันทึกข้อมูลเรียบร้อยแล้ว");
  }
}
if (isset($_GET["delete"])) {
  if ($_GET["delete"] == "pass") {
    $check_submit = check_submit_p2("ลบข้อมูลออกจากระบบเรียบร้อยแล้ว");
  }
}




if ($_SESSION["a_level"] == "system") {
  $sql = "SELECT * FROM tb_booking ";
} else {
  $sql = "SELECT * FROM tb_booking WHERE home =  '" . $_SESSION["a_home"] . "'  ";
}

$sql3 = "SELECT SUM(`guest`)AS sumguest FROM `tb_booking` WHERE home = '" . $_SESSION["a_home"] . "'";
$result3 = mysqli_query($condb, $sql3);
$row = mysqli_fetch_array($result3);
$sumcount = 0 + $row['sumguest'];



$num = 1;
$query = mysqli_query($condb, $sql);

?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/dashboard.css">



  <link rel="icon" type="image/png" sizes="50x50" href="../images/icon.png">

  <!-- font awesome -->
  <link rel="stylesheet" href="<link rel=" stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


  <!--link datatables-->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">





  <title>ระบบหลังบ้าน</title>
</head>

<body>
  <?php include('includes/header.php'); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include('includes/sidebarMenu.php'); ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">ข้อมูลการจอง</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
           
          <!-- เพิ่ม package -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_package">เพิ่มแพ็กเกจ <i class="fas fa-luggage-cart"></i></button>


            <div class="modal fade" id="add_package" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form class="modal-content" method="post"  action="admin_add_package.php">
                  <div class="modal-header">
                    <h5 class="modal-title">เพิ่มแพ็กเกจ</h5>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3 ">
                    <label class="form-label">แพ็กเกจ</label>
                        <input type="text" class="form-control " name="package_name" >
                    </div>
                    <div class="mb-3 ">
                    <label class="form-label">ราคา</label>
                        <input type="text" class="form-control " name="package_price" >
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-bordered table-hover table-striped" id="example">
          <!-- table-sm -->
          <thead class="thead">
            <tr class="table-dark  tr">
              <th class="th" scope="col" width="60px">ลำดับที่</th>

              <?php
              if ($_SESSION["a_level"] == "admin") {
              ?>
                <th class="th" scope="col" width="120px">สถานะ</th>
              <?php
              }
              ?>
              <th class="th" scope="col" width="150px">ชื่อ-นามสกุล</th>
              <th class="th" scope="col" width="130px">เบอร์โทรศัพท์</th>
              <th class="th" scope="col" width="210px"">จำนวนคนที่เข้าพัก</th>
              <th class=" th" scope="col" width="105px">ที่พัก</th>
              <th class="th" scope="col" width="150px">เช็คอิน</th>
              <th class="th" scope="col" width="150px">เช็คเอาท์</th>
              <th class="th" scope="col" width="150px">แพ็กเกจ</th>
              <th class="th" scope="col" width="60px">ห้อง</th>
              <th class="th" scope="col" width="85px">เพิ่มห้อง</th>
            </tr>
          </thead>
          <tbody class="tbody">
            <?php
            while ($result = mysqli_fetch_array($query)) {
            ?>
              <tr class="table-light tr">
                <th class="th text-center" scope="row"><?php echo $num++; ?></th>
                <?php
                if ($_SESSION["a_level"] == "admin") {
                ?>
                  <td class="td">
                    <?php
                    if ($result['status'] == "ยังไม่ชำระ") {
                      echo "<label  class='btn1 btn-unpaid'  >ยังไม่ชำระ</label>";
                    } else if ($result['status'] == "ชำระแล้ว") {
                      echo "<label  class='btn1 btn-paid' >ชำระแล้ว</label>";
                    }
                    if ($result['status'] == "ยกเลิก") {
                    ?>
                      <a type="button" class="btn btn-cancel" data-bs-toggle="modal" data-bs-target="#box<?php echo $result['b_id']; ?>">ยกเลิก</a>

                    <?php
                    }
                    ?>
                  </td>
                  <div class="modal fade" id="box<?php echo $result['b_id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header ">
                          <h5 class="modal-title">สถานะยกเลิกเนื่องจาก</h5>
                        </div>
                        <div class="modal-body">
                          <h3><?php echo $result['note']; ?></h3>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                }
                  ?>

                  <td class="td"><?php echo $result['name']; ?></td>
                  <td class="td"><?php echo $result['phone']; ?></td>
                  <td class="td text-center"><?php echo $result['guest']; ?></td>
                  <td class="td"><?php echo $result['home']; ?></td>
                  <td class="td text-center"><?php echo thai_date($result['checkin']); ?></td>
                  <td class="td text-center"><?php echo thai_date($result['checkout']);  ?></td>
                  <td class="td"><?php echo $result['package']; ?></td>
                  <td class="td text-center"><?php echo $result['room']; ?></td>
                  <td class="td text-center">
                    <!-- ปุ่มเพิ่มห้อง-->
                    <button type="button" class="btn btn-warning btn-sm" onclick="window.location.href='booking_add_room.php?id=<?php echo $result['b_id']; ?>'"><i class="fa-solid fa-pen-to-square"></i></button>

                  </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
          <?php echo $check_submit; ?>
        </table>


        <?php
        if ($_SESSION["a_level"] == "admin") {
        ?>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <p></p>
            <h5 text-align="right"> <?php echo 'จำนวนผู้จองทั้งหมด &nbsp'  . $sumcount .  '&nbsp คน' ?></h5>
          </div>
        <?php
        }
        ?>

      </main>
    </div>
  </div>


  <!--js link-->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>



  <script src="../assets/js/bootstrap.bundle.min.js"></script>



  <?php mysqli_close($condb); ?>


</body>

</html>