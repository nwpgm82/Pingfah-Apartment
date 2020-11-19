function delEm(id,user){
    if(confirm('คุณต้องการลบพนักงานออกใช่หรือไม่ ?')){
        location.href = `/Pingfah/pages/admin/employee/function/delEm.php?ID=${id}&&User=${user}`
    }
}