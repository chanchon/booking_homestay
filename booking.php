<?php
require_once('connection/connect.php');

//line notify
function sendlinemesg($message, $LINE_TOKEN)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$message");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array("Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $LINE_TOKEN",);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}




/////กำหนดตัวแปรเพื่อเก็บค่า
if (isset($_POST) && !empty($_POST)) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $guest = $_POST['guest'];
    $home = $_POST['home'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];


    $package = implode(",", $_POST['package']);
    if ($package != '-') {
        $package = substr($package, 2);
    }

    //เช็คจำนวนคนที่เข้าพัก
    $sql3 = "SELECT SUM(`guest`)AS sumguest FROM `tb_booking` WHERE `home` LIKE '$home' ORDER BY `b_id` ASC";
    $result3 = mysqli_query($condb, $sql3);
    $row = mysqli_fetch_array($result3);
    if ($row['sumguest'] == 50) {
        echo '<script type="text/javascript">';
        echo "setTimeout(function () { swal('ไม่สามารถจองที่พักได้ !!','เนื่องจากมีผู้จองครบแล้ว');";
        echo '}, 1000);</script>';
    } else {
        $count = 50 - $row['sumguest'];

        if ($count >= $guest) {
            $sql = "INSERT INTO tb_booking (name, phone, guest, home, checkin, checkout, package) 
           VALUES('$name', '$phone', '$guest', '$home', '$checkin', '$checkout', '$package')";
            $result = mysqli_query($condb, $sql);


            if ($result) {
                $sql6 = "SELECT line_group FROM `tb_admin` WHERE `a_home` = '$home' AND `a_level` = 'admin'";
                $result6 = mysqli_query($condb, $sql6);
                $Tk = mysqli_fetch_array($result6);
                $message = "\n มีลูกค้าเข้า เบอร์ \n"  . $phone;
                $LINE_TOKEN = $Tk['line_group'];
                sendlinemesg($message, $LINE_TOKEN);
 

                echo '<script type="text/javascript">';
                echo "setTimeout(function () { swal('ทำการจองเรียบร้อยแล้ว', 'เราจะติดต่อกลับในเร็วๆ นี้', 'success',);";
                echo '}, 1000);</script>';
            } else {
                echo '<script type="text/javascript">';
                echo "setTimeout(function () { swal('เกิดข้อผิดพลาด');";
                echo '}, 1000);</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo "setTimeout(function () { swal('สามารถจองได้เพียง " . $count . "ท่าน');";
            echo '}, 1000);</script>';
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="50x50" href="images/icon.png">



    <!-- bootstrap cdn datepicker link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">









    <title>จองโฮมสเตย์</title>
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="container-1">
                <div class="title-1">จองโฮมสเตย์ <i class="fas fa-map-marked-alt"></i></div>
                <div class="content-1">
                    <form method="post">
                        <div class="user-details">
                            <div class="input-box">
                                <span class="details">ชื่อ-นามสกุล</span>
                                <input type="text" name="name" required>
                            </div>
                            <div class="input-box">
                                <span class="details">เบอร์โทรศัพท์</span>
                                <input type="text" name="phone" id="phone_th" required>
                            </div>
                            <div class="input-box">
                                <span class="details">จำนวนผู้เข้าพัก</span>
                                <input type="number" name="guest" min="1" max="30" required>
                            </div>
                            <div class="input-box">
                                <span class="details">พักที่</span>
                                <select name="home" required>

                                    <option value="">เลือกที่พัก</option>
                                    <?php
                                    $sql4 = "SELECT `a_home` FROM `tb_admin` WHERE a_home != '-' GROUP BY a_home";
                                    $result4 = mysqli_query($condb, $sql4);


                                    while ($row4 = mysqli_fetch_array($result4)) {
                                        echo '<option value="' . $row4['a_home'] . '"> ' . $row4['a_home'] . '</option>';
                                    }

                                    ?>


                                </select>
                            </div>
                            <div class="input-box">
                                <span class="details">เช็คอิน</span>
                                <input type="text" class="datepicker" name="checkin" placeholder="เลือกวันที่" required>



                            </div>
                            <div class="input-box">
                                <span class="details">เช็คเอาท์</span>
                                <input type="text" class="datepicker" name="checkout" placeholder="เลือกวันที่" required>
                            </div>
                        </div>
                        <div class="package-details">
                            <span class="package-title">แพ็กเกจ</span>
                            <input type="hidden" name="package[]" value="-" checked>
                            <input type="checkbox" name="package[]" id="dot-1" value="อาหาร 3 มื้อ">
                            <input type="checkbox" name="package[]" id="dot-2" value="นำเที่ยว">
                            <input type="checkbox" name="package[]" id="dot-3" value="ทำกิจกรรม">
                            <div class="category">
                                <label for="dot-1">
                                    <span class="dot one"></span>
                                    <span class="package">อาหาร 3 มื้อ</span>
                                </label>
                                <label for="dot-2">
                                    <span class="dot two"></span>
                                    <span class="package">นำเที่ยว</span>
                                </label>
                                <label for="dot-3">
                                    <span class="dot three"></span>
                                    <span class="package">ทำกิจกรรม</span>
                                </label>
                            </div>
                        </div>
                        <div class="button">
                            <input type="submit" value="จอง">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--js cdn link-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>




    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>




    <!-- custom js file link  -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/jquery.mask.min.js"></script>



</body>

</html>