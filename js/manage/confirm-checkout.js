$(document).ready(function () {
    let damages = $("#damages")
    damages.keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if (damages.val() != "") {
            damages.css("border-color", "")
            $("#damage_error").html("")

        } else {
            damages.css("border-color", "red")
            $("#damage_error").html("โปรดระบุค่าเสียหาย")
        }
    });
    $("#checkout-btn").click(function (event) {
        if (damages.val() != "") {
            if (confirm("คุณต้องการเช็คเอาท์ใช่หรือไม่ ?")) {
                $("form").submit()
            } else {
                event.preventDefault()
            }
        }else{
            damages.css("border-color", "red")
            $("#damage_error").html("โปรดระบุค่าเสียหาย")
            event.preventDefault()
        }
    })
})