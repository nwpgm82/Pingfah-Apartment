function searchDate(){
    let x = document.getElementById("check_in").value
    let y = document.getElementById("check_out").value
    location.assign(`index.php?check_in=${x}&check_out=${y}`)
    console.log(x)
}

function searchCode(){
    let z = document.getElementById("code").value
    location.assign(`index.php?Code=${z}`) 
}

function delDailyCost(id){
    if(confirm('คุณต้องการลบรายการชำระเงินนี้ใช่หรือไม่ ?')){
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
    let check_in = document.getElementById("check_in")
    let check_out = document.getElementById("check_out")
    let check_in_date = document.getElementById("check_in_date")
    let check_out_date = document.getElementById("check_out_date")
    if(check_in.value == "" && check_out.value == ""){
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
    }else{
        check_in_date.innerHTML = formatDate(new Date(check_in.value))
        check_out_date.innerHTML = formatDate(new Date(check_out.value))
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