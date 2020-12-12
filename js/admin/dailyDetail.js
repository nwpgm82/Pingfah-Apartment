function delImg(id,name){
    if(confirm("คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ? ")){
        location.href = `function/delImage.php?daily_id=${id}&name=${name}`
    }
}