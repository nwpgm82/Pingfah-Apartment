var profile = document.getElementById("profile_img")
var pic_idcard = document.getElementById("pic_idcard")
var pic_home = document.getElementById("pic_home")

function edit() {
    if(profile){
        profile.disabled = false
    }
    document.getElementById("title_name").disabled = false
    document.getElementById("firstname").disabled = false
    document.getElementById("lastname").disabled = false
    document.getElementById("nickname").disabled = false
    document.getElementById("position").disabled = false
    document.getElementById("id_card").disabled = false
    document.getElementById("tel").disabled = false
    document.getElementById("email").disabled = false
    document.getElementById("id_line").disabled = false
    document.getElementById("birthday").disabled = false
    document.getElementById("age").disabled = false
    document.getElementById("race").disabled = false
    document.getElementById("nationality").disabled = false
    document.getElementById("address").disabled = false
    // document.getElementById("username").disabled = false
    document.getElementById("del1").style.display = "block"
    document.getElementById("del2").style.display = "block"
    document.getElementById("del3").style.display = "block"
    if (pic_idcard) {
        pic_idcard.disabled = false
    }
    if (pic_home) {
        pic_home.disabled = false
    }
    document.getElementById("edit_data").style.display = "none"
    document.getElementById("option").style.display = "block"
}

function cancel_edit() {
    if(profile){
        profile.disabled = true
    }
    document.getElementById("title_name").disabled = true
    document.getElementById("firstname").disabled = true
    document.getElementById("lastname").disabled = true
    document.getElementById("nickname").disabled = true
    document.getElementById("position").disabled = true
    document.getElementById("id_card").disabled = true
    document.getElementById("tel").disabled = true
    document.getElementById("email").disabled = true
    document.getElementById("id_line").disabled = true
    document.getElementById("birthday").disabled = true
    document.getElementById("age").disabled = true
    document.getElementById("race").disabled = true
    document.getElementById("nationality").disabled = true
    document.getElementById("address").disabled = true
    // document.getElementById("username").disabled = true
    document.getElementById("del1").style.display = "none"
    document.getElementById("del2").style.display = "none"
    document.getElementById("del3").style.display = "none"
    if (pic_idcard) {
        pic_idcard.disabled = true
    }
    if (pic_home) {
        pic_home.disabled = true
    }
    document.getElementById("edit_data").style.display = "block"
    document.getElementById("option").style.display = "none"
}

function delImg(user, pictype) {
    if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
        location.href = `function/delImg.php?username=${user}&&pic=${pictype}`
    }
}

function preview_image(event, pic) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}