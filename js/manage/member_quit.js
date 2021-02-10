$(document).ready(function(){
    $("#elec_unit").keyup(function(event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#elec_unit").val() != "") {
            $("#elec_unit").css("border-color", "")
            $("#elec_price").val((parseFloat($("#elec_unit").val()) * <?php if(isset($member_result["elec_bill"])){ echo $member_result["elec_bill"]; }else{ echo 0; } ?>).toFixed(2))
        } else {
            $("#elec_price").val("0.00")
            $("#elec_unit").css("border-color", "red")
        }
        if(event.which == 8){
            $("#total_price").val((parseFloat($("#total_price").val()) + parseFloat($("#elec_price").val())).toFixed(2)) 
        }else{
            $("#total_price").val((parseFloat($("#total_price").val()) + parseFloat($("#elec_price").val())).toFixed(2)) 
        }
    })
    $("#fines").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#fines").val() != "") {
            $("#fines").css("border-color", "")
            $("#total_price").val((parseFloat($("#total_price").val()) + parseFloat($("#fines").val())).toFixed(2))
        } else {
            $("#fines").css("border-color", "red")
            $("#total_price").val((parseFloat($("#total_price").val()) + 0).toFixed(2))
        }
        
        console.log($("#total_price").val())
    })
})