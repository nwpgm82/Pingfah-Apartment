function searchDate() {
    let x = document.getElementById("check_in").value
    let y = document.getElementById("check_out").value
    location.assign(`index.php?check_in=${x}&check_out=${y}`)
    console.log(x)
}

function searchCheck(id) {
    var check = document.getElementById(id)
    var available = document.getElementById("available")
    var unavailable = document.getElementById("unavailable")
    var daily = document.getElementById("daily")
    available.checked = false
    unavailable.checked = false
    daily.checked = false
    check.checked = true
    location.href = `index.php?Status=${check.id}`
}

function unCheckAll() {
    var available = document.getElementById("available")
    var unavailable = document.getElementById("unavailable")
    var daily = document.getElementById("daily")
    available.checked = false
    unavailable.checked = false
    daily.checked = false
    location.href = "index.php"
}

function editType(room) {
    var typeShow = document.getElementById(`typeShow${room.toString()}`)
    var typeEdit = document.getElementById(`typeEdit${room.toString()}`)
    var typeShow_btn = document.getElementById(`typeShow-btn${room.toString()}`)
    var typeEdit_btn = document.getElementById(`typeEdit-btn${room.toString()}`)
    if (typeShow.style.display == '') {
        typeShow.style.display = 'none'
        typeEdit.style.display = ''
        typeShow_btn.style.display = 'none'
        typeEdit_btn.style.display = ''
    } else {
        typeShow.style.display = ''
        typeEdit.style.display = 'none'
        typeShow_btn.style.display = ''
        typeEdit_btn.style.display = 'none'
    }
}

function acceptEdit(room) {
    var typeShow = document.getElementById(`typeShow${room.toString()}`)
    var typeEdit = document.getElementById(`typeEdit${room.toString()}`)
    var typeShow_btn = document.getElementById(`typeShow-btn${room.toString()}`)
    var typeEdit_btn = document.getElementById(`typeEdit-btn${room.toString()}`)
    typeShow.style.display = ''
    typeEdit.style.display = 'none'
    typeShow_btn.style.display = ''
    typeEdit_btn.style.display = 'none'
}

function cancelEdit(room) {
    var typeShow = document.getElementById(`typeShow${room.toString()}`)
    var typeEdit = document.getElementById(`typeEdit${room.toString()}`)
    var typeShow_btn = document.getElementById(`typeShow-btn${room.toString()}`)
    var typeEdit_btn = document.getElementById(`typeEdit-btn${room.toString()}`)
    typeShow.style.display = ''
    typeEdit.style.display = 'none'
    typeShow_btn.style.display = ''
    typeEdit_btn.style.display = 'none'
}

function addRoom() {
    let addRoom_btn = document.getElementById("addRoom-btn")
    let add = document.getElementById("addRoom")
    add.style.display = 'flex'
    addRoom_btn.style.display = 'none'
}

function canceladdRoom() {
    let addRoom_btn = document.getElementById("addRoom-btn")
    let add = document.getElementById("addRoom")
    add.style.display = 'none'
    addRoom_btn.style.display = ''
}

function del(room) {
    if (confirm(`คุณต้องการลบห้อง ${room} ใช่หรือไม่ ?`)) {
        location.href = `function/delRoom.php?ID=${room}`
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
    let check_in = document.getElementById("check_in")
    let check_out = document.getElementById("check_out")
    let check_in_date = document.getElementById("check_in_date")
    let check_out_date = document.getElementById("check_out_date")
    if (check_in.value == "" && check_out.value == "") {
        let today_monthNames = [
            "ม.ค.", "ก.พ.", "มี.ค.",
            "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.",
            "ส.ค.", "ก.ย.", "ต.ค.",
            "พ.ค.", "ธ.ค."
        ];
        let today = new Date()
        let today_day = today.getDate()
        let today_month = today.getMonth() + 1
        let today_year = today.getFullYear()
        let tomorrow_day = today.getDate() + 1
        let tomorrow_month = today.getMonth() + 1
        let tomorrow_year = today.getFullYear()
        let current_dayShow = today_day + ' ' + today_monthNames[today_month - 1] + ' ' + today_year
        let next_dayShow = tomorrow_day + ' ' + today_monthNames[tomorrow_month - 1] + ' ' + tomorrow_year
        if (today_day < 10) {
            today_day = '0' + today_day.toString()
        }
        if (today_month < 10) {
            today_month = '0' + today_month.toString()
        }
        if (tomorrow_day < 10) {
            tomorrow_day = '0' + tomorrow_day.toString()
        }
        if (tomorrow_month < 10) {
            tomorrow_month = '0' + tomorrow_month.toString()
        }
        let current_day = today_year + '-' + today_month + '-' + today_day

        let next_day = tomorrow_year + '-' + tomorrow_month + '-' + tomorrow_day
        check_in.value = current_day
        // check_in.setAttribute("min", current_day)
        check_out.value = next_day
        // check_out.setAttribute("min", check_out.value)
        check_in_date.innerHTML = current_dayShow
        check_out_date.innerHTML = next_dayShow
    } else {
        check_in_date.innerHTML = formatDate(new Date(check_in.value))
        check_out_date.innerHTML = formatDate(new Date(check_out.value))
    }

    $('.roundtrip-input').dateDropper({
        roundtrip: "my-trip",
        theme: "my-style",
        format: "Y-m-d",
        lang: "th",
        lock: "from",
        startFromMonday: false,
    });

    $('#check_in').change(function () {
        console.log("check in :", $('#check_in').val())
        $('#check_in_date').html(formatDate(new Date($('#check_in').val())))
        if (new Date($("#check_in").val()) >= new Date($("#check_out").val())) {
            let nDate = new Date($("#check_in").val())
            nDate.setDate(nDate.getDate() + 1)
            let nDate_date = nDate.getDate()
            let nDate_month = nDate.getMonth() + 1
            if (nDate_date < 10) {
                nDate_date = "0" + nDate_date.toString()
            }
            if (nDate_month < 10) {
                nDate_month = "0" + nDate_month.toString()
            }
            $("#check_out").val(nDate.getFullYear() + "-" + nDate_month + "-" + nDate_date)
            $("#check_out_date").html(formatDate(new Date($("#check_out").val())))
    
        }else{
            $('#check_out_date').html(formatDate(new Date($('#check_out').val())))
        }
    })
    
    $('#check_out').change(function () {
        if (new Date($("#check_in").val()) >= new Date($("#check_out").val())) {
            let nDate = new Date($("#check_in").val())
            nDate.setDate(nDate.getDate() + 1)
            let nDate_date = nDate.getDate()
            let nDate_month = nDate.getMonth() + 1
            if (nDate_date < 10) {
                nDate_date = "0" + nDate_date.toString()
            }
            if (nDate_month < 10) {
                nDate_month = "0" + nDate_month.toString()
            }
            $("#check_out").val(nDate.getFullYear() + "-" + nDate_month + "-" + nDate_date)
            $("#check_out_date").html(formatDate(new Date($("#check_out").val())))
    
        } else {
            $('#check_out_date').html(formatDate(new Date($('#check_out').val())))
        }
    })
})