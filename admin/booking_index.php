<?php
require_once('../connection/connect.php');
include('../includes/date.php');

if ($_SESSION == NULL) {
    header("location:../login.php");
    exit();
} elseif ($_SESSION["a_level"] != "admin") {
    header("location:../index.php");
    exit();
}



$num = 1;
$sql = "SELECT * FROM tb_booking WHERE home =  '" . $_SESSION["a_home"] . "'  ";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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
                    <h1 class="h2">รายงานการจอง</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                    </div>
                </div>
                <table id="example" class="table table-bordered table-hover table-striped">
                    <!-- table-sm -->
                    <thead class="thead">
                        <tr class="table-dark tr" align="center">
                            <th scope="col">ลำดับที่</th>
                            <th scope="col">ชื่อ-นามสกุล</th>
                            <th scope="col">เบอร์โทรศัพท์</th>
                            <th scope="col">จำนวนคนที่เข้าพัก</th>
                            <th scope="col">ที่พัก</th>
                            <th scope="col">เช็คอิน</th>
                            <th scope="col">เช็คเอาท์</th>
                            <th scope="col">แพ็กเกจ</th>
                            <th scope="col">ห้อง</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <?php
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr class="table-light tr" align="center">
                                <th class="th" scope="row"><?php echo $num++; ?></th>
                                <td class="td"><?php echo $result['name']; ?></td>
                                <td class="td"><?php echo $result['phone']; ?></td>
                                <td class="td"><?php echo $result['guest']; ?></td>
                                <td class="td"><?php echo $result['home']; ?></td>
                                <td class="td"><?php echo thai_date($result['checkin']); ?></td>
                                <td class="td"><?php echo thai_date($result['checkout']);  ?></td>
                                <td class="td"><?php echo $result['package']; ?></td>
                                <td class="td"><?php echo $result['room']; ?></td>
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
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script>
  //datatables
  $(document).ready(function() {
    var table = $('#example').DataTable({
      lengthChange: false,
      buttons: ['copy', 'excel', 'print']
    });

    table.buttons().container()
      .appendTo('#example_wrapper .col-md-6:eq(0)');
  });
</script>



<!-- custom js file link  -->
<script src="assets/js/bootstrap.bundle.min.js"></script>



<?php mysqli_close($condb); ?>
</body>

</html>