$(document).ready(function () {
    $("#submitForm").on("change", function () {
        var url_string = window.location.href
        var url = new URL(url_string);
        var c = url.searchParams.get("dailycost_id");
        var formData = new FormData(this)
        $.ajax({
            url: `function/addImage.php?dailycost_id=${c}`,
            type: "POST",
            cache: false,
            contentType: false, // you can also use multipart/form-data replace of false
            processData: false,
            data: formData,
            success: function (response) {
                // alert(response)
                // alert("Image uploaded Successfully");
                location.href = `dailyCostDetail.php?dailycost_id=${c}`
            }
        });
    })
})

function delImg(id,name){
    if(confirm("คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?")){
        location.href = `function/delImage.php?id=${id}&name=${name}`
    }
}