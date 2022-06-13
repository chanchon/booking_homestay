var date_start = new Date();
date_start.setDate(date_start.getDate());

$('.datepicker').datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'yyyy-mm-dd',
    language: 'th',
    startDate: date_start,
});


//แก้โหลดหน้าต่างซ้ำ

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}



//ล็อกเบอร์์โทร
$(document).ready(function() {
    $('#phone_th').mask('000-0000000');
});