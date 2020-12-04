let check_in = document.getElementById("check_in")
let check_out = document.getElementById("check_out")
let check_in_date = document.getElementById("check_in_date")
let check_out_date = document.getElementById("check_out_date")
var url_string = window.location.href
var url = new URL(url_string)
var peoplePath = parseInt(url.searchParams.get("people"))

function checkRoomLoad() {
    check_in_date.innerHTML = formatDate(new Date(check_in.value))
    check_out_date.innerHTML = formatDate(new Date(check_out.value))
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
    if (today_day < 10) {
        today_day = '0' + today_day.toString()
    }
    if (today_month < 10) {
        today_month = '0' + today_month.toString()
    }
    let current_day = today_year + '-' + today_month + '-' + today_day
    check_in.setAttribute("min", current_day)
    if (new Date(check_in.value).getTime() >= new Date(check_out.value).getTime()) {
        let nDate = new Date(check_in.value)
        nDate.setDate(nDate.getDate() + 1)
        let nDate_date = nDate.getDate()
        let nDate_month = nDate.getMonth() + 1
        if (nDate_date < 10) {
            nDate_date = "0" + nDate_date.toString()
        }
        if (nDate_month < 10) {
            nDate_month = "0" + nDate_month.toString()
        }
        check_out.value = nDate.getFullYear() + "-" + nDate_month + "-" + nDate_date
        check_out_date.innerHTML = formatDate(new Date(check_out.value))
        check_out.setAttribute("min", check_out.value)
    }
}

function checkInDate(value) {
    console.log(value)
    check_in_date.innerHTML = formatDate(new Date(value))
    check_out.setAttribute("min", check_in.value)
    if (new Date(value).getTime() >= new Date(check_out.value).getTime()) {
        let nDate = new Date(check_in.value)
        nDate.setDate(nDate.getDate() + 1)
        let nDate_date = nDate.getDate()
        let nDate_month = nDate.getMonth() + 1
        if (nDate_date < 10) {
            nDate_date = "0" + nDate_date.toString()
        }
        if (nDate_month < 10) {
            nDate_month = "0" + nDate_month.toString()
        }
        check_out.value = nDate.getFullYear() + "-" + nDate_month + "-" + nDate_date
        check_out_date.innerHTML = formatDate(new Date(check_out.value))
        check_out.setAttribute("min", check_out.value)
    }
}

function checkInDate2(value) {
    console.log(value)
    check_out_date.innerHTML = formatDate(new Date(value))
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

function increase(num) {
    let people = parseInt(document.getElementById(`people${num}`).value, 10);
    let peoplemax = parseInt(document.getElementById(`people${num}`).getAttribute("max"))
    if (people > peoplemax || people == peoplemax) {
        document.getElementById(`people${num}`).value = peoplemax;
    } else {
        if (peoplePath == 0) {
            alert("ไม่สามารถเพิ่มจำนวนห้องเกินจำนวนผู้พักได้")
        } else {
            people++;
            peoplePath -= 1
            document.getElementById(`people${num}`).value = people;
        }
    }
}

function decrease(num) {
    let people = parseInt(document.getElementById(`people${num}`).value, 10);
    if (people < 0 || people == 0) {
        document.getElementById(`people${num}`).value = 0;
    } else {
        people--;
        peoplePath += 1
        document.getElementById(`people${num}`).value = people;
    }
}