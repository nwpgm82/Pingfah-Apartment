$(document).ready(function () {
    (function ($) {
        $.fn.inputFilter = function (inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));
    $("#addRoom").click(function () {
        $("#add").toggle()
    })
    $("#room_id").inputFilter(function (value) {
        return /^\d*$/.test(value); // Allow digits only, using a RegExp
    });
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
    $(".del-btn").click(function () {
        // alert(event.target.id)
    })
})