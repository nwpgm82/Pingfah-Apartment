$(document).ready(function () {
    let room_select = []
    $(".air").click(function (event) {
        if (room_select.indexOf(event.target.id) == -1) {
            if (parseInt($("#air_count").html()) != 0) {
                room_select.push(event.target.id)
                $("#air_count").html(parseInt($("#air_count").html()) - 1)
                $(`#${event.target.id}`).css("background-color", "grey")
                $("#room_select").html(room_select.join(", "))
            }
        } else {
            room_select.splice(room_select.indexOf(event.target.id), 1)
            $("#air_count").html(parseInt($("#air_count").html()) + 1)
            $(`#${event.target.id}`).css("background-color", "")
            $("#room_select").html(room_select.join(", "))
        }
    })
    $(".fan").click(function (event) {
        if (room_select.indexOf(event.target.id) == -1) {
            if (parseInt($("#fan_count").html()) != 0) {
                room_select.push(event.target.id)
                $("#fan_count").html(parseInt($("#fan_count").html()) - 1)
                $(`#${event.target.id}`).css("background-color", "grey")
                $("#room_select").html(room_select.join(", "))
            }
        } else {
            room_select.splice(room_select.indexOf(event.target.id), 1)
            $("#fan_count").html(parseInt($("#fan_count").html()) + 1)
            $(`#${event.target.id}`).css("background-color", "")
            $("#room_select").html(room_select.join(", "))
        }
    })
    $("#confirmRent").click(function(){
        if(confirm("คุณต้องการยืนยันการจองพักใช่หรือไม่ ?")){
            if(room_select.length != 0 && parseInt($("#air_count").html()) == 0 && parseInt($("#fan_count").html()) == 0){
                let url_string = window.location.href
                let url = new URL(url_string)
                let daily_id = url.searchParams.get("daily_id")
                let str = JSON.stringify(room_select)
                location.href = `function/addSelectRoom.php?daily_id=${daily_id}&room_select=${str}`
            }else{
                alert("โปรดเลือกห้องให้ครบตามจำนวน")
            }
        }
    })
})