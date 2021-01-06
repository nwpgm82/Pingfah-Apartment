$(document).ready(function(){
    $("#search_em").click(function(){
        if($("#firstname").val() != "" && $("#lastname").val() == ""){
            location.href = `index.php?firstname=${$("#firstname").val()}`
        }else if($("#firstname").val() == "" && $("#lastname").val() != ""){
            location.href = `index.php?lastname=${$("#lastname").val()}`
        }else if($("#firstname").val() != "" && $("#lastname").val() != ""){
            location.href = `index.php?firstname=${$("#firstname").val()}&lastname=${$("#lastname").val()}`
        }else{
            $("#firstname").css("border-color","red")
            $("#firstname").addClass("placeholder-error")
            $("#lastname").css("border-color","red")
            $("#lastname").addClass("placeholder-error")
            $("#input_error").html("โปรดระบุข้อความช่องใดช่องหนึ่ง")
        }
    })
    $(".del-btn").click(function(event){
        if(confirm("คุณต้องการลบข้อมูลใช่หรือไม่ ?")){
            location.href = `function/delEm.php?employee_id=${event.target.id}`
        }else{
            event.preventDefault()
        }
        
    })
})