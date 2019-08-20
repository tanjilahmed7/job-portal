<?php
function status_confirmation( $atts ) {
	$atts = shortcode_atts( array(
		'foo' => 'no foo',
		'baz' => 'default baz'
    ), $atts, 'bartag' );
    
    global $redux_job;
    $outputHtml = '';
    $activeAcount = false; 
    if( isset($_GET['activion_code']) && !empty($_GET['activion_code']) ){
        
        $activion_code = $_GET['activion_code'];
        $token =  base64_decode( $activion_code ); 
        $tokenArray =  explode( '/', $token ); 
        // var_dump($token);
        $user = get_user_by( 'email', $tokenArray[1] );
        
        if($user){
            $userActivitionCode = get_user_meta( $user->ID, '_activision_tokan' , true );
            if( ($user->ID == $tokenArray[0]) && ($userActivitionCode == $activion_code ) ){
                update_user_meta($user->ID, 'account_status', 'active' );
                $activeAcount = true;
            }
        }
    }
    $outputHtml .= '
    <div class="col-md-12">
        <div class="header-text-panel-without-bg w-100">
            <section class="head-content flex-container">
                <div class="text-area"> 
                <h3>Lets create space to store your stories for future.</h3>
                <p>No worries, we made this process simple for you and it’s Free forever. </p> 
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-12">';
        if($activeAcount === true){ 
            $outputHtml .= '<div class="verfiy-message">
                        <div class="text-area">
                            <p><span>Your Account Activeted</span></p>
                            <p><A href="'.home_url('/').$redux_job['job_login_page'].'">SignIn</a></p>
                        </div>
                    </div>';
        }
        if( ( isset($_GET['status']) && $_GET['status'] == 'cnfirm' ) && 
            (isset($_GET['email']) && !empty($_GET['email']) ) ){
            $outputHtml .= '<div class="verfiy-message">
                        <div class="text-area">
                            <p>You’re almost ready to write your UX stories, but first click the link in verify email which we’ve sent to <span>'.$_GET['email'].'</span></p>
                        </div>
                    </div>';
        }
        if( isset($_GET['status']) && $_GET['status'] == 'jpcrm'  ){
            $outputHtml .= '<div class="verfiy-message">
                        <div class="text-area">
                            <p><span>Please Check Your Mail</span></p>
                        </div>
                    </div>';
        }
        if( isset($_GET['status']) && $_GET['status'] == 'jppc'  ){
            $outputHtml .= '<div class="verfiy-message">
                        <div class="text-area">
                            <p><span>Password  Reset Successfully</span></p>
                            <p><A href="'.home_url('/').$redux_job['job_login_page'].'">SignIn</a></p>
                        </div>
                    </div>';
        }
    $outputHtml .= '</div>';
	return $outputHtml;
}
add_shortcode( 'status', 'status_confirmation' );