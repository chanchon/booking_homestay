<!-- font awesome -->
<link rel="stylesheet" href="<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" /> 




<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
    <?php
    if ($_SESSION["a_level"] == "admin") {
    ?>
      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <h6><i class="fas fa-calendar-check"></i> การจอง</h6>
        </a>
      </li>
      <?php
    }
    ?>
      <li class="nav-item">
        <a class="nav-link" href="booking_report.php">
          <h6><i class="fas fa-book-open"></i> รายงานการจอง</h6>
        </a>
      </li>
      

      <li class="nav-item">
        <a class="nav-link" href="admin.php">
          <h6><i class="fas fa-users"></i> ข้อมูลสมาชิก</h6>
        </a>
      </li>
    </ul>

   

    <?php
    if ($_SESSION["a_level"] != "member") {
    ?>
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>โปรไฟล์</span>
        <i class="fa-solid fa-gear"></i>
      </h6>
      <ul class="nav flex-column mb-2">
        <li class="nav-item">
          <a class="nav-link" href="../profile.php">
          <i class="fas fa-address-card"></i> ข้อมูลส่วนตัว
          </a>
        </li>
      </ul>
    <?php
    }
    ?>

  </div>
</nav>