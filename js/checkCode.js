function preview_image(event, pic) {
    console.log(pic)
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function delImg(code,name) {
    if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
        location.href = `mainpage_function/delImg.php?code=${code}name=${name}`
    }
}