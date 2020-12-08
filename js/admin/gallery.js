$(document).ready(function () {
    $("#submitForm").on("change", function () {
        var formData = new FormData(this)
        $.ajax({
            url: "function/addImage.php",
            type: "POST",
            cache: false,
            contentType: false, // you can also use multipart/form-data replace of false
            processData: false,
            data: formData,
            success: function (response) {
                // alert("Image uploaded Successfully");
                location.href = "index.php"
            }
        });
    })
})


function delImg(id,name){
    if(confirm("คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?")){
        location.href = `function/delImage.php?id=${id}&name=${name}`
    }
}