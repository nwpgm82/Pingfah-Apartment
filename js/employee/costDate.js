// function currentDate(){
//     var d = new Date()
//     var day = String(d.getDate())
//     var month = String(d.getMonth()+1)
//     var year = String(d.getFullYear())
//     d = month + '/' + day + '/' + year
//     console.log(d)
//     document.getElementById("cost_date").value = d
// }

function searchDate(v){
    var x = document.getElementById("cost_date").value
    location.assign(`index.php?Date=${v}`)
    console.log(x)
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

function searchCheck2(date,id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")

    success.checked = false
    unsuccess.checked = false 
    check.checked = true
    location.href = `index.php?Date=${date}&Status=${check.id}`
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