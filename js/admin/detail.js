function preview_image(event, pic) {
    console.log(pic)
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function delImg(type, gal_id, gal_name) {
    if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
        location.href = `function/delData.php?type=${type}&gal_id=${gal_id}&gal_name=${gal_name}`
    }
}

function edit() {
    let input = document.getElementsByTagName("input")
    for (let i = 0; i < (input.length - 1); i++) {
        input[i].disabled = false
    }
    // for(var i = 0; i < del_btn.length; i++) {
    //     del_btn[i].style.display = "block";
    // }
    // document.getElementById("file").disabled = false
    document.getElementById("edit").style.display = "none"
    document.getElementById("accept").style.display = "flex"
}

function cancelEdit() {
    let input = document.getElementsByTagName("input")
    for (let i = 0; i < (input.length - 1); i++) {
        input[i].disabled = true
    }
    // for(var i = 0; i < del_btn.length; i++) {
    //     del_btn[i].style.display = "none";
    // }
    // document.getElementById("file").disabled = true
    document.getElementById("edit").style.display = "flex"
    document.getElementById("accept").style.display = "none"
}
$(document).ready(function () {
    let url_string = window.location.href;
    let url = new URL(url_string);
    let room_type = url.searchParams.get("type");
    $('#file').change(function () {
        let formdata = new FormData();
        let files = $("#file")[0].files[0];
        formdata.append("file", files);
        $.ajax({
            url: `function/addImage.php?type=${room_type}`,
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function () {
                document.location.reload()
            }
        });
    });
    $(document).on("click", ".del-btn", function (event) {
        if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
            // console.log(event.target.name)
            let img_name = event.target.name
            $.ajax({
                url: `function/delImage.php?type=${room_type}`,
                type: 'post',
                data: {
                    img_name: img_name,
                    request: 2
                },
                success: function () {
                    document.location.reload()
                }
            });
        }
    })
    $(".edit-btn").click(function () {
        let inputs = $("input")
        inputs.each(function () {
            $(this).prop("disabled", false)
        })
        $("#edit").hide()
        $("#accept").css("display", "flex")
        $("#accept").css("column-gap", "8px")
    })
    $(".cancel-btn").click(function () {
        let inputs = $("input")
        inputs.each(function () {
            $(this).prop("disabled", true)
        })
        $("#edit").css("display", "flex")
        $("#accept").hide()
    })
})