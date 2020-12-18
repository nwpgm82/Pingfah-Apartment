function searchDate(){
    var x = document.getElementById("date_from").value
    var y = document.getElementById("date_to").value
    if(x != "" && y != ""){
       location.assign(`repairReport.php?from=${x}&to=${y}`) 
    }else{
        alert("กรุณากรอกวันที่ที่ต้องการค้นหา")
    }
    
}

function unCheckAll(){
    location.href = "repairReport.php"
}

function repair_del(room,app,cate,date){
    if(confirm('คุณต้องการลบรายการแจ้งซ่อมนี้ใช่หรือไม่ ?')){
        location.href = `function/repairDel.php?room_id=${room}&repairappliance=${app}&repaircategory=${cate}&repairdate=${date}`
    }
}

///sort table////
const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
    v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
    )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

// do the work...
document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
    const table = th.closest('table');
    Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
        .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
        .forEach(tr => table.appendChild(tr) );
})));

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
    let date_from = $("#date_from")
    let date_to = $("#date_to")
    let from_date = $("#from_date")
    let to_date = $("#to_date")
    if(date_from.val() != "" && date_to.val() != ""){
        from_date.html(formatDate(new Date(date_from.val())))
        to_date.html(formatDate(new Date(date_to.val())))
    }
    
    $('.roundtrip-input').dateDropper({
        roundtrip: true,
        theme: "my-style",
        lang: "th",
        format: "Y-m-d",
        startFromMonday: false,
    });

    $('#date_from').change(function () {
        $('#from_date').html(formatDate(new Date($('#date_from').val())))
    })

    $('#date_to').change(function () {
        $('#to_date').html(formatDate(new Date($('#date_to').val())))
    })
})