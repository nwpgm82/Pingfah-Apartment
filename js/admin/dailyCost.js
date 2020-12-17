function searchDate() {
    let x = document.getElementById("check_in").value
    let y = document.getElementById("check_out").value
    if (x != "" && y != "") {
        location.assign(`index.php?check_in=${x}&check_out=${y}`)
    } else {
        alert("กรุณากรอกวันที่ที่ต้องการค้นหา")
    }

}

function searchCode() {
    let z = document.getElementById("code").value
    if (z != "") {
        location.assign(`index.php?Code=${z}`)
    } else {
        alert("กรุณากรอกเลขที่ในการจองที่ต้องการค้นหา")
    }
}

function delDailyCost(id) {
    if (confirm('คุณต้องการลบรายการชำระเงินนี้ใช่หรือไม่ ?')) {
        location.href = `function/delDailyCost.php?id=${id}`
    }
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

function formatDate2(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        // Months use 0 index.
        return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
    }
}
$(document).ready(function () {
    let check_in = $("#check_in")
    let check_out = $("#check_out")
    let check_in_date = $("#check_in_date")
    let check_out_date = $("#check_out_date")
    if (check_in.val() != "" && check_out.val() != "") {
        check_in_date.html(formatDate(new Date(check_in.val())))
        check_out_date.html(formatDate(new Date(check_out.val())))
    }

    $('.roundtrip-input').dateDropper({
        roundtrip: true,
        theme: "my-style",
        lang: "th",
        lock: "to",
        format: "Y-m-d",
        startFromMonday: false,
    });

    $('#check_in').change(function () {
        console.log("check in :", $('#check_in').val())
        $('#check_in_date').html(formatDate(new Date($('#check_in').val())))
    })

    $('#check_out').change(function () {
        $('#check_out_date').html(formatDate(new Date($('#check_out').val())))
    })
})