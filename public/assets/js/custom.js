function showMessage(msg,type){
    swal(type, msg, type);
 };

 function deleteItem(id,siteurl){
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: siteurl,
                    type:'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data) {
                        if(data.success == true){
                            swal("Success", "Delete Successfylly", "success");
                            window.location.href=data.url;
                        }else{
                            swal("Cancelled", "Something went to wrong", "error");
                        }

                    },
                });
            }

    })
 }

 $("#number_of_license").on('keyup',function(){
    if($(this).val() != ''){
        var amount = $('#amount').val();
        var license = $(this).val();
        var timePeriod = $('#time_period').val();
        var totalAmount = timePeriod * amount * parseInt(license);
        $('.time_period').removeClass('d-none');
        $('#total_amount').val(totalAmount);

    }else{
        $('.time_period').addClass('d-none');
        $('#total_amount').val('');
    }
     var planType = $('#plan_type').val();
     updatePlanTypeLabel(planType);
});
$("#number_of_license").on('change',function(){
    if($(this).val() != ''){
        var amount = $('#amount').val();
        var license = $(this).val();
        var timePeriod = $('#time_period').val();
        var totalAmount = timePeriod * amount * parseInt(license);
        $('.time_period').removeClass('d-none');
        $('#total_amount').val(totalAmount);
    }else{
        $('.time_period').addClass('d-none');
        $('#total_amount').val('');
    }
    var planType = $('#plan_type').val();
    updatePlanTypeLabel(planType);
});
    $("#time_period").on('keyup',function(){
        if($(this).val() != ''){
            var amount = $('#amount').val();
            var planType = $('#plan_type').val();
            var license = $('#number_of_license').val();
            var timePeriod = $(this).val();
            var totalAmount = timePeriod * amount * parseInt(license);
            $('#total_amount').val(totalAmount);
            updatePlanTypeLabel(planType);
        }else{
            $('#total_amount').val('');
        }
    });
    $("#time_period").on('change',function(){
        if($(this).val() != ''){
            var amount = $('#amount').val();
            var planType = $('#plan_type').val();
            var license = $('#number_of_license').val();
            var timePeriod = $(this).val();
            var totalAmount = timePeriod * amount * parseInt(license);
            $('#total_amount').val(totalAmount);
            updatePlanTypeLabel(planType);
        }else{
            $('#total_amount').val('');
        }
    });
    $(".plan").on('click',function(){
        var planType    = $('input[name="plan_id"]:checked').data('type');
        var planAmount  = $('input[name="plan_id"]:checked').data('value');
        var timePeriod = $('#time_period').val();
        var license = $('#number_of_license').val();
        var totalAmount = timePeriod * planAmount * parseInt(license);
        $('#total_amount').val(totalAmount);
        $('#amount').val(planAmount);
        $('#plan_type').val(planType);
        updatePlanTypeLabel(planType);
    });
    if($('input[name="plan_id"]:checked')){
        var planAmount  =   $('input[name="plan_id"]:checked').data('value');
        var planType    = $('input[name="plan_id"]:checked').data('type');
        updatePlanTypeLabel(planType);
        $('#amount').val(planAmount);
        $('#plan_type').val(planType);
    }


    if($("#number_of_license").val() != ''){
        $('.time_period').removeClass('d-none');
    }

    function updatePlanTypeLabel(planType) {
        if(planType == 'monthly'){
            $('#tperiod').html('Number of Month:');
        }else if(planType == 'yearly'){
            $('#tperiod').html('Number of Year:');
        }
    }

