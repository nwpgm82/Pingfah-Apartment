$(document).ready(function () {
    let url_string = window.location.href;
    let url = new URL(url_string);
    let room_type = url.searchParams.get("type");

    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    function isImage(filename) {
        var ext = getExtension(filename);
        switch (ext.toLowerCase()) {
            case 'jpg':
                // case 'pdf':
            case 'png':
                //etc
                return true;
        }
        return false;
    }
    $('#file').change(function () {
        let formdata = new FormData();
        let files = $("#file")[0].files[0];
        let file_size = $("#file")[0].files[0].size
        formdata.append("file", files);
        if (isImage($("#file").val()) != false) {
            if (file_size < 5242880) {
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
            } else {
                alert("ขนาดรูปภาพใหญ่เกินไป (ไม่เกิน 5 MB)")
                $("#file").val("")
            }
        } else {
            alert("รองรับไฟล์ประเภท jpg, png ขนาดไม่เกิน 5 MB เท่านั้น")
            $("#file").val("")
        }
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