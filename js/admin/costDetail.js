$(document).ready(function () {
    $(".edit-btn").click(function () {
        $(".edit-btn").hide()
        $(".edit-option").css("display", "grid")
        let inputs = $("input")
        inputs.each(function () {
            if ($(this).attr("id") != "room_id" || $(this).attr("id") != "room_type" || $(this).attr("id") != "cost_status" || $(this).attr("id") != "pay_date") {
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
            let inputs = $("input")
            inputs.each(function () {
                if ($(this).val() == "") {
                    $(this).css("border-color", "red")
                    event.preventDefault()
                }
            })
        }
    })
    $("#cost_date").dateDropper({
        theme: "my-style",
        lang: "th",
        format: "M Y",
        lock: "to",
        hideDay: true,
        hideMonth: false,
        hideYear: false,
        startFromMonday: false,
    });
    $("#room_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#room_price").val() != "") {
            $("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat($("#elec_price").val())).toFixed(2))
        } else {
            $("#total_price").val("0.00")
            $("#room_price").css("border-color", "red")
        }
    })
    $("#cable_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#cable_price").val() != "") {
            $("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat($("#elec_price").val())).toFixed(2))
        } else {
            $("#total_price").val("0.00")
            $("#cable_price").css("border-color", "red")
        }
    })
    $("#water_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#water_price").val() != "") {
            $("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat($("#elec_price").val())).toFixed(2))
        } else {
            $("#total_price").val("0.00")
            $("#water_price").css("border-color", "red")
        }
    })
    $("#elec_price").keyup(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#elec_price").val() != "") {
            $("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat($("#elec_price").val())).toFixed(2))
        } else {
            $("#total_price").val("0.00")
            $("#elec_price").css("border-color", "red")
        }
    })
})