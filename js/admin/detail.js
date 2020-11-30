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
    for(let i = 0 ; i < input.length ; i++){
        input[i].disabled = false
    }
    for(let j = 1 ; j <= 6; j++){
        var del_img = document.getElementById(`delimg-btn${j}`)
        if(del_img){
            del_img.style.display = "block"
        }
    }
    document.getElementById("textarea").disabled = false
    document.getElementById("edit").style.display = "none"
    document.getElementById("accept").style.display = "flex"
}

function cancelEdit(){
    let input = document.getElementsByTagName("input")
    for(let i = 0 ; i < input.length ; i++){
        input[i].disabled = true
    }
    for(let j = 1 ; j <= 6; j++){
        var del_img = document.getElementById(`delimg-btn${j}`)
        if(del_img){
            del_img.style.display = "none"
        }
    }
    document.getElementById("textarea").disabled = true
    document.getElementById("edit").style.display = "flex"
    document.getElementById("accept").style.display = "none"
}

