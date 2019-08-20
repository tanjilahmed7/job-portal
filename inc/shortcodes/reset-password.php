<?php
function job_reset_password( $atts ) {
	$atts = shortcode_atts( array( 
        'title' => 'Forgot your password ?',
		'sub-title' => 'We\'ll help you reset it and get back on track'
    ), $atts, 'bartag' );
    global $redux_job;

    $resetForm = false;
    if( isset($_GET['reset_code']) && !empty($_GET['reset_code']) ){
        
        $reset_code = $_GET['reset_code'];
        $token =  base64_decode( $reset_code ); 
        $tokenArray =  explode( '/', $token ); 
        // var_dump($token);
        $user = get_user_by( 'email', $tokenArray[1] );
        
        if($user){
            $userResetCode = get_user_meta( $user->ID, '_job_reset_token' , true );
            if( ($user->ID == $tokenArray[0]) && ($userResetCode == $reset_code ) ){ 
                $resetForm = true;
            }
        }
    }

    $outputHtml = '';
    if(is_user_logged_in()){
        return '<script>window.location.href="'.home_url('/').$redux_job['job_account_page'].'"; </script>';
    }
    $outputHtml .= '
    <div class="col-md-12">
        <div class="header-text-panel-without-bg w-100">
            <section class="head-content flex-container">
                <div class="text-area">
                <h1>'.$atts['title'].'</h1>
                <p>'.$atts['sub-title'].'</p>
                </div>
            </section>
        </div>
    </div> 
    <div class="col-md-12">
        <div class="login-form">
            <form id="reset-pass" action"" method="post">';
            if( $resetForm == true ){
                $outputHtml .= '<input  type="hidden" name="_jb_token" value="'.$reset_code.'" />';
                $outputHtml .= '<input  type="hidden" name="_jb_user" value="'.$user->ID.'" />';
            }
            if($resetForm  != true){
                $outputHtml .= '<div class="row">
                                    <div class="col-sm">
                                        <div class="form-field">
                                            <div class="form-field__control">
                                            <label for="firstname" class="form-field__label">Email</label>
                                            <input id="firstname" type="text" name="email" class="form-field__input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            }
            if( $resetForm == true ){

            $outputHtml .= '<div class="row">
                                <div class="col-sm">
                                <div class="form-field">
                                    <div class="form-field__control">
                                    <label for="password"class="form-field__label">New Password</label>
                                    <input id="password" type="password" name="password" class="form-field__input" />
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                <div class="form-field">
                                    <div class="form-field__control">
                                    <label for="password"class="form-field__label">Confirm Password</label>
                                    <input id="password" type="password" name="confirm_password" class="form-field__input" />
                                    </div>
                                </div>
                                </div>
                            </div> ';
            }
            $outputHtml .= '<div class="row">
                <div class="form-btn w-100">';
                if( $resetForm == true ){
                    $outputHtml .= '<a href="" class="btn-theme-btn new-password-submit">Reset Password</a>';
                }else{
                    $outputHtml .= '<a href="" class="btn-theme-btn reset-password-submit">Reset Password</a>';
                }
            $outputHtml .= '</div>
                </div>
            </form>  
        </div>
    </div> ';
	return $outputHtml;
}
add_shortcode( 'user_reset_password', 'job_reset_password' );