$(document).ready(function () {
    let room = $("#room_price").val()
    let cable = $("#cable_price").val()
    let water = $("#water_price").val()
    let elec = $("#elec_price").val()
    $(".edit-btn").click(function () {
        $(".edit-btn").hide()
        $(".edit-option").css("display", "grid")
        let inputs = $("input")
        inputs.each(function () {
            if ($(this).attr("id") != "room_id" && $(this).attr("id") != "room_type" && $(this).attr("id") != "cost_date" && $(this).attr("id") != "cost_status" && $(this).attr("id") != "pay_date") {
                $(this).prop("disabled", false)
                if ($(this).attr("id") == "total_price") {
                    $(this).prop("readonly", true)
                }
            }
        })
    })
    $("#cancel-edit").click(function () {
        $(".edit-btn").show()
        $(".edit-option").hide()
        let inputs = $("input")
        inputs.each(function () {
            $(this).prop("disabled", true)
        })
    })
    $("#accept-edit").click(function (event) {
        if ($("#room_price").val() == "" || $("#cable_price").val() == "" || $("#water_price").val() == "" || $("#elec_price").val() == "") {
            event.preventDefault()
        }
    })
    $("#room_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#room_price").val() != "") {
            room = $("#room_price").val()
            $("#room_price").css("border-color","")
            $("#room_error").html("")
        } else {
            room = 0
            $("#room_price").css("border-color", "red")
            $("#room_error").html("โปรดระบุค่าห้องพัก")
        }
        $("#total_price").val((parseFloat(room) + parseFloat(cable) + parseFloat(water) + parseFloat(elec)).toFixed(2))
    })
    $("#cable_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#cable_price").val() != "") {
            cable = $("#cable_price").val()
            $("#cable_price").css("border-color", "")
            $("#cable_error").html("")
        } else {
            cable = 0
            $("#cable_price").css("border-color", "red")
            $("#cable_error").html("โปรดระบุค่าเคเบิล")
        }
        $("#total_price").val((parseFloat(room) + parseFloat(cable) + parseFloat(water) + parseFloat(elec)).toFixed(2))
    })
    $("#water_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#water_price").val() != "") {
            water = $("#water_price").val()
            $("#water_price").css("border-color", "")
            $("#water_error").html("")
        } else {
            water = 0
            $("#water_price").css("border-color", "red")
            $("#water_error").html("โปรดระบุค่าน้ำ")
        }
        $("#total_price").val((parseFloat(room) + parseFloat(cable) + parseFloat(water) + parseFloat(elec)).toFixed(2))
    })
    $("#elec_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#elec_price").val() != "") {
            elec = $("#elec_price").val()
            $("#elec_price").css("border-color", "")
            $("#elec_error").html("")
        } else {
            elec = 0
            $("#elec_price").css("border-color", "red")
            $("#elec_error").html("โปรดระบุค่าไฟ")
        }
        $("#total_price").val((parseFloat(room) + parseFloat(cable) + parseFloat(water) + parseFloat(elec)).toFixed(2))
    })
})