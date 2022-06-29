$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls .form:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('-');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });

    $(document).on('click', '.btn-add-phone', function (e) {
        e.preventDefault();

        var controlForm = $('.controls-phone .form-phone:first'),
            currentEntry = $(this).parents('.entry-phone:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry-phone:not(:last) .btn-add-phone')
            .removeClass('btn-add-phone').addClass('btn-remove-phone')
            .removeClass('btn-success').addClass('btn-danger')
            .html('-');
    }).on('click', '.btn-remove-phone', function (e) {
        $(this).parents('.entry-phone:first').remove();

        e.preventDefault();
        return false;
    })

});

$(function() {
    $("#industrySelect").on('change', function() {
        var industry = this.value;
        var selectOption = $('#contractorsSelect');
        var idField = $('#IDField');
        if (industry == "") {

        } else {
            $.ajax({
                data: "industry=" + industry,
                type: "GET",
                url: "/getContractors/"+industry,
                dataType: "json",
                success: function (response) {
                    // Do something if successful.

                    //var objData = jQuery.parseJSON(response);

                    if (response.success == true) {
                        selectOption.empty().append(response.data);
                        selectOption.removeAttr("disabled");
                        $('#helpBlock2').removeClass("error-message-help-block");
                        $('#helpBlock2').text("Contractors Found.");
                    } else {
                        selectOption.find('option').remove();
                        $('#helpBlock2').text(""+response.errorMessage);
                        $('#helpBlock2').addClass("error-message-help-block");
                    }

                }
            });
        }
        //alert(this.value);
    });
});

$(function() {
    $(document).on('click', '#applyMessageBtn', function(e) {
        e.preventDefault();

        $('.loadingApply').css('opacity', 1);

        var message = $("#preMessageOption").val();
        console.log("Message: "+message);

        $.ajax({
            data: null,
            type: "GET",
            url: "/getMessagePre/"+message,
            dataType: "json",
            success: function (response) {
                // Do something if successful.

                //var objData = jQuery.parseJSON(response);

                if (response.success == true) {
                    console.log(""+response.data.message);
                    $('#messageArea').val(function(_, val){
                        return val + response.data.message;
                    });
                    $('.loadingApply').css('opacity', 0);
                } else {
                    console.log(""+response.errorMessage);
                    $('.loadingApply').css('opacity', 0);
                }

            }
        });
        // --
    });
});

$(document).ready(function(){
    $('#sortableTable').dataTable();
});