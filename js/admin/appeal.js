function searchDate() {
    var x = document.getElementById("date_from").value
    var y = document.getElementById("date_to").value
    if (x != "" && y != "") {
        location.href = `index.php?from=${x}&to=${y}`
    } else {
        alert("กรุณาระบุวันที่ที่ต้องการค้นหา")
    }
}

function del(id) {
    if (confirm("คุณต้องการลบรายการร้องเรียนนี้ใช่หรือไม่ ? ")) {
        location.href = `function/delAppeal.php?appeal_id=${id}`
    }
}

function unCheckAll(){
    location.href = "index.php"
}

function formatDate(date) {
    var monthNames = [
        "ม.ค.", "ก.พ.", "มี.ค.",
        "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.",
        "ส.ค.", "ก.ย.", "ต.ค.",
        "พ.ค.", "ธ.ค."
    ];
    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();
    return day + ' ' + monthNames[monthIndex] + ' ' + year;
}

$(document).ready(function () {
    let date_from = $("#date_from")
    let date_to = $("#date_to")
    let from_date = $("#from_date")
    let to_date = $("#to_date")
    if (date_from.val() != "" && date_to.val() != "") {
        from_date.html(formatDate(new Date(date_from.val())))
        to_date.html(formatDate(new Date(date_to.val())))
    }

    $('.roundtrip-input').dateDropper({
        roundtrip: true,
        theme: "my-style",
        lang: "th",
        format: "Y-m-d",
        lock: "to",
        startFromMonday: false,
    });

    $('#date_from').change(function () {
        $('#from_date').html(formatDate(new Date($('#date_from').val())))
    })

    $('#date_to').change(function () {
        $('#to_date').html(formatDate(new Date($('#date_to').val())))
    })
})