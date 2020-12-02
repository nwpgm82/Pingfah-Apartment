function searchDate(v) {
    var x = document.getElementById("repair_date").value
    location.assign(`index.php?Date=${v}`)
    console.log(x)
}

function searchCheck(id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var inprogress = document.getElementById("inprogress")
    var pending = document.getElementById("pending")

    success.checked = false
    inprogress.checked = false
    pending.checked = false 
    check.checked = true
    location.href = `index.php?Status=${check.id}`
}

function searchCheck2(date,id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var inprogress = document.getElementById("inprogress")
    var pending = document.getElementById("pending")

    success.checked = false
    inprogress.checked = false
    pending.checked = false 
    check.checked = true
    location.href = `index.php?Date=${date}&Status=${check.id}`
}


function unCheckAll(){
    var success = document.getElementById("success")
    var inprogress = document.getElementById("inprogress")
    var pending = document.getElementById("pending")
    success.checked = false
    inprogress.checked = false
    pending.checked = false
    location.href = "index.php"
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