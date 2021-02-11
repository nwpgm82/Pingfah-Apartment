$(document).ready(function(){
    $("#confirm_quit").click(function(event){
        let err_count = 0
        let inputs = $("input")
        inputs.each(function(){
            if($(this).val() == ""){
                err_count = err_count + 1
                $(this).css("border-color","red")
            }
        })
        if(err_count == 0){
            if(confirm("คุณต้องการยืนยันการแจ้งออกใช่หรือไม่ ?")){
                $("form").submit()
            }else{
                event.preventDefault()
            }
        }else{
            event.preventDefault()
        }
    })
    $("#checkbox").click(function(){
        if($(this).prop("checked") == true){
            $("#confirm_quit").prop("disabled",false)
        }else{
            $("#confirm_quit").prop("disabled",true)
        }
    })
})