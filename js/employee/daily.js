function searchDate() {
    let x = document.getElementById("check_in").value
    let y = document.getElementById("check_out").value
    if (x != "" && y != "") {
        location.assign(`index.php?check_in=${x}&check_out=${y}`)
    } else {
        alert("กรุณาระบุวันที่ที่ต้องการค้นหา")
    }
}

function searchCode() {
    let z = document.getElementById("code").value
    if (z != "") {
        location.assign(`index.php?Code=${z}`)
    } else {
        alert("กรุณาระบุเลขที่ในการจองที่ต้องการค้นหา")
    }
}

function searchCheck(id) {
    var check = document.getElementById(id)
    var come = document.getElementById("come")
    var checkout = document.getElementById("checkout")
    var pending = document.getElementById("pending")
    var cancel = document.getElementById("cancel")
    come.checked = false
    checkout.checked = false
    pending.checked = false
    cancel.checked = false
    check.checked = true
    if (id != "all") {
        location.href = `index.php?Status=${check.id}`
    } else {
        location.href = "index.php"
    }

}

function searchCheck2(checkIn, checkOut, id) {
    var check = document.getElementById(id)
    var come = document.getElementById("come")
    var checkout = document.getElementById("checkout")
    var pending = document.getElementById("pending")
    var cancel = document.getElementById("cancel")
    come.checked = false
    checkout.checked = false
    pending.checked = false
    cancel.checked = false
    check.checked = true
    if (id != "all") {
        location.href = `index.php?check_in=${checkIn}&check_out=${checkOut}&Status=${check.id}`
    } else {
        location.href = `index.php?check_in=${checkIn}&check_out=${checkOut}`
    }

}

function selectRoom(num) {
    let btn = document.getElementById(`btn${num}`)
    let room = document.getElementById(`select${num}`)
    btn.style.display = "none"
    room.style.display = "block"
}

function confirmRoom(id, num) {
    let room_select = document.getElementById(`room_select${num}`).value
    if (room_select != "") {
        if (confirm(`คุณต้องการเลือกห้องนี้ ${room_select} ใช่หรือไม่ ? `)) {
            location.href = `function/addDailyData.php?daily_id=${id}&room_select=${room_select}`
        }
    } else {
        alert("กรุณาโปรดเลือกห้อง");
    }

}

function del(id) {
    if (confirm('คุณต้องการลบรายการจองห้องพักใช่หรือไม่ ?')) {
        location.href = `function/delDaily.php?id=${id}`
    }
}

function delImg(id, name) {
    if (confirm("คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?")) {
        location.href = `function/delImage.php?id=${id}&name=${name}`
    }
}

function check_out(id) {
    if (confirm('คุณต้องการเช็คเอ้าท์ใช่หรือไม่ ?')) {
        location.href = `function/checkout.php?daily_id=${id}`
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