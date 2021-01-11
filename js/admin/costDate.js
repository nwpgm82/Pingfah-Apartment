function searchDate(){
    var x = document.getElementById("date_from").value
    var y = document.getElementById("date_to").value
    if(x != "" && y != ""){
       location.assign(`index.php?from=${x}&to=${y}`) 
    }else{
        alert("กรุณาระบุเดือนที่ต้องการค้นหา")
    }
    
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
    if(id != "all"){
       location.href = `index.php?Status=${check.id}` 
    }else{
        location.href = "index.php"
    }
    
}

function searchCheck2(from,to,id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")

    success.checked = false
    unsuccess.checked = false 
    check.checked = true
    if(id != "all"){
       location.href = `index.php?from=${from}&to=${to}&Status=${check.id}` 
    }else{
        location.href = `index.php?from=${from}&to=${to}`
    }
    
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
    let from = $("#date_from")
    let to = $("#date_to")
    function BasicDate(date) {
        let year = date.getFullYear()
        let month = date.getMonth() + 1
        if (month < 10) {
            month = "0" + month.toString()
        }
        return year + "-" + month
    }

    from.dateDropper({
        // roundtrip: true,
        theme: "my-style",
        lang: "th",
        format: "M Y",
        lock: "to",
        hideDay: true,
        hideMonth: false,
        hideYear: false,
        startFromMonday: false,
    });

    to.dateDropper({
        // roundtrip: true,
        theme: "my-style",
        lang: "th",
        format: "M Y",
        lock: "to",
        hideDay: true,
        hideMonth: false,
        hideYear: false,
        startFromMonday: false,
    });

    from.change(function () {
        to.dateDropper('set', {
            minDate: from.val()
        });
        from.css("border-color","")
        from.css("background-image","")
        $("#from_error").html("")
    })

    to.change(function () {
        to.css("border-color","")
        to.css("background-image","")
        $("#to_error").html("")
    })

    $("#searchDate").click(function(){
        if(from.val() == "" || to.val() == ""){
            if(from.val() == ""){
                from.css("border-color","red")
                from.css("background-image","url('../../../img/tool/calendar-error.png')")
                $("#from_error").html("โปรดระบุวันที่ต้องการค้นหา")
            }
            if(to.val() == ""){
                to.css("border-color","red")
                to.css("background-image","url('../../../img/tool/calendar-error.png')")
                $("#to_error").html("โปรดระบุวันที่ต้องการค้นหา")
            }
        }else{
            const search = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            const replace = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let from_toeng = from.val().split(" ")
            from_toeng[0] = search.findIndex(el => el === from_toeng[0])
            from_toeng[0] = replace[from_toeng[0]]
            from_toeng = from_toeng.join(" ")
            from_toeng = BasicDate(new Date(from_toeng))
            let to_toeng = to.val().split(" ")
            to_toeng[0] = search.findIndex(el => el === to_toeng[0])
            to_toeng[0] = replace[to_toeng[0]]
            to_toeng = to_toeng.join(" ")
            to_toeng = BasicDate(new Date(to_toeng))
            location.href = `index.php?from=${from_toeng}&to=${to_toeng}`
        }
    })
    $(".del-btn").click(function(event){
        if(confirm("คุณต้องการลบรายการชำระเงินนี้ใช่หรือไม่ ?")){
            location.href = `function/delcostData.php?cost_id=${event.target.id}`
        }
    })
})
