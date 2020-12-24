$(document).ready(function () {
    $("#add-btn").click(function () {
        $(".new_customer").remove()
        $("#form-box").show()
    })
    $("#come_date").dateDropper({
        format: "Y-m-d",
        lang: "th",
        theme: "my-style",
        large: true,
        largeDefault: true,
        largeOnly: true,
        lock: "to"
    });
})