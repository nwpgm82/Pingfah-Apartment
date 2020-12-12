var electric = ["หลอดไฟ","พัดลม","แอร์","เครื่องทำน้ำอุ่น"]
var furniture = ["ตู้เสื้อผ้า","เตียงนอน","โต๊ะ","ประตู","หน้าต่าง"]
var bathroom = ["ชักโครก","สายชำระ","อ่างล้างหน้า","ก๊อกน้ำ"]
var html = ''

function categoryList(){
    var select = document.getElementById("select").value 
    var mydiv = document.getElementById('list')
    while (mydiv.firstChild) {
        mydiv.removeChild(mydiv.firstChild)
    }
    if(select == "เครื่องใช้ไฟฟ้า"){
        for(var i = 0;i< electric.length;i++){
            html = `<option value="${electric[i]}">${electric[i]}</option>`
            document.getElementById('list').innerHTML += html
        }
        console.log(select)
    }else if(select == "เฟอร์นิเจอร์"){
        for(var i = 0;i< furniture.length;i++){
            html = `<option value="${furniture[i]}">${furniture[i]}</option>`
            document.getElementById('list').innerHTML += html
        }
        console.log(select)
    }else if(select == "สุขภัณฑ์"){
        for(var i = 0;i< bathroom.length;i++){
            html = `<option value="${bathroom[i]}">${bathroom[i]}</option>`
            document.getElementById('list').innerHTML += html
        }
        console.log(select)
    }else{

    }
    console.log(html)
}

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
    $("#repairDate").val(current_day)
    $("#repair_date").html(current_dayShow)
    $("#repairDate").dateDropper({
        theme: "my-style",
        lang: "th",
        format: "Y-m-d",
        large: true,
        largeDefault: true,
        startFromMonday: false,
    })
    $("#repairDate").change(function(){
        $("#repair_date").html(formatDate(new Date($("#repairDate").val())))
    })
})