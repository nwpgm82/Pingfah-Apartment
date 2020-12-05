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
}

// function checkInDate(value) {
//     console.log(value)
//     check_in_date.innerHTML = formatDate(new Date(value))
//     check_out.setAttribute("min", check_in.value)
//     if (new Date(value).getTime() >= new Date(check_out.value).getTime()) {
//         let nDate = new Date(check_in.value)
//         nDate.setDate(nDate.getDate() + 1)
//         let nDate_date = nDate.getDate()
//         let nDate_month = nDate.getMonth() + 1
//         if (nDate_date < 10) {
//             nDate_date = "0" + nDate_date.toString()
//         }
//         if (nDate_month < 10) {
//             nDate_month = "0" + nDate_month.toString()
//         }
//         check_out.value = nDate.getFullYear() + "-" + nDate_month + "-" + nDate_date
//         check_out_date.innerHTML = formatDate(new Date(check_out.value))
//         check_out.setAttribute("min", check_out.value)
//     }
// }

// function checkInDate2(value) {
//     console.log(value)
//     check_out_date.innerHTML = formatDate(new Date(value))
// }

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

function checkform(){
    let people_check = Math.ceil(parseInt(document.getElementById("people").value)/2)
    let room_check = parseInt(document.getElementById("people1").value) + parseInt(document.getElementById("people2").value)
    if(people_check > room_check){
        alert("กรุณาเลือกห้องพักให้เพียงพอกับผู้พัก")
        return false
    }
}

$(document).ready(function () {
    $('#check_in').dateDropper({
        theme: "my-style",
        large: true,
        largeDefault: true,
        format: "Y-m-d",
        lang: "th",
        lock: "from",
        startFromMonday: false,
        defaultDate: formatDate2($('#check_in').val())
    });
    $('#check_out').dateDropper({
        theme: "my-style",
        large: true,
        largeDefault: true,
        format: "Y-m-d",
        lang: "th",
        lock: "from",
        startFromMonday: false,
        defaultDate: formatDate2($('#check_out').val())
    });
    let nDate1 = new Date($("#check_in").val())
    nDate1.setDate(nDate1.getDate() + 1)
    let nDate1_date = nDate1.getDate()
    let nDate1_month = nDate1.getMonth() + 1
    if (nDate1_date < 10) {
        nDate1_date = "0" + nDate1_date.toString()
    }
    if (nDate1_month < 10) {
        nDate1_month = "0" + nDat1e_month.toString()
    }
    let check_in_inc = nDate1.getFullYear() + "-" + nDate1_month + "-" + nDate1_date
    $('#check_out').dateDropper('set', {
        minDate: formatDate2(check_in_inc)
    });
    $('#check_in').change(function () {
        console.log("check in :", $('#check_in').val())
        $('#check_in_date').html(formatDate(new Date($('#check_in').val())))
        if (new Date($("#check_in").val()) >= new Date($("#check_out").val())) {
            let nDate2 = new Date($("#check_in").val())
            nDate2.setDate(nDate2.getDate() + 1)
            let nDate2_date = nDate2.getDate()
            let nDate2_month = nDate2.getMonth() + 1
            if (nDate2_date < 10) {
                nDate2_date = "0" + nDate2_date.toString()
            }
            if (nDate2_month < 10) {
                nDate2_month = "0" + nDate2_month.toString()
            }
            $("#check_out").val(nDate2.getFullYear() + "-" + nDate2_month + "-" + nDate2_date)
            $("#check_out_date").html(formatDate(new Date($("#check_out").val())))
            $('#check_out').dateDropper('set', {
                defaultDate: formatDate2($('#check_out').val()),
                minDate: formatDate2($('#check_out').val())
            });
        } else {
            let nDate3 = new Date($("#check_in").val())
            nDate3.setDate(nDate3.getDate() + 1)
            let nDate3_date = nDate3.getDate()
            let nDate3_month = nDate3.getMonth() + 1
            if (nDate3_date < 10) {
                nDate3_date = "0" + nDate3_date.toString()
            }
            if (nDate3_month < 10) {
                nDate3_month = "0" + nDate3_month.toString()
            }
            let check_in_inc = nDate3.getFullYear() + "-" + nDate3_month + "-" + nDate3_date
            $('#check_out_date').html(formatDate(new Date($('#check_out').val())))
            $('#check_out').dateDropper('set', {
                minDate: formatDate2(check_in_inc)
            });
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