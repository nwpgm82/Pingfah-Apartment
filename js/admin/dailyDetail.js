function delImg(id,name){
    if(confirm("คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ? ")){
        location.href = `function/delImage.php?daily_id=${id}&name=${name}`
    }
}
$(document).ready(function(){
    $("#edit").click(function(){
        let inputs = $("input")
        inputs.each(function(i){
            if(i == 0 || i == 13){
                return
            }else if(i == 9){
                $(this).prop("disabled", false)
                $(this).prop("readonly", true)
            }else{
                $(this).prop("disabled",false)
            }
        })
        $("#edit").hide()
        $("#edit-option").css("display","flex")
    })
    $("#cancel-edit").click(function(){
        let inputs = $("input")
        inputs.each(function(i){
            if(i == 0 || i == 13){
                return
            }else if(i == 9){
                $(this).prop("disabled", true)
                $(this).prop("readonly", false)
            }else{
                $(this).prop("disabled",true)
            }
        })
        $("#edit").show()
        $("#edit-option").hide()
    })
    $(".roundtrip-input").dateDropper({
        roundtrip: true,
        theme: "my-style",
        lang: "th",
        format: "d M Y",
        lock: "from",
        startFromMonday: false,
    })
})