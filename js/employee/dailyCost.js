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