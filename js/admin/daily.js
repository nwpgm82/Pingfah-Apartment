function searchDate(){
    let x = document.getElementById("check_in").value
    let y = document.getElementById("check_out").value
    location.assign(`/Pingfah/pages/admin/daily/index.php?check_in=${x}&check_out=${y}`)
    console.log(x)
}

function searchCode(){
    let z = document.getElementById("code").value
    location.assign(`/Pingfah/pages/admin/daily/index.php?Code=${z}`) 
}

function selectRoom(num){
    let btn = document.getElementById(`btn${num}`)
    let room = document.getElementById(`select${num}`)
    btn.style.display = "none"
    room.style.display = "block"
}

function confirmRoom(code,num){
    let room_select = document.getElementById(`room_select${num}`).value
    if(confirm(`คุณต้องการเลือกห้องนี้ ${room_select} ใช่หรือไม่ ? `)){
        location.href = `/Pingfah/pages/admin/daily/function/addDailyData.php?Code=${code}&room_select=${room_select}`
    } 
}