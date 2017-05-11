$(function () {

    /*
     * Globally defined for all ajax call to overcome from Token Mismatch error
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*
     * --------------------
     * Ajaxify those forms
     * --------------------
     *
     * All forms with the 'ajax' class will automatically handle showing errors etc.
     *
     */    
    $('form.ajax').ajaxForm({
        delegation: true,
        beforeSubmit: function (formData, jqForm, options) {            
            $.blockUI({ message: '<h3><img src="'+assetsPath+'assets/admin/global/img/loading-spinner-grey.gif" /> Please Wait...</h3>' });            
            
            $(jqForm[0]).find('.error.help-block').remove();
            $(jqForm[0]).find('.has-error').removeClass('has-error');

            var $submitButton = $(jqForm[0]).find('input[type=submit]');
            toggleSubmitDisabled($submitButton);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $('.uploadProgress').show().html('Uploading Images - ' + percentComplete + '% Complete...    ');
        },
        error: function (data, statusText, xhr, $form) {

            // Form validation error.
            if (422 == data.status) {
                processFormErrors($form, $.parseJSON(data.responseText));
                return;
            }

            toastr.error('Whoops! It looks like something went wrong on servers.\n\Please try again, or contact support if the problem persists.');

            var $submitButton = $form.find('input[type=submit]');
            toggleSubmitDisabled($submitButton);

            $('.uploadProgress').hide();
        },
        success: function (data, statusText, xhr, $form) {

            switch (data.status) {
                case 'success':

                    if ($form.hasClass('reset')) {
                        $form.resetForm();
                    }

                    /*
                     * To close the modal after submit, just add one class in form tag
                     */
                    if ($form.hasClass('closeModalAfter')) {
                        //$('.modal, .modal-backdrop').fadeOut().remove();
                        $('.modal, .modal-backdrop').hide();
                    }
                    
                    /*
                     * if you want to close modal popup and redraw datatablelist after updating record from popup(which opens using any action from datatable e.g Edit)
                     * then you have to provide below attribute in form 
                     * 'data-datatable_id' => 'same id of table which you used for datatable list'
                     */
                    if($form.data('datatable_id') != ""){
                        $('#'+$form.data('datatable_id')).DataTable().draw();
                        $('div.modal').modal('hide');
                    }

                    var $submitButton = $form.find('input[type=submit]');
                    toggleSubmitDisabled($submitButton);

                    if (typeof data.message !== 'undefined') {
                        showMessage(data.message, data.status);
                    }

                    if (typeof data.runThis !== 'undefined') {
                        eval(data.runThis);
                    }

                    if (typeof data.redirectUrl !== 'undefined') {
                        window.location = data.redirectUrl;
                    }

                    break;

                case 'error':
                    processFormErrors($form, data.messages);
                    break;

                default:
                    break;
            }

            $('.uploadProgress').hide();
        },
        dataType: 'json'
    });

    function showMessage(message, status) {
        if (status == 'success') {
            toastr.success(message);
        } else if (status == 'error') {
            toastr.error(message);
        } else {
            toastr.info(message)
        }
    }

    function processFormErrors($form, errors) {

        $.each(errors, function (index, error) {            
            if ((index.indexOf(".") >= 0)) {
            //var selector = '.' + index.replace(/\./g, "\\.");      
            //console.log(selector);            
            var index=index.split(".");
            selector=index[0];
            tagName=jQuery("[name^='"+index[0]+"']").prop("tagName").toLowerCase();            
            $(tagName+"[name^='"+selector+"']").after('<div class="help-block error arraycls">' + error + '</div>').parent().addClass('has-error');
            //$(selector, $form).after('<div class="help-block error arraycls">' + error + '</div>').parent().addClass('has-error');

            } else {
                tagName=jQuery("[name^='"+index+"']").not(jQuery('meta')).prop("tagName").toLowerCase();            
                //$(tagName+"[name^='"+selector+"']").after('<div class="help-block error arraycls">' + error + '</div>').parent().addClass('has-error');
                
                var $input = $(tagName+'[name^=' + index + ']', $form);
                if (index == 'global_form_message') {
                    toastr.error(error);
                } else if ($input.prop('type') === 'file') {                    
                    $('input[name='+$input.prop('name')).after('<div class="help-block error photocls">' + error + '</div>').closest("div.form-group").addClass('has-error');
                } else if ($("textarea[name=" + index + "]").hasClass("ckeditor")) {
                    $("textarea[name=" + index + "]").next().after('<div class="help-block error">' + error + '</div>').closest("div.form-group").addClass('has-error');
                } else {
                    if ($input.closest("form").hasClass("custom-wo-public")) {
                        $input.closest('.input-icon').after('<div class="help-block error">' + error + '</div>').parent().addClass('has-error');
                    } else {
                        if(index.indexOf("user_email") >= 0 || index.indexOf("user_type") >= 0 || index.indexOf("msg_content") >= 0)
                        {
                           alert(error); 
                        }/*else if(index.indexOf("date-picker")){
                            $input.next().after('<div class="help-block error">' + error + '</div>').closest("div.form-group").addClass('has-error');
                        }*/
                        else if ($input.prop('type') == 'radio') {
                             // for radio
                            $input.next().parent().append('<div class="help-block error">' + error + '</div>').closest("div").addClass('has-error');
                        }
                        else
                        {
                            $input.after('<div class="help-block error">' + error + '</div>').closest("div.form-group").addClass('has-error');
                        }
                        
                    }
                }
            }                        
        });

        var $submitButton = $form.find('input[type=submit]');
        toggleSubmitDisabled($submitButton);
    }

    function toggleSubmitDisabled($submitButton) {
        $.unblockUI();
        if($submitButton.length > 1)
        {
            $.each( $submitButton, function( key, value ) {
                if ($submitButton.hasClass('disabled')) {
                    $submitButton.attr('disabled', false).removeClass('disabled').val($submitButton.attr('id'));
                }
            });

        }
        else
        {            
            if ($submitButton.hasClass('disabled')) {
                $submitButton.attr('disabled', false).removeClass('disabled').val($submitButton.data('original-text'));
                $.unblockUI();
                return;
            }
        
            $submitButton.data('original-text', $submitButton.val()).attr('disabled', true).addClass('disabled').val('Processing...');
        }
        
    }
});
