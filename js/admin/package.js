function searchDate(v) {
    var x = document.getElementById("package_date").value
    location.assign(`index.php?Date=${v}`)
    console.log(x)
}

function addPackage(){
    var add = document.getElementById("addPackage")
    if(add.style.display == ''){
        add.style.display = 'block'
    }else{
        add.style.display = ''
    }
}

function searchCheck(id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")

    success.checked = false
    unsuccess.checked = false 
    check.checked = true
    location.href = `index.php?Status=${check.id}`
}

function searchCheck2(date,id){
    var check = document.getElementById(id)
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")

    success.checked = false
    unsuccess.checked = false 
    check.checked = true
    location.href = `index.php?Date=${date}&Status=${check.id}`
}


function unCheckAll(){
    var success = document.getElementById("success")
    var unsuccess = document.getElementById("unsuccess")
    success.checked = false
    unsuccess.checked = false
    location.href = "index.php"
}