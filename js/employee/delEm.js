function delEm(id,user){
    if(confirm('คุณต้องการลบพนักงานออกใช่หรือไม่ ?')){
        location.href = `function/delEm.php?ID=${id}&&User=${user}`
    }
}