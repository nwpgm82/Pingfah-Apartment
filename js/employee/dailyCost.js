function searchDate(){
    let x = document.getElementById("check_in").value
    let y = document.getElementById("check_out").value
    location.assign(`/Pingfah/pages/admin/dailyCost/index.php?check_in=${x}&check_out=${y}`)
    console.log(x)
}

function searchCode(){
    let z = document.getElementById("code").value
    location.assign(`/Pingfah/pages/admin/dailyCost/index.php?Code=${z}`) 
}

function delDailyCost(id){
    if(confirm('คุณต้องการลบรายการชำระเงินนี้ใช่หรือไม่ ?')){
        location.href = `/Pingfah/pages/admin/dailyCost/function/delDailyCost.php?id=${id}`
    }
}