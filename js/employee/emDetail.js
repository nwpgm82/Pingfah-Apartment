var profile = document.getElementById("profile_img")
var pic_idcard = document.getElementById("pic_idcard")
var pic_home = document.getElementById("pic_home")

function edit() {
    if(profile){
        profile.disabled = false
    }
    document.getElementById("del1").style.display = "block"
    document.getElementById("edit_data").style.display = "none"
    document.getElementById("option").style.display = "block"
}

function cancel_edit() {
    if(profile){
        profile.disabled = true
    }
    document.getElementById("del1").style.display = "none"
    document.getElementById("edit_data").style.display = "block"
    document.getElementById("option").style.display = "none"
}

function delImg(user, pictype) {
    if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
        location.href = `function/delImg.php?username=${user}&&pic=${pictype}`
    }
}

function preview_image(event, pic) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
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


$(document).ready(function(){
    $('#birth_date').html(formatDate(new Date($('#birthday').val())))
    $('#birthday').dateDropper({
        theme: "my-style",
        large: true,
        largeDefault: true,
        format: "Y-m-d",
        lang: "th",
        startFromMonday: false,
        defaultDate: formatDate2($('#birthday').val())
    });

    $('#birthday').change(function(){
        $('#birth_date').html(formatDate(new Date($('#birthday').val())))
    })
})