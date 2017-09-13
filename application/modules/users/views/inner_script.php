<link href="<?php echo base_url(); ?>backend_asset/plugins/select2/select2.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>backend_asset/plugins/select2/select2.js"></script>
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>dataTables.buttons.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.flash.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.flash.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>jszip.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>pdfmake.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>vfs_fonts.js"></script>  
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.html5.min.js"></script>  
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.print.min.js"></script>  
<link href="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.dataTables.min.css" rel="stylesheet">
<script>

    jQuery('body').on('click', '#submit', function () {

        var form_name = this.form.id;
        if (form_name == '[object HTMLInputElement]')
            form_name = 'editFormAjax';
        $("#" + form_name).validate({
            rules: {
                user_name: "required",
                user_email: {
                    required: true,
                    email: true
                },
                phone_no: {
                    required: true,
//                    minlength: 10,
//                    maxlength: 20,
//                    number: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                first_name: "required",
                last_name: "required",
                company_name: "required",
                role_id: "required",
            },
            messages: {
                user_name: '<?php echo lang('user_name_validation'); ?>',
                first_name: '<?php echo lang('first_name_validation'); ?>',
                last_name: '<?php echo lang('last_name_validation'); ?>',
                company_name: '<?php echo lang('company_name_validation'); ?>',
                role_id: '<?php echo lang('role_id_validation'); ?>',
                user_email: {
                    required: '<?php echo lang('user_email_validation'); ?>',
                    email: '<?php echo lang('user_email_field_validation'); ?>'
                },
                phone_no: {
                    required: '<?php echo lang('phone_number_validation'); ?>',
                },
                password: {
                    required: '<?php echo lang('password_required_validation'); ?>',
                    minlength: '<?php echo lang('password_minlength_validation'); ?>',
                },
                confirm_password: {
                    required: '<?php echo lang('confirm_password_required_validation'); ?>',
                    equalTo: '<?php echo lang('confirm_password_equalto_validation'); ?>',
                    minlength: '<?php echo lang('confirm_password_minlength_validation'); ?>',
                },
                new_password: {
                    minlength: '<?php echo lang('password_minlength_validation'); ?>',
                },
                confirm_password1: {
                    equalTo: '<?php echo lang('confirm_password_equalto_validation'); ?>',
                    minlength: '<?php echo lang('confirm_password_minlength_validation'); ?>',
                },
                date_of_birth: '<?php echo lang('date_of_birth_validation'); ?>'

            },
            submitHandler: function (form) {
                jQuery(form).ajaxSubmit({
                });
            }
        });
    });

    jQuery('body').on('change', '.input_img2', function () {

        var file_name = jQuery(this).val();
        var fileObj = this.files[0];
        var calculatedSize = fileObj.size / (1024 * 1024);
        var split_extension = file_name.split(".");
        var ext = ["jpg", "gif", "png", "jpeg"];
        if (jQuery.inArray(split_extension[1].toLowerCase(), ext) == -1)
        {
            $(this).val(fileObj.value = null);
            //showToaster('error',"You Can Upload Only .jpg, gif, png, jpeg  files !");
            $('.ceo_file_error').html('<?php echo lang('image_upload_error'); ?>');
            return false;
        }
        if (calculatedSize > 1)
        {
            $(this).val(fileObj.value = null);
            //showToaster('error',"File size should be less than 1 MB !");
            $('.ceo_file_error').html(' 1MB');
            return false;
        }
        if (jQuery.inArray(split_extension[1].toLowerCase(), ext) != -1 && calculatedSize < 10)
        {
            $('.ceo_file_error').html('');
            readURL(this);
        }
    });

    jQuery('body').on('change', '.input_img3', function () {

        var file_name = jQuery(this).val();
        var fileObj = this.files[0];
        var calculatedSize = fileObj.size / (1024 * 1024);
        var split_extension = file_name.split(".");
        var ext = ["jpg", "gif", "png", "jpeg"];
        if (jQuery.inArray(split_extension[1].toLowerCase(), ext) == -1)
        {
            $(this).val(fileObj.value = null);
            //showToaster('error',"You Can Upload Only .jpg, gif, png, jpeg  files !");
            $('.ceo_file_error').html('<?php echo lang('image_upload_error'); ?>');
            return false;
        }
        if (calculatedSize > 1)
        {
            $(this).val(fileObj.value = null);
            //showToaster('error',"File size should be less than 1 MB !");
            $('.ceo_file_error').html(' 1MB');
            return false;
        }
        if (jQuery.inArray(split_extension[1].toLowerCase(), ext) != -1 && calculatedSize < 10)
        {
            $('.ceo_file_error').html('');
            readURL(this);
        }
    });

    function readURL(input) {
        var cur = input;
        if (cur.files && cur.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(cur).hide();
                $(cur).next('span:first').hide();
                $(cur).next().next('img').attr('src', e.target.result);
                $(cur).next().next('img').css("display", "block");
                $(cur).next().next().next('span').attr('style', "");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function getUpperOrganizationRole() {
        var organization_id = $("#organization_id").val();
        $.ajax({
            url: '<?php echo base_url() . 'users/getUpperOrganizationRole' ?>',
            type: 'POST',
            data: {'organization_id': organization_id},
            dataType: 'json',
            success: function (data) {
                $(".upperDiv").show();
                $("#positionName").html("(<span class='text-info'>" + data.positionName + "</span>)");
                $("#upperPositionUser").html(data.roles);
                $("#user_id").select2('val', '');
            }
        });
    }

    jQuery('body').on('click', '.remove_img', function () {
        var img = jQuery(this).prev()[0];
        var span = jQuery(this).prev().prev()[0];
        var input = jQuery(this).prev().prev().prev()[0];
        jQuery(img).attr('src', '').css("display", "none");
        jQuery(span).css("display", "block");
        jQuery(input).css("display", "inline-block");
        jQuery(this).css("display", "none");
        jQuery(".image_hide").css("display", "block");
        jQuery("#user_image").val("");
    });

    jQuery('body').on('change', '#company_name', function () {
        var organization_id = $("#company_name").val();
        $.ajax({
            url: '<?php echo base_url() . 'users/getCompanyRole' ?>',
            type: 'POST',
            data: {'organization_id': organization_id},
            dataType: "JSON",
            success: function (data) {
                if (data.status == 1) {
                    $("#role_id").html(data.roles);
                }
            }
        });

    });

    jQuery('body').on('change', '#assessment_id', function () {
        var assessment_id = $("#assessment_id").val();
        $.ajax({
            url: '<?php echo base_url() . 'users/getAssissmentQuestion' ?>',
            type: 'POST',
            data: {'assessment_id': assessment_id},
            dataType: "JSON",
            success: function (data) {
                if (data.status == 1) {
                    $("#question_id").html(data.roles);
                    var qs = $('input[name=select_question]:checked', '#addFormAjax').val()
                    if (qs == 180) {
                        $("#question_id option").prop('selected', true);
                        $('#question_id option[value=""]').prop('selected', false);
                        $("#question_id").select2();
                    } else {
                        $('#question_id option[value=""]').prop('selected', false);
                        $("#question_id").select2();
                    }

                }
            }
        });

    });

    jQuery('body').on('click', '.questionSelect', function () {
        var qs = $(this).val();
        $("#upper-lavel-box").html("");
        $("#assessment_type_hidden").val(qs);
        if (qs == 180) {
            $("#question_id option").prop('selected', true);
            $('#question_id option[value=""]').prop('selected', false);
            $("#question_id").select2();
            $("#focused-bulet").hide('slow');
        } else {
            $("#question_id option").prop('selected', false);
            $('#question_id option[value=""]').prop('selected', false);
            $("#question_id").select2();
            $("#focused-bulet").show('slow');
        }

    });

    jQuery('body').on('change', '.sedate', function () {
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();
        if (endDate != "") {
            if (new Date(endDate) < new Date(startDate)) {
                $("#end_date").val("");
                $("#date_message").html("End Date Must be greater than Start Date");
            }
        }

    });

    jQuery('body').on('change', '#organization_id', function () {
        $("#user_id").select2('val', '');
        getUpperOrganizationRole();
    });

    jQuery('body').on('change', '#upperPositionUser', function () {
        var organization_id = $("#organization_id").val();
        var upperPositionUser = $("#upperPositionUser").val();
        $.ajax({
            url: '<?php echo base_url() . 'users/getUpperLowerOrganizationRole' ?>',
            type: 'POST',
            data: {'organization_id': organization_id, 'upperPositionUser': upperPositionUser},
            dataType: 'json',
            success: function (data) {
                $(".upperMediumDiv").show();
                $("#positionNameDownUpper").html("(<span class='text-success'>" + data.positionName + "</span>)");
                $("#positionNameDownUpperUser").html(data.roles);
                $("#user_id").select2('val', '');
            }
        });

    });

    jQuery('body').on('change', '#positionNameDownUpperUser', function () {
        $("#user_id").select2('val', '');
    });


    jQuery('body').on('change', '#user_id', function () {
        $("#upper-lavel-box").html("");
    });

    jQuery('body').on('click', '#upper-lavel', function () {
        var organization_id = $("#organization_id").val();
        var user_id = $("#user_id").val();
        var assessment_type = $("#assessment_type_hidden").val();
        $.ajax({
            url: '<?php echo base_url() . 'users/getUpperLavel' ?>',
            type: 'POST',
            data: {'organization_id': organization_id, 'user_id': user_id, 'assessment_type': assessment_type},
            success: function (data) {
                $("#upper-lavel-box").append(data);
                var startRange = $("#start_date").val();
                var endRange = $("#end_date").val();
                $('.bullets_in_month_upper').datepicker({
                    startView: 3,
                    format: "mm/dd/yyyy",
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: false,
                    startDate: startRange,
                    endDate: endRange,
                    multidate: true,
                    clearBtn: true,
                });
            }
        });

    });


    jQuery('body').on('click', '#upper-lavel-edit-180', function () {
        var organization_id = $("#organization_id").val();
        var user_id = $("#user_ids").val();
        var upper_level_user = $("#upper_level_user").val();
        var assessment_type = 180;
        $.ajax({
            url: '<?php echo base_url() . 'users/getUpperLavelEdit' ?>',
            type: 'POST',
            data: {'organization_id': organization_id, 'user_id': user_id, 'assessment_type': assessment_type, 'upper_level_user': upper_level_user},
            success: function (data) {
                $("#upper-lavel-box").append(data);
                var startRange = $("#start_date").val();
                var endRange = $("#end_date").val();
                $('.bullets_in_month_upper').datepicker({
                    startView: 3,
                    format: "mm/dd/yyyy",
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: false,
                    startDate: startRange,
                    endDate: endRange,
                    multidate: true,
                    clearBtn: true,
                });
            }
        });

    });

    jQuery('body').on('click', '#upper-lavel-edit-360', function () {
        var organization_id = $("#organization_id").val();
        var user_id = $("#user_ids").val();
        var upper_level_user = $("#upper_level_user").val();
        var assessment_type = 360;
        $.ajax({
            url: '<?php echo base_url() . 'users/getUpperLavelEdit' ?>',
            type: 'POST',
            data: {'organization_id': organization_id, 'user_id': user_id, 'assessment_type': assessment_type, 'upper_level_user': upper_level_user},
            success: function (data) {
                $("#upper-lavel-box").append(data);
                var startRange = $("#start_date").val();
                var endRange = $("#end_date").val();
                $('.bullets_in_month_upper').datepicker({
                    startView: 3,
                    format: "mm/dd/yyyy",
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: false,
                    startDate: startRange,
                    endDate: endRange,
                    multidate: true,
                    clearBtn: true,
                });
            }
        });

    });


    function remove_upper(id) {
        $("#" + id).remove();
    }

    function removeUpperAssessment(assessmentId, user) {
        bootbox.confirm('Are you sure want to remove user (' + user + ') assessment?', function (isTrue) {
            if (isTrue) {
                $.ajax({
                    url: '<?php echo base_url() . 'users/removeUpperAssessment' ?>',
                    type: 'POST',
                    data: {'assessmentId': assessmentId},
                    dataType: "JSON",
                    success: function (data) {
                        location.reload();
                    }
                });
            }
        });
    }

    $('#common_datatable_users').dataTable({
        order: [],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7]
                }
            }
        ],
        columnDefs: [{orderable: false, targets: [6, 7]}]
    });

    $('#common_datatable_users_assessment').dataTable({
        order: [],
        columnDefs: [{orderable: false, targets: [7]}]
    });

    jQuery('body').on('change', '#end_date', function () {
        var startDateRange = $("#start_date").val();
        var endDateRange = $("#end_date").val();
        $('#bullets_in_month').datepicker({
            startView: 3,
            format: "mm/dd/yyyy",
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: false,
            startDate: startDateRange,
            endDate: endDateRange,
            multidate: true,
            clearBtn: true,
        });
    });

    var send = true;
    jQuery('body').on('change', '#bullets_in_month', function (e) {
//        if(send){
//           var bullets = $("#bullets").val();
//           bullets = +bullets + +1;
//           $("#bullets").val(bullets);
//           send=false;
//        }
//        setTimeout(function(){send=true;},200);
        var bullets_in_month = $("#bullets_in_month").val();
        var counts = bullets_in_month.split(",");
        if (bullets_in_month != "") {
            $("#bullets").val(counts.length);
        } else {
            $("#bullets").val('0');
        }


    });

    $(document).on('ready', function () {

        $("#question_id").select2();
        $('#user_id').select2({
            minimumInputLength: 0,
            tags: [],
            placeholder: 'Select a User',
            ajax: {
                url: "<?php echo base_url(); ?>" + "users/get_user_ajax",
                type: 'GET',
                quietMillis: 50,
                dataType: 'json',
                data: function (term) {
                    return{
                        search: term,
                        id: $("#organization_id").val(),
                        user_id_upper: $("#positionNameDownUpperUser").val()
                    };
                },
                results: function (data) {
                    return{
                        results: $.map(data, function (item) {
                            return{
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }


            }
        });


        $('#start_date').datepicker({
            startView: 3,
            todayBtn: "linked",
            format: "mm/dd/yyyy",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            startDate: '-0d',
            // endDate: '+2m',
        });

        $('#end_date').datepicker({
            startView: 3,
            format: "mm/dd/yyyy",
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            startDate: '-0d',
            //endDate: '+2m',
        });

        var startDateRange1 = $("#start_date").val();
        var endDateRange1 = $("#end_date").val();

        $('.bullets_datepicker').datepicker({
            startView: 3,
            format: "mm/dd/yyyy",
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: false,
            startDate: startDateRange1,
            endDate: endDateRange1,
            multidate: true,
            clearBtn: true,
        });

    });

</script>


