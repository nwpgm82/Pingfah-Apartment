function searchDate(){
    let x = document.getElementById("code").value
    location.href = `checkCode.php?code=${x}`
}

function preview_image(event, pic) {
    console.log(pic)
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
    document.querySelector("button[type=submit]").disabled = false;
}

function delImg(id,name) {
    if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
        location.href = `mainpage_function/delImage.php?daily_id=${id}&name=${name}`
    }
}

function cancel_daily(id){
    if(confirm("คุณต้องการยกเลิกการจองใช่หรือไม่ ?")){
        location.href = `mainpage_function/cancelDaily.php?daily_id=${id}`
    }
}