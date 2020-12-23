$(document).ready(function () {
    (function ($) {
        $.fn.inputFilter = function (inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value
                    this.oldSelectionStart = this.selectionStart
                    this.oldSelectionEnd = this.selectionEnd
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = ""
                }
            })
        }
    }(jQuery));
    $("#addRoom").click(function () {
        $("#add").toggle()
    })
    $("#room_id").inputFilter(function (value) {
        return /^\d*$/.test(value); // Allow digits only, using a RegExp
    });
    $("#room_id").keyup(function(){
        if($("#room_id").val().length >= 1){
            $("#room_id_check").html("")
            $("#room_id").css("border-color","")
        }else{
            $("#room_id_check").html("กรุณากรอกเลขห้อง")
            $("#room_id").css("border-color","red")
            $("input#room_id").addClass("input_placeholder_error")
        }
    })
    $("button[type=submit]").click(function (event) {
        if ($("#room_id").val().length < 1) {
            $("#room_id_check").html("กรุณากรอกเลขห้อง")
            $("#room_id").css("border-color","red")
            $("input#room_id").addClass("input_placeholder_error")
            event.preventDefault()
        }
    })
    $("#all").click(function () {
        location.href = "index.php"
    })
    $("#avai_all").click(function () {
        location.href = "index.php?Status=avai_all"
    })
    $("#unavai_all").click(function () {
        location.href = "index.php?Status=unavai_all"
    })
    $("#avai_daily").click(function () {
        location.href = "index.php?Status=avai_daily"
    })
    $("#unavai_daily").click(function () {
        location.href = "index.php?Status=unavai_daily"
    })
    $("#avai_month").click(function () {
        location.href = "index.php?Status=avai_month"
    })
    $("#unavai_month").click(function () {
        location.href = "index.php?Status=unavai_month"
    })
    $(".del-btn").click(function (event) {
        let room_id = event.target.id
        if(confirm(`คุณต้องการลบห้อง ${room_id} ใช่หรือไม่ ? `)){
            location.href = `function/delRoom.php?ID=${room_id}`
        }
    })
    $("#all_search").click(function(){
        let from = $("#date_from").val()
        let to = $("#date_to").val()
        if(from != "" && to != ""){
            location.href = `index.php?from=${from}&to=${to}`
        }else{
            location.href = "index.php"
        }
    })
    $("#daily_search").click(function(){
        let from = $("#date_from").val()
        let to = $("#date_to").val()
        if(from != "" && to != ""){
            location.href = `index.php?from=${from}&to=${to}&style=daily`
        }else{
            location.href = "index.php"
        }
    })
})