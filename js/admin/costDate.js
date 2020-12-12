function searchDate(){
    var x = document.getElementById("date_from").value
    var y = document.getElementById("date_to").value
    location.assign(`index.php?from=${x}&to=${y}`)
}

function confirmStatus(room,date){
    if(confirm(`ยืนยันการชำระเงินห้อง ${room}`)){
        location.href = `function/confirmStatus.php?room_id=${room}&date=${date}`
    }
}

function searchCheck(id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")

    success.checked = false
    unsuccess.checked = false 
    check.checked = true
    location.href = `index.php?Status=${check.id}`
}

function searchCheck2(from,to,id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")

    success.checked = false
    unsuccess.checked = false 
    check.checked = true
    location.href = `index.php?from=${from}&to=${to}&Status=${check.id}`
}


function unCheckAll(){
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")
    success.checked = false
    unsuccess.checked = false
    location.href = "index.php"
}

function delcost(room,date){
    if(confirm("คุณต้องการลบรายการชำระเงินนี้ใช่หรือไม่ ?")){
        location.href = `function/delcostData.php?room_id=${room}&date=${date}`
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
    return monthNames[monthIndex] + ' ' + year;
}

function formatDate2(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        // Months use 0 index.
        return date.getMonth() + 1 + '/1/' + date.getFullYear();
    }
}

$(document).ready(function () {
    let from = document.getElementById("date_from")
    let to = document.getElementById("date_to")
    let from_date = document.getElementById("from_date")
    let to_date = document.getElementById("to_date")
    if(from.value == "" && to.value == ""){
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
        let current_dayShow = today_monthNames[today_month - 1] + ' ' + today_year
        let next_dayShow =  today_monthNames[tomorrow_month - 1] + ' ' + tomorrow_year
        let current_day = today_year + '-' + today_month
    
        let next_day = tomorrow_year + '-' + tomorrow_month
        from.value = current_day
        // check_in.setAttribute("min", current_day)
        to.value = next_day
        // check_out.setAttribute("min", check_out.value)
        from_date.innerHTML = current_dayShow
        to_date.innerHTML = next_dayShow
    }else{
        from_date.innerHTML = formatDate(new Date(from.value))
        to_date.innerHTML = formatDate(new Date(to.value))
    }
    
    $('#date_from').dateDropper({
        // roundtrip: true,
        theme: "my-style",
        lang: "th",
        format: "Y-m",
        hideDay: true,
        hideMonth: false,
        hideYear: false,
        startFromMonday: false,
    });

    $('#date_to').dateDropper({
        // roundtrip: true,
        theme: "my-style",
        lang: "th",
        format: "Y-m",
        hideDay: true,
        hideMonth: false,
        hideYear: false,
        startFromMonday: false,
        minDate: formatDate2($('#date_from').val())
    });

    $('#date_from').change(function () {
        $('#from_date').html(formatDate(new Date($('#date_from').val())))
        $('#date_to').dateDropper('set', {
            minDate: formatDate2($('#date_from').val())
        });
    })

    $('#date_to').change(function () {
        $('#to_date').html(formatDate(new Date($('#date_to').val())))
    })
})
