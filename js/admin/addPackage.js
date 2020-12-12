$(document).ready(function(){
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
    // function formatDate2(inputDate) {
    //     var date = new Date(inputDate);
    //     if (!isNaN(date.getTime())) {
    //         // Months use 0 index.
    //         return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
    //     }
    // }
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
    let current_dayShow = today_day + ' ' + today_monthNames[today_month - 1] + ' ' + today_year
    if (today_day < 10) {
        today_day = '0' + today_day.toString()
    }
    if (today_month < 10) {
        today_month = '0' + today_month.toString()
    }
    let current_day = today_year + '-' + today_month + '-' + today_day
    $("#arrived").val(current_day)
    $("#arrived_date").html(current_dayShow)
    $("#arrived").dateDropper({
        theme: "my-style",
        lang: "th",
        format: "Y-m-d",
        large: true,
        largeDefault: true,
        startFromMonday: false,
    })
    $("#arrived").change(function(){
        $("#arrived_date").html(formatDate(new Date($("#arrived").val())))
    })
})