function searchDate(v){
    location.assign(`/Pingfah/pages/admin/appeal/index.php?Date=${v}`)
}

function del(id){
    if(confirm("คุณต้องการลบรายการร้องเรียนนี้ใช่หรือไม่ ? ")){
        location.href = `function/delAppeal.php?appeal_id=${id}`
    }
}