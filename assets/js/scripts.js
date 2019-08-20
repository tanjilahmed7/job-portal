(function ($) {
    'use strict';  

    //user profile update form validation 
    function formvalidation(formEl, obj){ 
        for(var key in obj) {
            
            let inputEl = obj[key].type;
            let inputName = obj[key].name;
            let eMassage = obj[key].eMassage ? obj[key].eMassage : inputName+ ' field is Required.';
            // console.log(inputEl+ ' ' + inputName);
            let inputElSe = formEl.find(inputEl+'[name="'+inputName+'"]');
            
            formEl.find('.form-field__control').removeClass('error');
            formEl.find('.date-section-dropdown').removeClass('error').find('.error-msg').remove();
            if(obj[key].valType && obj[key].max){
                if(inputElSe.val().trim().length > 0 && inputElSe.val().trim().length > obj[key].max){
                    inputElSe.parents('.form-field__control').find('.error-msg').remove(); 
                    inputElSe.parents('.form-field__control').addClass('error').append('<span class="error-msg">'+eMassage+'</span>');
                    return false; 
                }
            }else{
                if( inputElSe.val().trim() == ''){ 
                    if(inputEl == 'select'){ 
                        inputElSe.parents('.form-field__control').find('.error-msg').remove(); 
                        inputElSe.parents('.form-field__control').addClass('error'); 
                        inputElSe.parents('.date-section-dropdown').addClass('error'); 
                        inputElSe.parents('.date-section-dropdown').append('<span class="error-msg">'+eMassage+'</span>');
                    }else{
                        inputElSe.parents('.form-field__control').find('.error-msg').remove(); 
                        inputElSe.parents('.form-field__control').addClass('error').append('<span class="error-msg">'+eMassage+'</span>');
                    }
                     
                    return false; 
                    break;
                }else{
                    if(inputEl == 'select'){
                        inputElSe.parents('.form-field__control').removeClass('error');
                        inputElSe.parents('.date-section-dropdown').removeClass('error').find('.error-msg').remove();
                    }else{
                        inputElSe.parents('.form-field__control').removeClass('error').find('.error-msg').remove();
                    } 
                } 
            }
        };
        return true; 
    }

    //user profile update form validation 
    function signupformCheck(formEl){   
        return formvalidation(formEl, [
            { type: 'input', name: 'fullname', eMassage: 'User Name Required'},
            { type: 'input', name: 'email'},
            { type: 'input', name: 'password'}  
        ]); 
    } 

    $('.notify-bar').hide();
    $('#notify-icon').on('click', function(event){
        event.preventDefault();
        // $('.notify-bar').slideToggle('slow');
        $(".notify-bar").stop().slideToggle(0);
    });

    function notificationResponseRender(authCheck, response){ 
        if( (authCheck == false ) && ( response.auth == true ) ){
            authCheck = response.auth;
        }
        if(response.auth == true){  
            if( $('.notify #notify-icon').find('.count').length > 0){
                $('.notify #notify-icon').find('.count').text(response.data.length); 
            }else{
                if(response.data.length > 0){
                    $('.notify #notify-icon').append('<span class="count">'+response.data.length+'</span>');
                }
            }
            if(response.data.length > 0){
                var nitifiHtml = '';
                $.each(response.data, function(index, item){
                    nitifiHtml +=`
                        <li> 
                            <div class="notify-area"> 
                                <div class="image">
                                    <img src="`+item.from_user_avater+`" alt="">
                                </div>
                                <div class="text">`;
                                if(item.type == 'follow'){
                                    nitifiHtml +=`<h5><span>`+item.from_user_name+`</span> started following you.</h5>`;
                                }else if(item.type == 'post'){
                                    nitifiHtml +=`<h5><span>`+item.from_user_name+`</span> published new `+item.post_cat+` "<a href="`+item.post_link+`">`+item.post_title+`</a>".</h5>`;
                                }else if(item.type == 'comment'){
                                    nitifiHtml +=`<h5><span>`+item.from_user_name+`</span> commented on your post "<a href="`+item.post_link+`">`+item.post_title+`</a>".</h5>`;
                                } 
                            
                                nitifiHtml +=`<p>`+item.date+`</p>
                                </div>                                       
                            </div>     
                        </li>
                    `;
                }); 
                $('.notify-bar ul').empty().append(nitifiHtml);
            } 
        }
        if(response.auth == false){
            clearInterval(notificationINterval);
        }
    }

    function notificationCheck(){
        var authCheck = true; 
        if(authCheck){
            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST', 
                cache       : false, 
                data: {action: 'jp_ajax', requestType: 'notificationCheck'},  
                success: function (response) {  
                    if(response.status == 'success'){ 
                        notificationResponseRender(authCheck, response);
                    } 
                }

            });
        }
    }

    notificationCheck();
    var notificationINterval= setInterval(notificationCheck, 10000);

    $('.signup-submit').on('click', function(event){
        event.preventDefault();

        let reg_type = $('.tab-slider--trigger input[name="reg_type"]:checked').val();
        if(reg_type == 'ux_professional'){
            var myForm = $(this).parents('form#signup-ux');
        }
        if(reg_type == 'job_recruiter'){
            var myForm = $(this).parents('form#signup-jr');
        }
        
        let formData = new FormData(myForm[0]);
        formData.append('action', 'jp_ajax');
        formData.append('requestType', 'signup');
        formData.append('reg_type', reg_type); 
        if( signupformCheck(myForm) ){
            Swal.fire({ 
                type: 'info',
                title: 'Please wait few minuts...',
                showConfirmButton: false
            })
            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST', 
                cache       : false,
                contentType : false,
                processData : false,
                data: formData,  
                success: function (response) { 
                    // console.log(response);
                    if(response.status == 'success'){
                        swal.close();
                        let settings = jpAjax.jobSettings; 
                        window.location.href = settings.baseUrl+'/'+settings.job_status_page+'/?status=cnfirm&email='+response.data.email;
                    }

                    if(response.status == 'failed'){
                        swal.close();
                        $('.top-message').addClass('error'); 
                        $('.top-message').find('p').text(response.errors.existing_user_login);
                        $('.top-message').slideDown(0);
                    }
                }

            });
        }
    }); 

    function loginformCheck(formEl){  
        return formvalidation(formEl, [ 
            { type: 'input', name: 'email'},
            { type: 'input', name: 'password'}  
        ]);
    } 

    $('.login-submit').on('click', function(event){
        event.preventDefault();

        let myForm = $(this).parents('form#login-user'); 
        let formData = new FormData(myForm[0]);
        formData.append('action', 'jp_ajax');
        formData.append('requestType', 'login');

        if( loginformCheck(myForm) ){
            Swal.fire({ 
                type: 'info',
                title: 'Please wait few minuts...',
                showConfirmButton: false
            })
            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST', 
                cache       : false,
                contentType : false,
                processData : false,
                data: formData,  
                success: function (response) { 
                    console.log(response);
                    if(response.status == 'success'){
                        swal.close();
                        let settings = jpAjax.jobSettings; 
                        window.location.href = settings.baseUrl+settings.job_account_page;
                    }
                    if(response.status == 'failed'){ 
                        swal.close();
                        $('#login-user').find('.row.error-box').remove();
                        $('#login-user').prepend('<div class="row error-box"><div class="col-sm"><p>'+response.error+'</p></div></div>');
                    }
                }

            });
        }
    });

    function resetFormCheck(formEl){
        return formvalidation(formEl, [ 
            { type: 'input', name: 'email'} 
        ]);
    }
    
    $('.reset-password-submit').on('click', function(event){
        event.preventDefault();  

        let myForm = $(this).parents('form#reset-pass'); 
        let formData = new FormData(myForm[0]);
        formData.append('action', 'jp_ajax');
        formData.append('requestType', 'resetPassword'); 
        if( resetFormCheck(myForm) ){
            Swal.fire({ 
                type: 'info',
                title: 'Please wait few minuts...',
                showConfirmButton: false
            })
            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST', 
                cache       : false,
                contentType : false,
                processData : false,
                data: formData,  
                success: function (response) { 
                    console.log(response);
                    if(response.status == 'success'){
                        swal.close();
                        let settings = jpAjax.jobSettings; 
                        window.location.href = settings.baseUrl+'/'+settings.job_status_page+'/?status=jpcrm';
                    }

                    if(response.status == 'failed'){
                        swal.close();
                        $('.top-message').addClass('error'); 
                        $('.top-message').find('p').text(response.errors.existing_user_login);
                        $('.top-message').slideDown(0);
                    }
                }

            });
        }
    });

    function newPassresetFormCheck(formEl){
        return formvalidation(formEl, [ 
            { type: 'input', name: 'password'}, 
            { type: 'input', name: 'confirm_password'} 
        ]);
    }

    $('.new-password-submit').on('click', function(event){
        event.preventDefault();  

        let myForm = $(this).parents('form#reset-pass'); 
        let formData = new FormData(myForm[0]);
        formData.append('action', 'jp_ajax');
        formData.append('requestType', 'newPassword'); 
        if( newPassresetFormCheck(myForm) ){
            Swal.fire({ 
                type: 'info',
                title: 'Please wait few minuts...',
                showConfirmButton: false
            })
            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST', 
                cache       : false,
                contentType : false,
                processData : false,
                data: formData,  
                success: function (response) { 
                    console.log(response);
                    if(response.status == 'success'){
                        swal.close();
                        let settings = jpAjax.jobSettings; 
                        window.location.href = settings.baseUrl+'/'+settings.job_status_page+'/?status=jppc';
                    }

                    if(response.status == 'failed'){
                        swal.close();
                        $('.top-message').addClass('error'); 
                        $('.top-message').find('p').text(response.errors.existing_user_login);
                        $('.top-message').slideDown(0);
                    }
                }

            });
        }
    });

    //user profile update form validation 
    function profileformvalidation(formEl){  
        if($('.update-profile').find('.update-btn p').hasClass('error') ){
            return false;
        }else{
            return true;
        }
        if(jpAjax.userType == 'ux'){
            return formvalidation(formEl, [ 
                { type: 'input', name: 'name'},
                { type: 'input', name: 'designation'},
                { type: 'select', name: 'experience'},
                { type: 'input', name: 'phone'}, 
                { type: 'input', name: 'address'}, 
                { type: 'input', name: 'city'}, 
                { type: 'input', name: 'country'}, 
                { type: 'textarea', name: 'introduction', valType: 'len', max: 450, eMassage:'the maximum length of text 450'}
            ]); 
        } 
        if(jpAjax.userType == 'jr'){
            return formvalidation(formEl, [
                { type: 'input', name: 'name'}, 
                { type: 'input', name: 'phone'}, 
                { type: 'input', name: 'address'}, 
                { type: 'input', name: 'city'}, 
                { type: 'input', name: 'country'}  
            ]); 
        }
        
        return false;
    }

    function readURL(input,callback) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function(e) {
                var image = new Image(); 
                image.src = e.target.result;
                // console.log(image.src);
                image.onload = function () { 
                    var height = this.height;
                    var width = this.width;
                    
                    if ( (height >= 650) && (width >= 650)) {  
                        $('.update-profile').find('.update-btn p').removeClass('error');
                    }else{
                        $('.update-profile').find('.update-btn p').addClass('error');
                    } 
                };
                // callback.apply(e);
                $('.update-profile').find('img').attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]);
        }
    }
      
    $("#profile-image").change(function() {
        let currentEl = $(this);
        readURL(this);
    });

    // User Profile Update 
    $('.user-profile-submit').on('click', function(event){
        event.preventDefault(); 

        let myForm = $(this).parents('form#msform'); 
        let formData = new FormData(myForm[0]);
        formData.append('action', 'jp_ajax');
        formData.append('requestType', 'userProfileUpdate');

        if(jQuery('#profile-image')[0].files[0]){
            let files = jQuery('#profile-image')[0].files[0];
            formData.append('profileImage', files);
        }

        if( profileformvalidation(myForm) ){
            $('#lodingModal').modal('show');
            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST', 
                cache       : false,
                contentType : false,
                processData : false,
                data: formData,  
                success: function (response) { 
                    console.log(response);
                    if(response.status == 'success'){ 
                        $('#lodingModal').modal('hide');
                        window.location.href = window.location.href;
                    }
                    if(response.status == 'failed'){ 
                        $('#login-user').find('.row.error-box').remove();
                        $('#login-user').prepend('<div class="row error-box"><div class="col-sm"><p>'+response.error+'</p></div></div>');
                    }
                }

            });
        }
    });

    function addEductionValidation(formEl){
        return formvalidation(formEl, [
            { type: 'input', name: 'course_name'},
            { type: 'input', name: 'institute_name'}, 
            { type: 'input', name: 'city'}, 
            { type: 'input', name: 'country'}, 
            { type: 'select', name: 'start_month'},  
            { type: 'select', name: 'start_year'},  
            { type: 'select', name: 'end_month'},  
            { type: 'select', name: 'end_year'},  
            { type: 'textarea', name: 'description'},  
        ]); 
    }

    //user education fields on form
    $('.addEduModal-submit').on('click', function(event){
        event.preventDefault();  

        let myForm = $(this).parents('form#addeduForm');   
        if( addEductionValidation(myForm) ){
            let course_name     = myForm.find('input[name="course_name"]').val(),
                institute_name  = myForm.find('input[name="institute_name"]').val(),
                city            = myForm.find('input[name="city"]').val(),
                country         = myForm.find('input[name="country"]').val(),
                start_month     = myForm.find('select[name="start_month"]').val(),
                start_monthText = myForm.find('select[name="start_month"] option:selected').text(),
                start_year      = myForm.find('select[name="start_year"]').val(),
                end_month       = myForm.find('select[name="end_month"]').val(),
                end_monthText   = myForm.find('select[name="end_month"] option:selected').text(),
                end_year        = myForm.find('select[name="end_year"]').val(),
                description     = myForm.find('textarea[name="description"]').val();

                description = description.replace(/'/g, "");
                description = description.replace(/"/g, '');
            let indexKey = $('.eductions-list').find('.items').length;
                indexKey = ( indexKey == 0 ) ? indexKey : indexKey  ;
            let oututHtml = `<div class="items" data-id="`+indexKey+`">
                                <div class="actions float-right">
                                    <ul>
                                    <li><a href="#" class="editeduModal"><i class="fa fa-edit"
                                            aria-hidden="true"></i></a></li>
                                    <li><a class="item-delete" href="#" data-toggle="modal" data-target="#deleteExpericenceModal"><i
                                            class="fa fa-trash" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                                <div class="text-items">
                                    <h2>`+course_name+`</h2>
                                    <p>`+institute_name+`</p>
                                    <span>`+start_monthText+` `+start_year+` - `+end_monthText+` `+end_year+` / `+city+`, `+country+`</span>
                                </div>
                                <input type="hidden" data-name="course_name" name="edu[`+indexKey+`][course_name]" value="`+course_name+`" >
                                <input type="hidden" data-name="institute_name" name="edu[`+indexKey+`][institute_name]" value="`+institute_name+`" >
                                <input type="hidden" data-name="city" name="edu[`+indexKey+`][city]" value="`+city+`" >
                                <input type="hidden" data-name="country" name="edu[`+indexKey+`][country]" value="`+country+`" >
                                <input type="hidden" data-name="start_month" name="edu[`+indexKey+`][start_month]" value="`+start_month+`" >
                                <input type="hidden" data-name="start_year" name="edu[`+indexKey+`][start_year]" value="`+start_year+`" >
                                <input type="hidden" data-name="end_month" name="edu[`+indexKey+`][end_month]" value="`+end_month+`" >
                                <input type="hidden" data-name="end_year" name="edu[`+indexKey+`][end_year]" value="`+end_year+`" >
                                <input type="hidden" data-name="description" name="edu[`+indexKey+`][description]" value="`+description+`" >
                            </div>`;
                $(oututHtml).insertBefore( $( ".eductions-list .add-view-btn" ) );
                myForm.trigger("reset");
                $('#addeduModal').modal('hide');
        }
    });

    //edit user eduction
    $('.eductions-list').on('click', '.editeduModal', function(event){
        event.preventDefault();  
        let itemEl          = $(this).parents('.items'),
            indexKey        = itemEl.attr('data-itemkey'),
            course_name     = itemEl.find('input[data-name="course_name"]').val(),
            institute_name  = itemEl.find('input[data-name="institute_name"]').val(),
            city            = itemEl.find('input[data-name="city"]').val(),
            country         = itemEl.find('input[data-name="country"]').val(),
            start_month     = itemEl.find('input[data-name="start_month"]').val(),  
            start_year      = itemEl.find('input[data-name="start_year"]').val(),
            end_month       = itemEl.find('input[data-name="end_month"]').val(), 
            end_year        = itemEl.find('input[data-name="end_year"]').val(),
            description     = itemEl.find('input[data-name="description"]').val();
            
        $('#editeduModal').attr('data-itemkey', indexKey);
        $('#editeduModal').find('input[name="course_name"]').val(course_name);
        $('#editeduModal').find('input[name="institute_name"]').val(institute_name);
        $('#editeduModal').find('input[name="city"]').val(city);
        $('#editeduModal').find('input[name="country"]').val(country);
        $('#editeduModal').find('select[name="start_month"]').val(start_month);
        $('#editeduModal').find('select[name="start_year"]').val(start_year);
        $('#editeduModal').find('select[name="end_month"]').val(end_month);
        $('#editeduModal').find('select[name="end_year"]').val(end_year);
        $('#editeduModal').find('textarea[name="description"]').text(description);
        $('#editeduModal').modal('show');
    });


    $('.editEduModal-submit').on('click', function(event){
        event.preventDefault(); 

        let myForm = $(this).parents('form#editeduForm');   
        let indexKey = $(this).parents('#editeduModal').attr('data-itemkey'); 
        
        
        if( addEductionValidation(myForm) ){
            let course_name     = myForm.find('input[name="course_name"]').val(),
                institute_name  = myForm.find('input[name="institute_name"]').val(),
                city            = myForm.find('input[name="city"]').val(),
                country         = myForm.find('input[name="country"]').val(),
                start_month     = myForm.find('select[name="start_month"]').val(),
                start_monthText = myForm.find('select[name="start_month"] option:selected').text(),
                start_year      = myForm.find('select[name="start_year"]').val(),
                end_month       = myForm.find('select[name="end_month"]').val(),
                end_monthText   = myForm.find('select[name="end_month"] option:selected').text(),
                end_year        = myForm.find('select[name="end_year"]').val(),
                description     = myForm.find('textarea[name="description"]').val();
                description = description.replace(/'/g, "");
                description = description.replace(/"/g, '');

                let itemElement = $('.eductions-list').find('.items[data-itemkey="'+indexKey+'"]');
                // console.log(myForm);
                // console.log(course_name);
                // console.log(itemElement.find('input[data-name="course_name"]'));
                    itemElement.find('input[data-name="course_name"]').val(course_name); 
                    itemElement.find('input[data-name="institute_name"]').val(institute_name);
                    itemElement.find('input[data-name="city"]').val(city);
                    itemElement.find('input[data-name="country"]').val(country);
                    itemElement.find('input[data-name="start_month"]').val(start_month); 
                    itemElement.find('input[data-name="start_year"]').val(start_year);
                    itemElement.find('input[data-name="end_month"]').val(end_month);
                    itemElement.find('input[data-name="end_year"]').val(end_year);
                    itemElement.find('input[data-name="description"]').val(description);
                    itemElement.find('.text-items h2').text(course_name);
                    itemElement.find('.text-items p').text(institute_name);
                    itemElement.find('.text-items span').text(start_monthText+' '+start_year+' - '+end_monthText+' '+end_year+' / '+city+', '+country);
            $('#editeduModal').modal('hide');
        }

    });

    $('.eductions-list').on('click', '.deleteEduModal', function(){
        event.preventDefault(); 
        let indexKey = $(this).parents('.items').attr('data-itemkey'); 
        $('#deleteEduModal').attr('data-itemkey', indexKey);
        $('#deleteEduModal').modal('show');
    });

    $('#deleteEduModal-submit').on('click', function(){
        event.preventDefault();
        let indexKey = $(this).parents('#deleteEduModal').attr('data-itemkey'); 
        $('.eductions-list').find('.items[data-itemkey="'+indexKey+'"]').remove();
        $('.eductions-list').find('.items').each(function(index, element){ 
            $(element).attr('data-id', index);
            $(element).attr('data-itemkey', index);
            $(element).find('input').each(function(inputIn, inputEl){ 
                let name = $(inputEl).attr('name').replace(/[0-9]+/g, index); 
                $(inputEl).attr('name', name); 
            });
        });
        $('#deleteEduModal').modal('hide');
    })

    // user skill fields add on form
    $('.form-field__input.soft_skils, .form-field__input.ux_ui_skils,  .form-field__input.tools_skils').on('keypress', function(event){
        // console.log(event.which);
        if( event.which === 13 ){
            let value = $(this).val().replace(',', '');
            let name = null;
            if($(this).hasClass('soft_skils')){ name = 'soft_skils'; }
            if($(this).hasClass('ux_ui_skils')){ name = 'ux_ui_skils'; }
            if($(this).hasClass('tools_skils')){ name = 'tools_skils'; }
            if(value !== ''){
                $(this).parents('.form-field__control')
                .find('.skiles-box')
                .append('<span class="item">'+value+' <span class="close">X</span><input type="hidden" name="'+name+'[]" value="'+value+'" ></span>');
                $(this).val(''); 
                name = null;
            }
        } 
    });

    $('.form-field__control').on('click', 'span.close', function(event){
        $(this).parents('.item').remove();
    });

    $('textarea[name="introduction"]').on('keyup keypress', function(event){
        let value = $(this).val();  
        $(this).parents('.form-field__control').find('.count').text(value.length +'/450');
        if(value.length == 450 ){
            return false;
        }
    });

    //------------------------ expericence js end ----------------------------------
    $('#addWorkExpericence input[type="checkbox"]').click(function () {
        if ($(this).prop("checked") == true) {
            $(this).parents('#addWorkExpericence').find('.end-experience').hide();
        } else if ($(this).prop("checked") == false) {
             $(this).parents('#addWorkExpericence').find('.end-experience').show();
        }
    });
    
    $('#editExpericenceModal input[type="checkbox"]').click(function () {
        if ($(this).prop("checked") == true) {
            $(this).parents('#editExpericenceModal').find('.end-experience').hide();
        } else if ($(this).prop("checked") == false) {
             $(this).parents('#editExpericenceModal').find('.end-experience').show();
        }
    });

    function addExpericenceValidation(formEl){
         let firstStep = formvalidation(formEl, [
            { type: 'input', name: 'designation'},
            { type: 'input', name: 'company_name'}, 
            { type: 'input', name: 'city'}, 
            { type: 'input', name: 'country'}  
        ]); 

        if(firstStep == true){
            if(formEl.find('input[name="current"]').is(':checked')){
                return formvalidation(formEl, [ 
                    { type: 'select', name: 'start_month'},  
                    { type: 'select', name: 'start_year'}, 
                    { type: 'textarea', name: 'description'},  
                ]); 
            }else{
                return formvalidation(formEl, [ 
                    { type: 'select', name: 'start_month'},  
                    { type: 'select', name: 'start_year'},  
                    { type: 'select', name: 'end_month'},  
                    { type: 'select', name: 'end_year'},  
                    { type: 'textarea', name: 'description'},  
                ]); 
            }
        } 
        return false;
    }

    //user Expericence fields on form
    $('.add-work-expericence-submit').on('click', function(event){
        event.preventDefault();  

        let myForm = $(this).parents('form#addWorkExpericence');   
        if( addExpericenceValidation(myForm) ){
            let designation     = myForm.find('input[name="designation"]').val(),
                company_name  = myForm.find('input[name="company_name"]').val(),
                city            = myForm.find('input[name="city"]').val(),
                country         = myForm.find('input[name="country"]').val(),  
                current         = myForm.find('input[name="current"]').is(':checked') ? myForm.find('input[name="current"]').val() : '',
                start_month     = myForm.find('select[name="start_month"]').val(),
                start_monthText = myForm.find('select[name="start_month"] option:selected').text(),
                start_year      = myForm.find('select[name="start_year"]').val(),
                end_month       = myForm.find('select[name="end_month"]').val(),
                end_monthText   = myForm.find('select[name="end_month"] option:selected').text(),
                end_year        = myForm.find('select[name="end_year"]').val(),
                description     = myForm.find('textarea[name="description"]').val();
                description = description.replace(/'/g, "");
                description = description.replace(/"/g, '');
            let indexKey = $('.experience-list').find('.items').length;
                indexKey = ( indexKey == 0 ) ? indexKey : indexKey  ;
            let oututHtml = `<div class="items" data-id="`+indexKey+`" data-itemkey="`+indexKey+`">
                                <div class="actions float-right">
                                    <ul>
                                    <li><a href="#" class="editExpericence"><i class="fa fa-edit"
                                            aria-hidden="true"></i></a></li>
                                    <li><a class="item-delete deleteExpericenceModelOpen" href="#" data-toggle="modal"><i
                                            class="fa fa-trash" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                                <div class="text-items">
                                    <h2>`+company_name+`</h2>
                                    <p>`+designation+`</p>
                                    <span>`+start_monthText+` `+start_year+` - `+end_monthText+` `+end_year+` / `+city+`, `+country+`</span>
                                </div>
                                <input type="hidden" data-name="designation" name="exp[`+indexKey+`][designation]" value="`+designation+`" >
                                <input type="hidden" data-name="company_name" name="exp[`+indexKey+`][company_name]" value="`+company_name+`" >
                                <input type="hidden" data-name="current" name="exp[`+indexKey+`][current]" value="`+current+`" >
                                <input type="hidden" data-name="city" name="exp[`+indexKey+`][city]" value="`+city+`" >
                                <input type="hidden" data-name="country" name="exp[`+indexKey+`][country]" value="`+country+`" >
                                <input type="hidden" data-name="start_month" name="exp[`+indexKey+`][start_month]" value="`+start_month+`" >
                                <input type="hidden" data-name="start_year" name="exp[`+indexKey+`][start_year]" value="`+start_year+`" >
                                <input type="hidden" data-name="end_month" name="exp[`+indexKey+`][end_month]" value="`+end_month+`" >
                                <input type="hidden" data-name="end_year" name="exp[`+indexKey+`][end_year]" value="`+end_year+`" >
                                <input type="hidden" data-name="description" name="exp[`+indexKey+`][description]" value="`+description+`" >
                            </div>`;
                $(oututHtml).insertBefore( $( ".experience-list .add-view-btn" ) );
                myForm.trigger("reset");
                $('#addExpericenceModal').modal('hide');
        }
    });

    $('.experience-list').on('click', '.editExpericence', function(event){
        event.preventDefault();  
        let itemEl          = $(this).parents('.items'),
            indexKey        = itemEl.attr('data-itemkey'),
            designation     = itemEl.find('input[data-name="designation"]').val(),
            company_name    = itemEl.find('input[data-name="company_name"]').val(),
            current         = itemEl.find('input[data-name="current"]').val(),
            city            = itemEl.find('input[data-name="city"]').val(),
            country         = itemEl.find('input[data-name="country"]').val(),
            start_month     = itemEl.find('input[data-name="start_month"]').val(),  
            start_year      = itemEl.find('input[data-name="start_year"]').val(),
            end_month       = itemEl.find('input[data-name="end_month"]').val(), 
            end_year        = itemEl.find('input[data-name="end_year"]').val(),
            description     = itemEl.find('input[data-name="description"]').val();
            
        $('#editExpericenceModal').attr('data-itemkey', indexKey);
        $('#editExpericenceModal').find('input[name="designation"]').val(designation);
        $('#editExpericenceModal').find('input[name="company_name"]').val(company_name);
        if(current == 'yes'){
            $('#editExpericenceModal').find('input[name="current"]').attr('checked', 'checked');
            $('#editExpericenceModal').find('.end-experience').hide();
        }else{
            $('#editExpericenceModal').find('input[name="current"]').removeAttr('checked');
            $('#editExpericenceModal').find('.end-experience').show();
        }
        $('#editExpericenceModal').find('input[name="city"]').val(city);
        $('#editExpericenceModal').find('input[name="country"]').val(country);
        $('#editExpericenceModal').find('select[name="start_month"]').val(start_month);
        $('#editExpericenceModal').find('select[name="start_year"]').val(start_year);
        $('#editExpericenceModal').find('select[name="end_month"]').val(end_month);
        $('#editExpericenceModal').find('select[name="end_year"]').val(end_year);
        $('#editExpericenceModal').find('textarea[name="description"]').text(description);
        $('#editExpericenceModal').modal('show');
    });

    $('.edit-expericence-submit').on('click', function(event){
        event.preventDefault(); 

        let myForm = $(this).parents('form#editExpericence');   
        let indexKey = $(this).parents('#editExpericenceModal').attr('data-itemkey'); 
        
        
        if( addExpericenceValidation(myForm) ){
            let designation     = myForm.find('input[name="designation"]').val(),
                company_name    = myForm.find('input[name="company_name"]').val(),
                current         = myForm.find('input[name="current"]').is(':checked') ? myForm.find('input[name="current"]').val() : '',
                city            = myForm.find('input[name="city"]').val(),
                country         = myForm.find('input[name="country"]').val(),
                start_month     = myForm.find('select[name="start_month"]').val(),
                start_monthText = myForm.find('select[name="start_month"] option:selected').text(),
                start_year      = myForm.find('select[name="start_year"]').val(),
                end_month       = myForm.find('select[name="end_month"]').val(),
                end_monthText   = myForm.find('select[name="end_month"] option:selected').text(),
                end_year        = myForm.find('select[name="end_year"]').val(),
                description     = myForm.find('textarea[name="description"]').val();
                description = description.replace(/'/g, "");
                description = description.replace(/"/g, '');

                let itemElement = $('.experience-list').find('.items[data-itemkey="'+indexKey+'"]');
                // console.log(myForm);
                // console.log(course_name);
                // console.log(itemElement.find('input[data-name="course_name"]'));
                    itemElement.find('input[data-name="designation"]').val(designation); 
                    itemElement.find('input[data-name="company_name"]').val(company_name);
                    itemElement.find('input[data-name="current"]').val(current);
                    itemElement.find('input[data-name="city"]').val(city);
                    itemElement.find('input[data-name="country"]').val(country);
                    itemElement.find('input[data-name="start_month"]').val(start_month); 
                    itemElement.find('input[data-name="start_year"]').val(start_year);
                    itemElement.find('input[data-name="end_month"]').val(end_month);
                    itemElement.find('input[data-name="end_year"]').val(end_year);
                    itemElement.find('input[data-name="description"]').val(description);
                    itemElement.find('.text-items h2').text(company_name);
                    itemElement.find('.text-items p').text(designation);
                    itemElement.find('.text-items span').text(start_monthText+' '+start_year+' - '+end_monthText+' '+end_year+' / '+city+', '+country);
            $('#editExpericenceModal').modal('hide');
        }

    });

    $('.experience-list').on('click', '.deleteExpericenceModelOpen', function(){
        event.preventDefault(); 
        let indexKey = $(this).parents('.items').attr('data-itemkey'); 
        $('#deleteExpericenceModal').attr('data-itemkey', indexKey);
        $('#deleteExpericenceModal').modal('show');
    });

    $('#deleteExpericence').on('click', function(){
        event.preventDefault();
        let indexKey = $(this).parents('#deleteExpericenceModal').attr('data-itemkey'); 
        $('.experience-list').find('.items[data-itemkey="'+indexKey+'"]').remove();
        $('.experience-list').find('.items').each(function(index, element){ 
            $(element).attr('data-id', index);
            $(element).attr('data-itemkey', index);
            $(element).find('input').each(function(inputIn, inputEl){ 
                let name = $(inputEl).attr('name').replace(/[0-9]+/g, index); 
                $(inputEl).attr('name', name); 
            });
        });
        $('#deleteExpericenceModal').modal('hide');
    });

    //------------------------ expericence js end ----------------------------------

    $('#review_post').on('click', function (event) {
        event.preventDefault();
        if (JobStep3() === true){
            $('#PostReview').modal('show');
                var CompanyName = $('#CompanyName').val();
                var City = $('#City').val();
                var Country = $('#Country').val();
                var CompanyWebsiteLink = $('#CompanyWebsiteLink').val();
                var JobTitle = $('#JobTitle').val();
                var JobType = $("input[name='job_type']").val();
                var to = $('#to').val();
                var from = $('#from').val();
                var Discrption = tinyMCE.activeEditor.getContent();
                var ApplyLink = $('#ApplyLink').val();
                var NumberOfDays = $('#NumberOfDays').val();


                $(".profile span").append(JobType);
                $(".profile h4").append(JobTitle);
                $(".profile p").append(City + ', ' + Country);
                $(".profile-discription span").append("Active for " + NumberOfDays + " days");
                $(".profile-discription p").append(Discrption);

                var preview = document.querySelector('#preview1');
                var file = document.querySelector('input[type=file]').files[0];
                var reader = new FileReader();

                reader.addEventListener("load", function () {
                    preview.src = reader.result;
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
}
        }
        

           



    });

    $('#add_job_post').on('click', function (event) {
        event.preventDefault();

        let myForm = $('form#msform');
        let formData = new FormData(myForm[0]);
        var Discrption = tinyMCE.activeEditor.getContent();
        formData.append('action', 'jp_ajax');
        formData.append('requestType', 'UserjobPost');
        formData.append('job_discrption', Discrption);


        if (jQuery('#company_logo')[0].files[0]) {
            let files = jQuery('#company_logo')[0].files[0];
            formData.append('company_logo', files);
        }

        var request = $.ajax({
            url: jpAjax.ajaxurl,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function () {
                Swal.fire({
                    type: 'info',
                    title: 'Please wait few minuts...',
                    showConfirmButton: false
                });
            },
            success: function (html) {
                Swal.close();
                $('#PostReview').modal('hide');
                $('#messeage').empty();
                // Swal.fire(
                //     'Add Job!',
                //     'You clicked the button!',
                //     'success'
                // );
                // console.log('success');
                
            
                $('#progressbar').find('li[data-id="three"]').next().addClass('active');
                $('fieldset#three').slideUp(0).next().addClass('active').slideDown(0);
                $('#progressbar').find('li[data-id="three"]').removeClass('active')
                //}
            
                    
                
            }

        });
            

    });  

    $('#NumberOfDays').keyup(function(e){
        var dInput = this.value;
        if (dInput < 10){
            $('#NumberOfDays').addClass('error');
            $('.post-show').addClass('required');
        }else{
            $('#NumberOfDays').removeClass('error'); 
            $('.post-show').removeClass('required');
        }
        $('#doller').html('$' + dInput * 1);
    });

    $('#interview_category_options').on('click', 'li', function(){
        $('span.label-name').remove();
        var slug = $(this).data('value');
        var request = $.ajax({
            url: jpAjax.ajaxurl,
            type: 'POST',
            data: {
                name: slug,
                requestType: 'interviewQuestion',
                action: 'jp_ajax'
            }, 
  
            beforeSend: function () {
                $('.interview-list ol').html('<h3>Loading.....</h3>');
            },
            success: function (response) {
                $('.interview-list ol').empty();
                $('.interview-list ol').append(response.data);
            }

        });
                
    });

    function AskQuestionCountDigit(){
        $('#write_question').on('keyup', function (e) {
            var valueLenght = this.value.length;
            $('#count-digit').html(valueLenght);
            if (valueLenght >= 150){
                $('.ask-text-count').css('color', 'red');
                $(this).addClass('select-error');
                return false;
            }else{
                $('.ask-text-count').css('color', '#9c9c9c');
                $(this).removeClass('select-error');
               
            }

             return true;
           
        });
    }
    AskQuestionCountDigit();

    $('#ask-question').on('click', function(){
        $('#AskQuestionModal').modal('show');   
    });

    $('#ask_submit').on('click', function(){
        
       var valueLenght  = $('#write_question').val().length;
        if (valueLenght >= 150 || valueLenght == '') {
            $('#write_question').addClass('select-error');
        }else{
            let myForm = $('form#ask-form');
            let formData = new FormData(myForm[0]);
            formData.append('action', 'jp_ajax');
            formData.append('requestType', 'askQuestion');

            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    Swal.fire({
                        type: 'info',
                        title: 'Please wait few minuts...',
                        showConfirmButton: false
                    });
                },
                success: function (response) {
                    $('#AskQuestionModal').modal('hide');
                    $('form#ask-form')[0].reset();
                    Swal.fire(
                        'Add Ask Question!',
                        'You clicked the button!',
                        'success'
                    );
                    $('.ask_question').prepend('<li class="ask-list"><h3>' + response.data + '<h3></li>');
                }

            });
        }    

               
    });
   
    function resourceCheck(formEl){   
        return formvalidation(formEl, [
            { type: 'input', name: 'title', eMassage: 'User Title is Required'},
            { type: 'input', name: 'resourse_link', eMassage: 'Resourse link  is Required'},
        ]); 
    }

    $('.resource-link').on('click', function(event){
        event.preventDefault();
        var request = $.ajax({
            url: jpAjax.ajaxurl,
            type: 'POST',
            data: {
                requestType: 'resourseModal',
                action: 'jp_ajax'
            },

            beforeSend: function () {
                Swal.fire({ 
                    type: 'info',
                    title: 'Please wait few minuts...',
                    showConfirmButton: false
                });                
            },
            success: function (response) {
                Swal.close();
                $('.login-user-nav').css('display', 'none');
                $('body').prepend(response.data);
                $('#ResourseModal').modal('show');
                $('#resourseSubmit').on('click', function(){
                        let myForm = $('form#resourse-form');
                        if(resourceCheck(myForm)){
                            let myForm = $('form#resourse-form');
                            let formData = new FormData(myForm[0]);
                            formData.append('action', 'jp_ajax');
                            formData.append('requestType', 'resourseModalData');
                            let files = jQuery('#featued_resourse')[0].files[0];
                            formData.append('featued_resourse', files);
    
                            var request = $.ajax({
                                url: jpAjax.ajaxurl,
                                type: 'POST',
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: formData,
                                beforeSend: function () {
    
                                },
                                success: function (response) {
                                    if (response.image_errors) {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Oops...',
                                            text: 'Image Size is wrong!',
                                        });
                                        $('#ResourseModal').modal('show');
                                    }else{
                                        $('#ResourseModal').modal('hide');
                                        $('form#resourse-form')[0].reset();
                                        Swal.fire(
                                            'Add Resource!',
                                            'You clicked the button!',
                                            'success'
                                        );
                                    }
    
                                }
    
                            });
                        }


                });
            }

        });

    });


    // UpdateResourseSubmit


    $('.resource-edit').on('click', function (e) {
        e.preventDefault();
        var x = $(this).find('i').attr('data-id');
        console.log(x);
        $('.modal-' + x).modal('show');
        // $('#EditResourseModal').modal('show');

        
            $('#UpdateResourseSubmit-' + x).on('click', function (e) {
                
                let myForm = $('form#edit-resourse-form-' + x);
                let formData = new FormData(myForm[0]);
                formData.append('action', 'jp_ajax');
                formData.append('requestType', 'EditResourseModalData');
                let files = jQuery('#featued_resourse')[0].files[0];
                formData.append('featued_resourse', files);

                var request = $.ajax({
                    url: jpAjax.ajaxurl,
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function () {
                        Swal.fire({
                            type: 'info',
                            title: 'Please wait few minuts...',
                            showConfirmButton: false
                        });
                    },
                    success: function (response) {
                        $('.modal-' + x).modal('hide');
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Your post has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);

                    }

                });
            
            });
    });


    // Post Love React Count
    $('#love-react').on('click', function(e){
        e.preventDefault();
        var count = $(this).attr('data-id');
        var postID = $(this).attr('data-post');
        console.log(count);
        var request = $.ajax({
            url: jpAjax.ajaxurl,
            type: 'POST',
            dataType: "json",
            data: {
                count: count,
                postID: postID,
                requestType: 'ReactPostLove',
                action: 'jp_ajax'
            }, 
  
            beforeSend: function () {
            },
            success: function (response) {
                $('.love-post-count').html(response.data);
            }

        });        
    });

    // Ux User Filter
    $('#ux-user-filter-submit').on('click', function(event){
        event.preventDefault();   

        let fieldParentDiv = $('#ux-user-filter');  
        let name = fieldParentDiv.find('input[name="name"]').val();
        let city = fieldParentDiv.find('input[name="city"]').val();
        let exp = fieldParentDiv.find('input.exp:checked').map(function(){
                    return $(this).val();
                }).get();  
            $('#lodingModal').modal('show');
            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST', 
                data: {action: 'jp_ajax', requestType : 'ux-user-filter', name: name, city: city, exp:exp},  
                success: function (response) {  
                    if(response.status == 'success'){  
                        if(response.data != false){ 
                            let users = response.data;
                            var  oututHtml = '';
                            $.each(users, function(key, user){
                                    oututHtml += `<div class="col-md-4">
                                                    <div class="members-list"> 
                                                        <div class="members"> 
                                                        <div class="image"><a href="`+user.profile_link+`" ><img src="`+user.thumb+`" /></a></div>
                                                            <div class="content">
                                                                <span class="location">`+user.city+`, `+user.country+`</span>
                                                                <h3>`+user.name+` `+user.last_name+`</h3>
                                                                <p>`+user.designation+`</p>
                                                                <ul>
                                                                    <li>`+user.exp+` Yrs Experience </li>
                                                                    <li>987 Followers</li>
                                                                </ul>
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                </div>`;
                            });
                            if(oututHtml){
                                $('.member-list-row').empty().append(oututHtml);
                            }
                        }else{
                            $('.member-list-row').empty().append('<div class="col-md-12"><h3 class="text-center">'+response.message+'</h3></div>');
                        }
                    }
                    if(response.status == 'failed'){ 
                        $('#lodingModal').modal('hide');
                        $('#editExpericenceModal .modal-body').find('.row.error-box').remove();
                        $('#editExpericenceModal .modal-body').prepend('<div class="row error-box"><div class="col-sm"><p>'+response.error+'</p></div></div>');
                    }
                }
            }); 
    });

    // Videos
    $('.VideoLink').click(function () {
        
        var videos = $(this).data('src');
        var link = videos + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0";
        var VideoModal = '<div class="modal fade VideoTutorial" id="VideoTutorial" tabindex="-1" role="dialog" aria-labelledby="VideoTutorial" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" width="500" height="500" src="'+link+'" id="video"  allowscriptaccess="always" allow="autoplay"></iframe></div></div></div></div></div></div>';

        $('body').prepend(VideoModal);
    });

    $('#ux-job-filter').on('click', function(e){
        e.preventDefault();

        let myForm = $('form#msform');
        let formData = new FormData(myForm[0]);
        formData.append('action', 'jp_ajax');
        formData.append('requestType', 'UXJobFilter');
        $.ajax({
            url: jpAjax.ajaxurl,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: formData,
            beforeSend: function () {
                Swal.fire({
                    type: 'info',
                    title: 'Loading...',
                    showConfirmButton: false
                });
            },
            success: function (html) {
                console.log(html);
                Swal.close();
                $('.ux_job_filter').html(html.data);
                
            }

        });
        
    });

    $('.filter-dropdown input[type="checkbox"]').click(function () {
        var count = $('.form-check-input:checked').length;
        $('.number-of-count').html(count);
    });

    $(' input[type="checkbox"]').click(function () {
        var count = $('.exp:checked').length;
        $('.number-of-count').html(count);


    });

    $('#ux-user-flowing').on('click', function(event){
        event.preventDefault();   
        if(!$(this).hasClass('active')){
            var followButton = $(this);
            let userId = $(this).attr('data-id');  
            let userStatus = $(this).attr('data-status'); 
            followButton.addClass('active'); 
                var request = $.ajax({
                    url: jpAjax.ajaxurl,
                    type: 'POST', 
                    data: {action: 'jp_ajax', requestType : 'uxUserFlowing', user_id: userId, status: userStatus},  
                    success: function (response) {  
                        if(response.status == 'success'){  
                            followButton.text(response.data);
                            followButton.attr('data-status', response.data);
                            followButton.prev('.followers').find('ul li:last-child').text(response.followers +' Followers');
                        }
                        if(response.status == 'failed'){ 
                            $('#lodingModal').modal('hide');
                            $('#editExpericenceModal .modal-body').find('.row.error-box').remove();
                            $('#editExpericenceModal .modal-body').prepend('<div class="row error-box"><div class="col-sm"><p>'+response.error+'</p></div></div>');
                        }
                        followButton.removeClass('active'); 
                    }
                }); 
        }
    });

    function UxchallengeInput(formEl){   
        return formvalidation(formEl, [
            { type: 'input', name: 'ux_challenge_title', eMassage: 'Title  is Required'},
        ]); 
    }

    $('#ux-challenge-modal').on('click', function(e){
        e.preventDefault();
        $('#UxChallengeModal').modal('show');
    });

    function selectSubmissionCat(){
        if ($('select[name=ux_challenge_cat]').val() == '') {
            $('select[name=ux_challenge_cat]').addClass('select-error').parent().append('<span class="error-msg">Fields is required!</span>');
            return false;
        } else {
            $('select[name=ux_challenge_cat]').removeClass('select-error');
            $('select[name=ux_challenge_cat]').find('.error-msg').remove();
            // $('.error-msg').find('.error-msg').remove();
        }
         return true;
    }
    $('#ux_challenge_submit').on('click', function(){
            var content = tinyMCE.activeEditor.getContent();
            console.log(content);
            let myForm = $('form#ux-challenge-form');

            if (selectSubmissionCat() === true){
                if(UxchallengeInput(myForm)){
                    let formData = new FormData(myForm[0]);
                    formData.append('action', 'jp_ajax');
                    formData.append('requestType', 'UXChallengeSubmission');
                    formData.append('discription', content);
                    $.ajax({
                        url: jpAjax.ajaxurl,
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        beforeSend: function () {

                        },
                        success: function (html) {
                            $('#UxChallengeModal').modal('hide');
                            $('form#ux-challenge-form')[0].reset();
                            Swal.fire(
                                'Add UX Challenge!',
                                'You clicked the button!',
                                'success'
                            );
                        }

                    });
                }            
            }


            
    });

    // Share Interview Question 

    function SharecountDigit() {
        $('#write_interview_question').on('keyup', function (e) {
            var valueLenght = this.value.length;
            $('#count-digit').html(valueLenght);
            if (valueLenght >= 150) {
                $('.shareinterview-text-count').css('color', 'red');
                $(this).addClass('select-error');
                return false;
            } else {
                $('.shareinterview-text-count').css('color', '#9c9c9c');
                $(this).removeClass('select-error');

            }

            return true;

        });
    }
    SharecountDigit();

    $('#ShareInterview').on('click', function () {
        $('#ShareInterviewModal').modal('show');
    });

    $('#share_interview_submit').on('click', function () {

        var valueLenght = $('#write_interview_question').val().length;
        if (valueLenght >= 150 || valueLenght == '') {
            $('#write_interview_question').addClass('select-error');
        } else {
            let myForm = $('form#interview-form');
            let formData = new FormData(myForm[0]);
            formData.append('action', 'jp_ajax');
            formData.append('requestType', 'ShareQuestion');

            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    Swal.fire({
                        type: 'info',
                        title: 'Please wait few minuts...',
                        showConfirmButton: false
                    });
                },
                success: function (response) {
                    $('#ShareInterviewModal').modal('hide');
                    $('form#interview-form')[0].reset();
                    Swal.fire(
                        'Add Interview Question!',
                        'Waiting for admin approval!',
                        'success'
                    );
                    // $('.ask_question').prepend('<li class="ask-list"><h3>' + response.data + '<h3></li>');
                }

            });
        }


    });




    function PostFieldsRequied () {

        if ($('select[name=case_cat').val() == 0) {
            $('select[name=case_cat').addClass('errors_input_fields');
            $('body').prepend('<div class="alert alert-danger alert-dismissible fade show" id="alert-message" role="alert">Category fields is required!  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></div>');
            $(".alert").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert").slideUp(500);
                $("#alert-message").remove();
            });

            return false;
        }
        if ($('input[name=title').val() == 0) {
            $('input[name=title').addClass('errors_input_fields');
            $('body').prepend('<div class="alert alert-danger alert-dismissible fade show" id="alert-message"  role="alert">Title fields is required!  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></div>');
            $(".alert").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(500);
                $("#alert-message").remove();
            });
            return false;
        }

        if (tinyMCE.activeEditor.getContent() == 0) {
            $('body').prepend('<div class="alert alert-danger alert-dismissible fade show" id="alert-message"  role="alert">Discrption fields is required!  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></div>');
            $(".alert").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(500);
                $("#alert-message").remove();
            });
            return false;
        }
        
        if ($('input[name=header_img').val() == 0) {
            $('input[name=header_img').addClass('errors_input_fields');
            $('body').prepend('<div class="alert alert-danger alert-dismissible fade show" id="alert-message"  role="alert">Header Image fields is required!  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></div>');
            $(".alert").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(500);
                $("#alert-message").remove();
            });
            return false;
        }

        if ($('input[name=header_featured').val() == 0) {
            $('input[name=header_featured').addClass('errors_input_fields');
            $('body').prepend('<div class="alert alert-danger alert-dismissible fade show" id="alert-message"  role="alert">Featured Image fields is required!  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></div>');
            $(".alert").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(500);
                $("#alert-message").remove();
            });
            return false;
        }

        
        return true;
    }

    function HeaderImageDimention() {
        var _URL = window.URL || window.webkitURL;

        $('#header_img').change(function (e) {
            var file, img;

            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    if (this.width == 1300 && this.height == 540) {
                        $('.header-cover').removeClass('image-size-err');
                    }
                     else{
                         $('.header-cover').addClass('image-size-err');
                     };
                    // alert(this.width + " " + this.height);
                };
                img.onerror = function () {
                    alert("not a valid file: " + file.type);
                };
                img.src = _URL.createObjectURL(file);
                

            }
        });
    }
    function FeaturedDimention() {
        var _URL = window.URL || window.webkitURL;

        $('#header_featured').change(function (e) {
            var file, img;

            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    if (this.width == 180 && this.height == 180) {
                        $('.featured-post').removeClass('image-size-err');
                    }
                     else{
                         $('.featured-post').addClass('image-size-err');
                     };
                    // alert(this.width + " " + this.height);
                };
                img.onerror = function () {
                    alert("not a valid file: " + file.type);
                };
                img.src = _URL.createObjectURL(file);
                

            }
        });
    }
    
   HeaderImageDimention();
   FeaturedDimention();
   

    $('#job-submit').on('click', function(e){
            if (PostFieldsRequied() === true){
                var content = tinyMCE.activeEditor.getContent();
                let myForm = $('form#add-post-job');
                let formData = new FormData(myForm[0]);
                let files = jQuery('#header_featured')[0].files[0];

                formData.append('action', 'jp_ajax');
                formData.append('requestType', 'AddPost');
                formData.append('discription', content);
                formData.append('header_featured', files);

                $.ajax({
                    url: jpAjax.ajaxurl,
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function () {
                        Swal.fire({ 
                            type: 'info',
                            title: 'Loading...',
                            showConfirmButton: false
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        if (response.image_errors){
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Image Size is wrong!',
                            });
                        }else{
                            $('form#add-post-job')[0].reset();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                type: 'success',
                                title: 'Submit your post!'
                            });
                            setTimeout(function () {
                                window.location.reload(1);
                            }, 2000);

                        }



                    },
                    error : function (response){
                        console.log(response);
                    }

                });

            }
            
    });

    $('#job-update').on('click', function (e) {
            var post_id  = $('.post-form').data('id');
            var content = tinyMCE.activeEditor.getContent();
            let myForm = $('form#edit-post-job');
            let formData = new FormData(myForm[0]);
            let files = jQuery('#header_featured')[0].files[0];

            formData.append('postid', post_id);
            formData.append('action', 'jp_ajax');
            formData.append('requestType', 'EditPost');
            formData.append('discription', content);
            formData.append('header_featured', files);
            $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    Swal.fire({ 
                        type: 'info',
                        title: 'Please wait few minuts...',
                        showConfirmButton: false
                    })
                },
                success: function (response) {
                    console.log(response)
                    if (response.header_img){
                        $('#headerSize').addClass('error');
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'image size is wrong!'
                            });
                    } 
                    else{
                        $('form#edit-post-job')[0].reset();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            type: 'success',
                            title: 'Update your post!'
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }

                }

            });
    });

    $(".form-pagination").on('click', '.next, .previous', function () {
        var currentEle = $(this),
            parentEl = currentEle.parents('fieldset'),
            parentElId = parentEl.attr('id');
        if (currentEle.hasClass('next')) {
            if(parentEl.is('#one')){
                let myForm = $(this).parents('form#msform'); 
                if(profileformvalidation(myForm)){
                    $('#progressbar').find('li').removeClass('active');
                    $('#progressbar').find('li[data-id="' + parentElId + '"]').next().addClass('active');
                    parentEl.slideUp(0).next().addClass('active').slideDown(0).siblings().removeClass('active');
                }
            }else{
                $('#progressbar').find('li').removeClass('active');
                $('#progressbar').find('li[data-id="' + parentElId + '"]').next().addClass('active');
                parentEl.slideUp(0).next().addClass('active').slideDown(0).siblings().removeClass('active');
            }
        }
        if (currentEle.hasClass('previous')) {
            $('#progressbar').find('li').removeClass('active');
            $('#progressbar').find('li[data-id="' + parentElId + '"]').prev().addClass('active');
            parentEl.slideUp(0).prev().addClass('active').slideDown(0).siblings().removeClass('active');
        }
    });

    $('.account-settings-section #progressbar li').on('click', function(){
        let myForm = $(this).parents('form#msform'); 
        if(profileformvalidation(myForm)){
            let id = $(this).attr('data-id');
            $(this).addClass('active').siblings().removeClass('active');
            $('.account-settings-section').find('fieldset').slideUp(0);
            $('.account-settings-section').find('fieldset#'+id).slideDown(0);
        }
    });

    // J0b Step 1
    function JobStep1(){

        var company_name = $('input[name=company_name]').val();
        var city = $('input[name=city]').val();
        var country = $('input[name=country]').val();
        var company_logo = $('input[name=company_logo]').val();
        var company_logo = $('input[name=company_logo]').val();
        var company_website_link = $('input[name=company_website_link]').val();
        
        if (company_name == 0) {
            $('#CompanyName').addClass('errors-form');
            $('#CompanyName').parent().append('<p id="error-message">Fields is Required!</p>');
            $("#error-message").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-message").slideUp(500);
                $("#error-message").remove();
                $('#CompanyName').removeClass('errors-form');
            });
            return false;
        }
        else if (city == 0) {
            $('#City').addClass('errors-form');
            $('#City').parent().append('<p id="error-message">Fields is Required!</p>');
            $("#error-message").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-message").slideUp(500);
                $("#error-message").remove();
                $('#City').removeClass('errors-form');
            });
            return false;
        }
        else if (country == 0) {
            $('#Country').addClass('errors-form');
            $('#Country').addClass('errors-form');
            $('#Country').parent().append('<p id="error-message">Fields is Required!</p>');
            $("#error-message").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-message").slideUp(500);
                $("#error-message").remove();
                $('#Country').removeClass('errors-form');
            });
            return false;
        }
        else if (company_logo == 0) {
           $('#company_logo').addClass('errors-form');
            $('#company_logo').addClass('errors-form');
            $('#company_logo').parent().append('<p id="error-message">Fields is Required!</p>');
            $("#error-message").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-message").slideUp(500);
                $("#error-message").remove();
                $('#company_logo').removeClass('errors-form');
            });
           return false;
        }
        else if (company_website_link == 0) {
           $('#CompanyWebsiteLink').addClass('errors-form');
            $('#CompanyWebsiteLink').addClass('errors-form');
            $('#CompanyWebsiteLink').parent().append('<p id="error-message">Fields is Required!</p>');
            $("#error-message").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-message").slideUp(500);
                $("#error-message").remove();
                $('#CompanyWebsiteLink').removeClass('errors-form');
            });
           return false;
        }

        return true;

    }

    function JobStep2() {
        var job_title = $('input[name=job_title]').val();
        if (job_title == 0) {
            $('#JobTitle').addClass('errors-form');
            $('#JobTitle').parent().append('<p id="error-message">Fields is Required!</p>');
            $("#error-message").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-message").slideUp(500);
                $("#error-message").remove();
                $('#JobTitle').removeClass('errors-form');
            });
            return false;
        }
        return true;
    }
    
    function JobStep3() {
        var number_of_days = $('input[name=number_of_days]').val();
        if (number_of_days == 0) {
            $('#NumberOfDays').addClass('errors-form');
            $('#NumberOfDays').parent().append('<p id="error-message">Fields is Required!</p>');
            $("#error-message").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-message").slideUp(500);
                $("#error-message").remove();
                $('#NumberOfDays').removeClass('errors-form');
            });
            return false;
        }
        return true;
    }

    //job
    
    $(".form-pagination").on('click', '.job-next, .previous', function () {
        // Step 1

        if(JobStep1() === true ){
            var currentEle = $(this),
                parentEl = currentEle.parents('fieldset'),
                parentElId = parentEl.attr('id');
            if (currentEle.hasClass('job-next')) {
                $('#progressbar').find('li').removeClass('active');
                $('#progressbar').find('li[data-id="' + parentElId + '"]').next().addClass('active');
                parentEl.slideUp(0).next().addClass('active').slideDown(0).siblings().removeClass('active');
                //}
            }
            if (currentEle.hasClass('previous')) {
                $('#progressbar').find('li').removeClass('active');
                $('#progressbar').find('li[data-id="' + parentElId + '"]').prev().addClass('active');
                parentEl.slideUp(0).prev().addClass('active').slideDown(0).siblings().removeClass('active');
            }
        } 

    });

    $(".form-pagination").on('click', '.job-next2, .previous', function () {
        // Step 1

        if (JobStep2() === true) {
            var currentEle = $(this),
                parentEl = currentEle.parents('fieldset'),
                parentElId = parentEl.attr('id');
            if (currentEle.hasClass('job-next2')) {
                $('#progressbar').find('li').removeClass('active');
                $('#progressbar').find('li[data-id="' + parentElId + '"]').next().addClass('active');
                parentEl.slideUp(0).next().addClass('active').slideDown(0).siblings().removeClass('active');
                //}
            }
            if (currentEle.hasClass('previous')) {
                $('#progressbar').find('li').removeClass('active');
                $('#progressbar').find('li[data-id="' + parentElId + '"]').prev().addClass('active');
                parentEl.slideUp(0).prev().addClass('active').slideDown(0).siblings().removeClass('active');
            }
        }


    });

    $('.view-full-profile').on('click', function(event){
        event.preventDefault();
        if( $(this).find('i.fa').hasClass('fa-angle-down') ){
            $(this).find('i.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
        }else if( $(this).find('i.fa').hasClass('fa-angle-up') ){
            $(this).find('i.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
        }
        $('.profile-full-view').slideToggle();
    });

    // Post Delete
    $('.post-delete').on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            console.log('delete actions');
            if (result.value) {
                var slug = $(this).data('id');
                $('#items-' + slug).remove();
                var request = $.ajax({
                    url: jpAjax.ajaxurl,
                    type: 'POST',
                    data: {
                        id: slug,
                        requestType: 'DeletedPost',
                        action: 'jp_ajax'
                    },

                    beforeSend: function () {
                        Swal.fire({ 
                            type: 'info',
                            title: 'Please wait few minuts...',
                            showConfirmButton: false
                        });                        
                    },
                    success: function (response) {
                        Swal.close();
                    }

                });
                
            }
        })

    });

        

    // Post Comment Sections 
    $('#post-comment-publish').on('click', function (e) {
        e.preventDefault();
        
            let myForm = $('form#comment_section_form');
            let formData = new FormData(myForm[0]);
            formData.append('action', 'jp_ajax');
            formData.append('requestType', 'PostComments');

            var request = $.ajax({
                url: jpAjax.ajaxurl,
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                data: formData,
                beforeSend: function () {

                },
                success: function (response) {
                  $('#comment_section_form')[0].reset();
                  $('.comment-all').prepend(response.data);
                }

            });
     
            

    });

    var check = true;
    $(window).scroll(function () { 
        if( $('.top-ux-stoires-container').length > 0 ){ 
            var parentEl = $('.top-ux-stories'); 
            var scrollTop = $(document).scrollTop();
            var docHeight = $(document).height();
            var winHeight = $(window).height();
            var currentSP = ( scrollTop + winHeight );
            var currentEP = docHeight - 400;

            var elheight = $('.top-ux-stoires-container').height();
            var eloffsetTop = $('.top-ux-stoires-container').offset().top;
            currentEP = elheight + eloffsetTop;
            var that = parentEl; 
            var page = that.attr('data-page'); 

            if (currentSP > currentEP && check && page != 'loaded') {
                check = false;
                $.ajax({
                    url: jpAjax.ajaxurl,
                    type: 'POST', 
                    data: {
                        page: page,
                        requestType: 'TopStoriesPosts',
                        action: 'jp_ajax'
                    },

                    beforeSend: function (response) {

                    },
                    success: function (response) {
                        that.attr('data-page', response.nextpage);
                        // console.log(that.attr('data-page', newPage));
                        $('.top-ux-stoires-container').append(response.data);
                        check = true;
                    }

                });
            }
        }

    });

    

// $('.heateor_sss_sharing_ul').prepend('<li class="heateorSssSharingRound"><div class="love-btn"><a id="love-react" data-id="1" data-post = "<?php echo ; ?>" href="#"><i class="fa fa-heart" aria-hidden="true"></i></a></li>');

// Nav title remove
  $('nav li a').removeAttr('title');
  

})(jQuery);

function previewFile() {
    jQuery('#p1').remove();
    var preview = document.querySelector('#preview-img');
    var file = document.querySelector('#header_img').files[0];
    var reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

function previewFile2() {
    jQuery('#p2').remove();
    var preview = document.querySelector('#preview-img2');
    var file = document.querySelector('#header_featured').files[0];
    var reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

function previewFile3() {
    jQuery('#p3').remove();
    var preview = document.querySelector('#preview-img3');
    var file = document.querySelector('#company_logo').files[0];
    var reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

function previewFile4() {
    jQuery('#p3').remove();
    var preview = document.querySelector('#preview4');
    var file = document.querySelector('#featued_resourse').files[0];
    var reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}




