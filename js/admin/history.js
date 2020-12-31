$(document).ready(function () {
    let from = $("#date_from")
    let to = $("#date_to")

    function BasicDate(date) {
        let year = date.getFullYear()
        let month = date.getMonth() + 1
        let day = date.getDate()
        if (day < 10) {
            day = "0" + day.toString()
        }
        if (month < 10) {
            month = "0" + month.toString()
        }
        return year + "-" + month + "-" + day
    }
    $(".roundtrip-input").dateDropper({
        roundtrip: true,
        theme: "my-style",
        lang: "th",
        lock: "to",
        format: "d M Y",
        startFromMonday: false,
    })
    $("#searchHistory").click(function () {
        if (from.val() != "" && to.val() != "") {
            const search = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            const replace = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let from_toeng = from.val().split(" ")
            from_toeng[1] = search.findIndex(el => el === from_toeng[1])
            from_toeng[1] = replace[from_toeng[1]]
            from_toeng = from_toeng.join(" ")
            from_toeng = BasicDate(new Date(from_toeng))
            let to_toeng = to.val().split(" ")
            to_toeng[1] = search.findIndex(el => el === to_toeng[1])
            to_toeng[1] = replace[to_toeng[1]]
            to_toeng = to_toeng.join(" ")
            to_toeng = BasicDate(new Date(to_toeng))
            location.href = `roomHistory.php?from=${from_toeng}&to=${to_toeng}`
        } else {
            $("#from_error").html("โปรดระบุวันที่ที่ต้องการค้นหา")
            from.css("border-color", "red")
            from.css("background-image", "url('../../../img/tool/calendar-error.png')")
            $("#to_error").html("โปรดระบุวันที่ที่ต้องการค้นหา")
            to.css("border-color", "red")
            to.css("background-image", "url('../../../img/tool/calendar-error.png')")
        }
    })
    from.change(function () {
        if (from.val() != "") {
            $("#from_error").html("")
            from.css("border-color", "")
            from.css("background-image", "")
        } else {
            $("#from_error").html("โปรดระบุวันที่ที่ต้องการค้นหา")
            from.css("border-color", "red")
            from.css("background-image", "url('../../../img/tool/calendar-error.png')")
        }
    })
    to.change(function () {
        if (to.val() != "") {
            $("#to_error").html("")
            to.css("border-color", "")
            to.css("background-image", "")
        }else{
            $("#to_error").html("โปรดระบุวันที่ที่ต้องการค้นหา")
            to.css("border-color", "red")
            to.css("background-image", "url('../../../img/tool/calendar-error.png')")
        }
    })
    $("#all").change(function(){
        if(from.val() != "" && to.val() != ""){
            const search = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            const replace = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let from_toeng = from.val().split(" ")
            from_toeng[1] = search.findIndex(el => el === from_toeng[1])
            from_toeng[1] = replace[from_toeng[1]]
            from_toeng = from_toeng.join(" ")
            from_toeng = BasicDate(new Date(from_toeng))
            let to_toeng = to.val().split(" ")
            to_toeng[1] = search.findIndex(el => el === to_toeng[1])
            to_toeng[1] = replace[to_toeng[1]]
            to_toeng = to_toeng.join(" ")
            to_toeng = BasicDate(new Date(to_toeng))
            location.href = `roomHistory.php?from=${from_toeng}&to=${to_toeng}`
        }else{
            location.href = "roomHistory.php"
        }
    })
    $("#daily_check").change(function(){
        if(from.val() != "" && to.val() != ""){
            const search = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            const replace = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let from_toeng = from.val().split(" ")
            from_toeng[1] = search.findIndex(el => el === from_toeng[1])
            from_toeng[1] = replace[from_toeng[1]]
            from_toeng = from_toeng.join(" ")
            from_toeng = BasicDate(new Date(from_toeng))
            let to_toeng = to.val().split(" ")
            to_toeng[1] = search.findIndex(el => el === to_toeng[1])
            to_toeng[1] = replace[to_toeng[1]]
            to_toeng = to_toeng.join(" ")
            to_toeng = BasicDate(new Date(to_toeng))
            location.href = `roomHistory.php?from=${from_toeng}&to=${to_toeng}&style=daily`
        }else{
            location.href = `roomHistory.php?style=daily`
        }
    })
    $("#month_check").change(function(){
        if(from.val() != "" && to.val() != ""){
            const search = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            const replace = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let from_toeng = from.val().split(" ")
            from_toeng[1] = search.findIndex(el => el === from_toeng[1])
            from_toeng[1] = replace[from_toeng[1]]
            from_toeng = from_toeng.join(" ")
            from_toeng = BasicDate(new Date(from_toeng))
            let to_toeng = to.val().split(" ")
            to_toeng[1] = search.findIndex(el => el === to_toeng[1])
            to_toeng[1] = replace[to_toeng[1]]
            to_toeng = to_toeng.join(" ")
            to_toeng = BasicDate(new Date(to_toeng))
            location.href = `roomHistory.php?from=${from_toeng}&to=${to_toeng}&style=month`
        }else{
            location.href = `roomHistory.php?style=month`
        }
    })
})