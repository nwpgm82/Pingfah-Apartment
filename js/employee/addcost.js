function searchroom() {
    var x = document.getElementById("room_select").value
    console.log(x)
    location.href = `addcost.php?room_select=${x}`
}

function onloadpage(){
    document.getElementById("total").innerHTML = 0
}

function calculate(id,water,elec,cable,fines,price){
    var water_c = document.getElementById("water_count").value
    var elec_c = document.getElementById("elec_count").value
    if(water_c || elec_c || water_c && elec_c != ""){
    total = (water*water_c) + (elec_c*elec) + cable + price
    console.log(total)
    document.getElementById("total").innerHTML = total
    }else{
        alert("กรอกค่าให้ครบ")
    }
}