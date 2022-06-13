<?php
require_once('../connection/connect.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
} elseif ($_SESSION["a_level"] != "admin" &&  $_SESSION["a_level"] != "system") {
  header("location:../index.php");
  exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM tb_admin WHERE a_id = '" . $id . "'";
$query = mysqli_query($condb, $sql);
$result = mysqli_fetch_array($query, MYSQLI_ASSOC);

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
} elseif ($_SESSION["a_level"] != "admin" &&  $_SESSION["a_level"] != "system") {
  header("location:../index.php");
  exit();
}


if (isset($_POST["submit"])) {

  if($_FILES["upload"]['name'] != NULL){
    $allowed =  array('png', 'PNG', 'jpg', 'jpeg');
    $ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

      if (!in_array($ext, $allowed)) {
          echo '<script type="text/javascript" language="javascript">
                alert("นามสกุลไฟล์ไม่ถูกต้อง กรุณาอัพโหลดไฟล์ตามนามสกุล '.$_FILES["upload"]['name'].' .png .PNG .jpg . jpeg ");
                window.history.back()
                
                </script>';
              
          exit();
      }

    
      $path="";
      if ($_FILES['upload']) {
          $file = $_FILES['upload'];
          $path = "images/". $_POST['id'].'.'. $ext;

          if (!move_uploaded_file($file['tmp_name'], $path)) {
              $path = "";
          }
      }


  }else{
    $path = $_POST["uploadold"];
  }

  

  $sql_2 = "UPDATE tb_admin SET a_username = '" . $_POST['a_username'] . "', a_name = '" . $_POST['a_name'] . "', a_surname = '" . $_POST['a_surname'] . "',
    a_sex = '" . $_POST['a_sex'] . "', a_phone = '" . $_POST['a_phone'] . "', image = '" . $path . "', a_home = '" . $_POST['a_home'] . "',
     line_token = '" . $_POST['line_token'] . "', a_level = '" . $_POST['a_level'] . "' WHERE a_id = '" . $_POST['id'] . "'";
  $query_2 = mysqli_query($condb, $sql_2);

  header("location:admin.php?update=pass");
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
          <h1 class="h2">แก้ไขข้อมูลผู้ใช้งาน</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='admin.php'">ย้อนกลับ</button>
          </div>
        </div>
        <div class="row justify-content-md-center" enctype="multipart/form-data">
          <div class="col-6">
            <div class="card">
              <h5 class="card-header"><?php echo 'ID : ' . $result['a_id']; ?></h5>
              <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="admin_edit.php">
                  <div class="mb-3">
                    <label class="form-label">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" name="a_username" value="<?php echo $result['a_username']; ?>"  />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ชื่อ</label>
                    <input type="text" class="form-control" name="a_name" value="<?php echo $result['a_name']; ?>"  />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">นามสกุล</label>
                    <input type="text" class="form-control" name="a_surname" value="<?php echo $result['a_surname']; ?>"  />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เพศ</label>
                    <select class="form-select" name="a_sex">
                      <option value="ชาย" <?php if ($result["a_sex"] == 'ชาย') {
                                            echo " selected";
                                          } ?>>ชาย</option>
                      <option value="หญิง" <?php if ($result["a_sex"] == 'หญิง') {
                                              echo " selected";
                                            } ?>>หญิง</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control phone_th" name="a_phone" value="<?php echo $result['a_phone']; ?>" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ที่พัก</label>
                    <input type="text" class="form-control" name="a_home" value="<?php echo $result['a_home']; ?>"  />
                  </div>
                  <?php
                  if ($_SESSION["a_level"] == "system") {
                  ?>
                    <div class="mb-3">
                      <label class="form-label">line Token</label>
                      <input type="text" class="form-control" name="line_token" value="<?php echo $result['line_token']; ?>"  />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">กลุ่มไลน์</label>
                        <input type="file" class="form-control" name="upload" id="upload"> 
                        <input type="hidden" class="form-control" name="uploadold" value="<?php echo $result['image']; ?>" > 
                        <input type="hidden" class="form-control" name="id" value="<?php echo $result['a_id']; ?>" > 

                      </div>
                  <?php
                  }
                  ?>
                  <div class="mb-3">
                    <label class="form-label">ระดับผู้ใช้</label>
                    <select class="form-select" name="a_level">
                      <?php
                      if ($_SESSION["a_level"] == "admin") {
                      ?>
                        <option value="member" <?php if ($result["a_level"] == 'member') {
                                                  echo " selected";
                                                } ?>>สมาชิก</option>
                        <option value="admin" <?php if ($result["a_level"] == 'admin') {
                                                echo " selected";
                                              } ?>>แอดมิน</option>
                      <?php
                      } else {
                      ?>
                        <option value="admin">แอดมิน</option>
                      <?php
                      }
                      ?>

                    </select>
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

  <!--jquery link-->
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