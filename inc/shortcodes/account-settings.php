<?php
function account_settings( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Account Settings',
		'sub-title' => 'Complete your account settings to looks professional'
	), $atts, 'bartag' );
    $outputHtml = '';
    $current_user = wp_get_current_user(); 
    // print_r( in_array('job_recruiter', $current_user->roles) );
    ob_start();
    if(!in_array('job_recruiter', $current_user->roles)){
      include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/addExpericenceModal.php';
      include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/editExpericenceModal.php';
      include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/deleteExpericenceModal.php';
      include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/addeduModal.php';
      include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/editeduModal.php'; 
    }
    include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/lodingModal.php';
    function is_val_empty($value){
      return !empty($value) ? 'form-field--is-filled' : '';
    }

    function displayProfileImage($current_user){
        $image = wp_get_attachment_url( get_user_meta($current_user->ID, 'profile_image', true) );
        if( !empty($image) ){
          return '<img src="'.$image.'" alt="">';
        }else{
          return '<img src="'.get_template_directory_uri().'/assets/img/plato.png" alt="">';
        }
    } 

    $account_settings_sub_forms = ob_get_contents();
    ob_end_clean();
    $outputHtml .= $account_settings_sub_forms;
    $outputHtml .= '
    <div class="col-xl-12">
        <div class="header-text-panel-without-bg w-100">
            <section class="head-content flex-container">
                <div class="text-area">
                <h1>'.$atts['title'].'</h1>
                <p>'.$atts['sub-title'].'</p>
                </div>
            </section>
        </div>
    </div> 
    <div class="col-xl-8 offset-xl-2">
          <form id="msform" class="account-settings-section">';
    if(!in_array('job_recruiter', $current_user->roles)){
      $outputHtml .= '<div class="manage-menu d-xl-block d-lg-block d-md-block d-sm-none">
                        <ul id="progressbar">
                          <li class="active" data-id="one">Personal Info</li>
                          <li data-id="two">Work Experience</li>
                          <li data-id="three">Education</li>
                          <li data-id="four">Skils</li>
                          <li data-id="five">Social Profiles</li>
                        </ul>
                      </div>'; 
    }

    ob_start();  
      include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/personalInfoFields.php';
      if(!in_array('job_recruiter', $current_user->roles)){
        include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/workExperienceFields.php';
        include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/educationFields.php';
        include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/skilsFields.php';
        include JP_PLUGIN_PATH. 'inc/shortcodes/account_settings_sub_form/socialFields.php';
      }
    $account_settings_fields = ob_get_contents();
    ob_end_clean();    
    $outputHtml .= $account_settings_fields;
            
    $outputHtml .= '</form></div>';
	return $outputHtml;
}
add_shortcode( 'account_settings', 'account_settings' );