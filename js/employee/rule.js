var btn = false
var text = document.getElementById("rule_detail")
var edit = document.getElementById("edit_btn")
var accept = document.getElementById("accept_btn")

function edit_rule(){
    if(btn == false){
        edit.style.display = "none"
        accept.style.display = "block"
        text.disabled = false
        btn = true
    }else{
        edit.style.display = "block"
        accept.style.display = "none"
        btn = false
        text.disabled = true
    }

    
}