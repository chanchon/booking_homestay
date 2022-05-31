<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
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
  $sql = "SELECT * FROM tb_admin  WHERE a_level = 'admin'";
} else {
  $sql = "SELECT * FROM `tb_admin` WHERE `a_level` != 'system' AND `a_home` LIKE '" . $_SESSION["a_home"] . "'";
}





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
          <h1 class="h2">ข้อมูลผู้ใช้</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <?php
            if ($_SESSION["a_level"] == "system") {
            ?>
              <!-- เพิ่มข้อมูล -->
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_data">เพิ่มผู้ใช้ <i class="fas fa-user-plus"></i></button>
            <?php
            } else {
            ?>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_data">เพิ่มผู้ใช้ <i class="fas fa-user-plus"></i></button>
            <?php
            }
            ?>



            <!-- เพิ่มข้อมูล -->

            <div class="modal fade" id="add_data" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form class="modal-content" method="post" action="admin_add_data.php">
                  <div class="modal-header">
                    <h5 class="modal-title">เพิ่มข้อมูลผู้ใช้ </h5>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">ชื่อผู้ใช้</label>
                      <input type="text" class="form-control" name="a_username">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">รหัสผ่าน</label>
                      <input type="password" class="form-control" name="a_password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">ชื่อ</label>
                      <input type="text" class="form-control" name="a_name">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">นามสกุล</label>
                      <input type="text" class="form-control" name="a_surname">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">เพศ</label>
                      <select class="form-select" name="a_sex">
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">เบอร์โทรศัพท์</label>
                      <input type="text" class="form-control phone_th" name="a_phone">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">ที่พัก</label>
                      <?php
                      if ($_SESSION["a_level"] == "system") {
                      ?>
                        <input type="text" class="form-control" name="a_home">

                      <?php
                      } elseif ($_SESSION["a_level"] == "admin") {
                      ?>
                        <input type="text" value="<?php echo $_SESSION["a_home"]; ?>" class="form-control" disabled>
                        <input type="hidden" value="<?php echo $_SESSION["a_home"]; ?>" class="form-control" name="a_home">

                      <?php
                      }
                      ?>
                    </div>
                    <?php
                    if ($_SESSION["a_level"] == "system") {
                    ?>
                    <div class="mb-3">
                      <label class="form-label">line Token</label>
                      <input type="text" class="form-control " name="line_group">
                    </div>
                      <div class="mb-3">
                        <label class="form-label">กลุ่มไลน์</label>
                        <input type="file" class="form-control" name="file" id="file"> 
                      </div>
                    <?php
                    }
                    ?>
                    <div>
                      <label class="form-label">ระดับผู้ใช้</label>
                      <select class="form-control" name="a_level">
                        <?php
                        if ($_SESSION["a_level"] == "system") {
                        ?>

                          <option value="admin" selected>แอดมิน</option>
                        <?php
                        } else if ($_SESSION["a_level"] == "admin") {
                        ?>
                          <option value="member" selected>สมาชิก</option>

                        <?php
                        }
                        ?>



                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                  </div>
                </form>
              </div>
            </div>&nbsp;&nbsp;

          </div>
        </div>
        <?php echo $check_submit; ?>
        <table class="table table-bordered table-hover table-striped" id="example">
          <!-- table-sm -->
          <thead class="thead">
            <tr class="table-dark tr" align="center">
              <th class="th" scope="col" width="65px">ลำดับที่</th>
              <th class="th" scope="col" width="130px">ชื่อผู้ใช้</th>
              <th class="th" scope="col">รหัสผ่าน</th>
              <th class="th" scope="col" width="120px">ชื่อ</th>
              <th class="th" scope="col" width="120px">นามสกุล</th>
              <th class="th" scope="col">เพศ</th>
              <th class="th" scope="col" width="120px">เบอร์โทรศัพท์</th>
              <th class="th" scope="col" width="220px">ที่พัก</th>
              <th class="th" scope="col" width="80px">ไลน์กลุ่ม</th>
              <th class="th" scope="col" width="80px">ระดับผู้ใช้</th>
              <th class="th" scope="col" width="90px">ตัวเลือก</th>
            </tr>
          </thead>
          <tbody class="tbody">
            <?php
            while ($result = mysqli_fetch_array($query)) {
            ?>
              <tr class="table-light tr">
                <th class="th text-center" scope="row"><?php echo $num++; ?></th>
                <td class="td"><?php echo $result['a_username']; ?></td>
                <td class="td" align="center" width="150px">
                  <!-- เปลี่ยนรหัสผ่าน -->
                  <button type="button " class="btn btn-warning btn-sm " data-bs-toggle="modal" data-bs-target="#edit_password<?php echo $result['a_id']; ?>">เปลี่ยนรหัสผ่าน <i class="fas fa-key"></i></button>

                  <div class="modal fade" id="edit_password<?php echo $result['a_id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <form class="modal-content" method="post" action="admin_edit_password.php">
                        <div class="modal-header">
                          <h5 class="modal-title">เปลี่ยนรหัสผ่านผู้ใช้ ID : <?php echo $result['a_id']; ?></h5>
                        </div>
                        <div class="modal-body">
                          <div>
                            <label class="form-label">รหัสผ่านใหม่</label>
                            <input type="password" class="form-control" name="a_password" required />
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                          <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $result['a_id']; ?>" />
                      </form>
                    </div>
                  </div>
                </td>
                <td class="td"><?php echo $result['a_name']; ?></td>
                <td class="td"><?php echo $result['a_surname']; ?></td>
                <td class="td"><?php echo $result['a_sex']; ?></td>
                <td class="td"><?php echo $result['a_phone']; ?></td>
                <td class="td"><?php echo $result['a_home']; ?></td>
                <td class="td" align="center">


                  <!--ปุ่ม qr code -->
                  <?php if ($result['a_level'] == "admin") {
                  ?>

                    <a type="button" data-bs-toggle="modal" data-bs-target="#qr_code"><i class="fab fa-line fa-2x"></i></a>
                  <?php
                  }
                  ?>
                  <div class="modal fade" id="qr_code" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header ">
                          <h5 class="modal-title">แสกน QR Code เพื่อเข้ากลุ่มไลน์</h5>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <img src="images/qrcode.png" width="180x180" alt="">
                          </div>
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
                        </div>
                      </div>
                    </div>
                  </div>



                </td>
                <td class="td text-center"><?php if ($result['a_level'] == "member") {
                                              echo "สมาชิก";
                                            } else if ($result['a_level'] == "admin") {
                                              echo "แอดมิน";
                                            } else {
                                              echo "ผู้ดูแลระบบ";
                                            } ?></td>
                <td class="td">
                  <!-- ปุ่มแก้ไข -->
                  <button type="button" class="btn btn-warning btn-sm" onclick="window.location.href='admin_edit.php?id=<?php echo $result['a_id']; ?>'"><i class="fa-solid fa-pen-to-square"></i></button>

                  <!-- ลบข้อมูล-->
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete_data<?php echo $result['a_id']; ?>"><i class="fa-solid fa-trash-can"></i></button>
                  <div class="modal fade" id="delete_data<?php echo $result['a_id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">ลบข้อมูล</h5>
                        </div>
                        <div class="modal-body">
                          กดยืนยันหากคุณต้องการลบผู้ใช้ <?php echo $result['a_username']; ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                          <button type="button" class="btn btn-danger" onclick="window.location.href='admin_delete.php?id=<?php echo $result['a_id']; ?>'">ยืนยัน</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </main>
    </div>
  </div>

  <!--jquery link-->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <!--datatables link-->
  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>


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