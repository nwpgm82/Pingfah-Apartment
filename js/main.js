function bannerload() {
    var banner = document.getElementById("banner")
    banner.style.transform = "scale(1)"
    banner.style.opacity = 1
}

function checkRoom() {
    let check_in = document.getElementById("check_in").value
    let check_out = document.getElementById("check_out").value
    if (check_in && check_out != "") {
        location.href = `../pages/checkRoom.php?check_in=${check_in}&check_out=${check_out}`
    }else{
        alert("กรุณากรอกวันที่ค้นหาให้ครบ");
    }
}