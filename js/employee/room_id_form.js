function preview_image(event, pic) {
    console.log(pic)
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function delImg(type, pictype, num) {
    if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
        location.href = `function/delImg.php?room_id=${type}&pic=${pictype}&num=${num}`
    }
}

function navigation() {
    var first = document.getElementById("first")
    var second = document.getElementById("second")
    if (first.style.display == 'none') {
        first.style.display = 'block'
        second.style.display = 'none'
    } else if (second.style.display == 'none') {
        first.style.display = 'none'
        second.style.display = 'block'
    }
}

function delData(room) {
    if (confirm(`คุณต้องการลบข้อมูลของห้อง ${room} ใช่หรือไม่`)) {
        location.assign(`function/delRoom_data.php?ID=${room}`);
    }
}

function editData(num) {
    if (num == 1) {
        let btn = document.getElementById("btn-1")
        let edit = document.getElementById("edit-1")
        btn.style.display = "flex"
        edit.style.display = "none"
        document.getElementById("name_title").disabled = false
        document.getElementById("firstname").disabled = false
        document.getElementById("lastname").disabled = false
        document.getElementById("nickname").disabled = false
        document.getElementById("id_card").disabled = false
        document.getElementById("phone").disabled = false
        document.getElementById("email").disabled = false
        document.getElementById("line").disabled = false
        document.getElementById("birthday").disabled = false
        document.getElementById("birth_date").style.backgroundColor = "#fff"
        document.getElementById("age").disabled = false
        document.getElementById("race").disabled = false
        document.getElementById("nationality").disabled = false
        document.getElementById("job").disabled = false
        document.getElementById("address").disabled = false
        if (document.getElementById("pic_idcard1")) {
            document.getElementById("pic_idcard1").disabled = false
        }
        if (document.getElementById("pic_home1")) {
            document.getElementById("pic_home1").disabled = false
        }

        for (let i = 1; i <= 2; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'block'
            }
        }
    } else if (num == 2) {
        let btn = document.getElementById("btn-2")
        let edit = document.getElementById("edit-2")
        btn.style.display = "flex"
        edit.style.display = "none"
        document.getElementById("name_title2").disabled = false
        document.getElementById("firstname2").disabled = false
        document.getElementById("lastname2").disabled = false
        document.getElementById("nickname2").disabled = false
        document.getElementById("id_card2").disabled = false
        document.getElementById("phone2").disabled = false
        document.getElementById("email2").disabled = false
        document.getElementById("line2").disabled = false
        document.getElementById("birthday2").disabled = false
        document.getElementById("birth_date2").style.backgroundColor = "#fff"
        document.getElementById("age2").disabled = false
        document.getElementById("race2").disabled = false
        document.getElementById("nationality2").disabled = false
        document.getElementById("job2").disabled = false
        document.getElementById("address2").disabled = false
        if (document.getElementById("pic_idcard2")) {
            document.getElementById("pic_idcard2").disabled = false
        }
        if (document.getElementById("pic_home2")) {
            document.getElementById("pic_home2").disabled = false
        }
        for (let i = 3; i <= 4; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'block'
            }
        }
    }
}

function cancelEditData(num) {
    if (num == 1) {
        let btn = document.getElementById("btn-1")
        let edit = document.getElementById("edit-1")
        btn.style.display = "none"
        edit.style.display = "flex"
        document.getElementById("name_title").disabled = true
        document.getElementById("firstname").disabled = true
        document.getElementById("lastname").disabled = true
        document.getElementById("nickname").disabled = true
        document.getElementById("id_card").disabled = true
        document.getElementById("phone").disabled = true
        document.getElementById("email").disabled = true
        document.getElementById("line").disabled = true
        document.getElementById("birthday").disabled = true
        document.getElementById("birth_date").style.backgroundColor = "#fafafa"
        document.getElementById("age").disabled = true
        document.getElementById("race").disabled = true
        document.getElementById("nationality").disabled = true
        document.getElementById("job").disabled = true
        document.getElementById("address").disabled = true
        if (document.getElementById("pic_idcard1")) {
            document.getElementById("pic_idcard1").disabled = true
        }
        if (document.getElementById("pic_home1")) {
            document.getElementById("pic_home1").disabled = true
        }
        for (let i = 1; i <= 2; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'none'
            }
        }
    } else if (num == 2) {
        let btn = document.getElementById("btn-2")
        let edit = document.getElementById("edit-2")
        btn.style.display = "none"
        edit.style.display = "flex"
        document.getElementById("name_title2").disabled = true
        document.getElementById("firstname2").disabled = true
        document.getElementById("lastname2").disabled = true
        document.getElementById("nickname2").disabled = true
        document.getElementById("id_card2").disabled = true
        document.getElementById("phone2").disabled = true
        document.getElementById("email2").disabled = true
        document.getElementById("line2").disabled = true
        document.getElementById("birthday2").disabled = true
        document.getElementById("birth_date2").style.backgroundColor = "#fafafa"
        document.getElementById("age2").disabled = true
        document.getElementById("race2").disabled = true
        document.getElementById("nationality2").disabled = true
        document.getElementById("job2").disabled = true
        document.getElementById("address2").disabled = true
        if (document.getElementById("pic_idcard2")) {
            document.getElementById("pic_idcard2").disabled = true
        }
        if (document.getElementById("pic_home2")) {
            document.getElementById("pic_home2").disabled = true
        }
        for (let i = 3; i <= 4; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'none'
            }
        }
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

if($('#come').val() != ""){
    $('#come_date').html(formatDate(new Date($('#come').val())))
    $('#come_date2').html(formatDate(new Date($('#come').val())))
}
if($('#birthday').val() != ""){
    $('#birth_date').html(formatDate(new Date($('#birthday').val())))
}
if($('#birthday2').val() != ""){
    $('#birth_date2').html(formatDate(new Date($('#birthday2').val())))
}

$('#come').dateDropper({
    theme: "my-style",
    large: true,
    largeDefault: true,
    format: "Y-m-d",
    lang: "th",
    startFromMonday: false,
});

$('#come2').dateDropper({
    theme: "my-style",
    large: true,
    largeDefault: true,
    format: "Y-m-d",
    lang: "th",
    startFromMonday: false,
});


$('#birthday').dateDropper({
    theme: "my-style",
    large: true,
    largeDefault: true,
    format: "Y-m-d",
    lang: "th",
    startFromMonday: false,
    defaultDate: formatDate2($('#birthday').val())
});

$('#birthday2').dateDropper({
    theme: "my-style",
    large: true,
    largeDefault: true,
    format: "Y-m-d",
    lang: "th",
    startFromMonday: false,
    defaultDate: formatDate2($('#birthday2').val())
});

$('#come').change(function () {
    $('#come_date').html(formatDate(new Date($('#come').val())))
})

$('#birthday').change(function () {
    $('#birth_date').html(formatDate(new Date($('#birthday').val())))
})

$('#birthday2').change(function () {
    $('#birth_date2').html(formatDate(new Date($('#birthday2').val())))
})