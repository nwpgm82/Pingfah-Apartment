function preview_image(event, pic) {
    console.log(pic)
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function delImg(type,pictype){
    if(confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')){
        location.href = `function/delData.php?type=${type}&&pic=${pictype}`
    }
}

function edit(){
    let input = document.getElementsByTagName("input")
    var del_btn = document.getElementsByClassName("del-btn")
    for(let i = 0 ; i < input.length ; i++){
        input[i].disabled = false
    }
    for(var i = 0; i < del_btn.length; i++) {
        del_btn[i].style.display = "block";
    }
    document.getElementById("edit").style.display = "none"
    document.getElementById("accept").style.display = "flex"
}

function cancelEdit(){
    let input = document.getElementsByTagName("input")
    var del_btn = document.getElementsByClassName("del-btn")
    for(let i = 0 ; i < input.length ; i++){
        input[i].disabled = true
    }
    for(var i = 0; i < del_btn.length; i++) {
        del_btn[i].style.display = "none";
    }
    document.getElementById("edit").style.display = "flex"
    document.getElementById("accept").style.display = "none"
}

