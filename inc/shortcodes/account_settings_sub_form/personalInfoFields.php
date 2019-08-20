<?php
function getexperience($current_user){
    $output = '';
    $experience = esc_attr(get_user_meta($current_user->ID, 'experience', true)); 
    $output .= '<select class="theme-select" name="experience">';
        $output .= '<option value selected>Select Year of Experience</option>';
        for($i=1; $i <= 15; $i++){
            if($experience == $i){
                $output .= '<option value="'.$i.'" selected>'.$i.'</option>';
            }else{
                $output .= '<option value="'.$i.'">'.$i.'</option>';
            }
        }
        if( $experience == 16 ){
            $output .= '<option value="16" selected>15 Plus</option>';
        }else{
            $output .= '<option value="16">15 Plus</option>';
        }
    $output .= '</select>';
    return $output;
}
// echo '<pre>';
// print_r(get_user_meta($current_user->ID));
// echo '</pre>';
$output = '<fieldset id="one">
    <div class="row">
        <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2">
            <div class="update-profile flex-container">
                <div class="img"> 
                    '.displayProfileImage($current_user).'
                </div>
                <div class="update-btn">
                <p>Upload a good picture of your min 650px X 650px</p>
                <input id="profile-image" type="file" name="file-input" id="file-input">
                <span class="upload-preview-btn">Upload</span>
                </div>
            </div>        
        </div>
    </div>
    <div class="row">
       <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2"> 
        <div class="form-field '.is_val_empty($current_user->user_firstname).'">
            <div class="form-field__control">
            <label for="CompanyName" class="form-field__label">Name</label>
            <input id="CompanyName" type="text" name="name" class="form-field__input" value="'.esc_attr($current_user->user_firstname).'"/>
            </div>
        </div>
       </div> 
    </div>';
if(!in_array('job_recruiter', $current_user->roles)){
$output .=  '<div class="row">
                <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2"> 
                    <div class="form-field '.is_val_empty(get_user_meta($current_user->ID, 'designation', true)).'">
                        <div class="form-field__control">
                        <label for="CompanyName" class="form-field__label">Designation</label>
                        <input id="CompanyName" type="text" name="designation" class="form-field__input" value="'.esc_attr(get_user_meta($current_user->ID, 'designation', true)).'" />
                        </div>
                    </div>
                </div>      
            </div>
            <div class="row">
                <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2"> 
                    <div class="date-section-dropdown experience-warp"> 
                        <label id="experience" class="field" for="experience" data-value="Select role">Yeara Of Experience</label> 
                        '.getexperience($current_user).'
                    </div> 
                </div>    
            </div>';
}
$output .= '<div class="row">
                <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2">
                    <div class="form-field '.is_val_empty(get_user_meta($current_user->ID, 'phone', true)).'">
                        <div class="form-field__control">
                        <label for="CompanyName" class="form-field__label">Phone</label>
                        <input id="CompanyName" type="text" name="phone" class="form-field__input" value="'.esc_attr(get_user_meta($current_user->ID, 'phone', true)).'" />
                        </div>
                    </div>
                </div>
            </div>

        <div class="row">
            <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2">
                <div class="form-field '.is_val_empty(get_user_meta($current_user->ID, 'address', true)).'">
                    <div class="form-field__control">
                    <label for="CompanyName" class="form-field__label">Address</label>
                    <input id="CompanyName" type="text" name="address" class="form-field__input" value="'.esc_attr(get_user_meta($current_user->ID, 'address', true)).'" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 offset-xl-0 col-lg-8 offset-lg-2">
                <div class="form-field '.is_val_empty(get_user_meta($current_user->ID, 'city', true)).'">
                    <div class="form-field__control">
                        <label for="City" class="form-field__label">City</label>
                        <input id="City" type="text" name="city" class="form-field__input" value="'.esc_attr(get_user_meta($current_user->ID, 'city', true)).'"/>
                    </div>            
                </div>
            </div>        
            <div class="col-xl-6 offset-xl-0 col-lg-8 offset-lg-2">
            <div class="form-field  '.is_val_empty(get_user_meta($current_user->ID, 'country', true)).'">
                    <div class="form-field__control">
                    <label for="Country" class="form-field__label">Country</label>
                    <input id="Country" type="text" name="country" class="form-field__input" value="'.esc_attr(get_user_meta($current_user->ID, 'country', true)).'" />
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2">
            <div class="form-field '.is_val_empty($current_user->user_url).'">
            <div class="form-field__control">
            <label for="CompanyName" class="form-field__label">Website (Optional)</label>
            <input id="CompanyName" type="text" name="website" class="form-field__input" value="'.esc_attr($current_user->user_url).'" />
            </div>
        </div>
    </div>

    </div>
    <div class="row">
        <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2">
            <div class="form-field '.is_val_empty(get_user_meta($current_user->ID, 'introduction', true)).'">
                <div class="form-field__control">
                    <label for="CompanyName" class="form-field__label">Introduction (Optional)</label> 
                    <textarea name="introduction" class="form-field__input" rows="6">'.esc_attr(get_user_meta($current_user->ID, 'introduction', true)).'</textarea>
                    <span class="count">0/450</span>
                </div>
            </div>        
        </div>
    </div>';

    if(is_ux_professional()){ 
        $output .= '<div class="row"> 
                       <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2">
                            <div class="form-field">
                                <div class="form-field__control">';
                                $phonePrivate = get_user_meta($current_user->ID, 'phone_address_private', true);
                                if( $phonePrivate == 'yes' ){
                                    $output .= '<input class="styled-checkbox" type="checkbox" name="phone_address_private" value="yes" checked>';
                                }else{
                                    $output .= '<input class="styled-checkbox" type="checkbox" name="phone_address_private" value="yes">';
                                }
                                $output .= '<label for="styled-checkbox-1">Make your phone number and Address info private </label>
                                </div> 
                            </div>
                       </div>
                    </div>';
    }

    $output .= '<div class="form-pagination w-100">
    <a class="bg-none-with-border update user-profile-submit" href="">Update Information</a>';
    if(!in_array('job_recruiter', $current_user->roles)){
        $output .= '<input type="button" name="next" class="next action-button" value="ADD WORK EXPERIENCE" />';
    }
$output .= '</div></fieldset>';
echo $output;