<?php
function job_user_login( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Welcome Back! good to see you again.',
        'sub-title' => 'Seems you would like to share something awesome with us.'
    ), $atts, 'bartag' );
    global $redux_job;
    $outputHtml = '';
    if(is_user_logged_in()){
        return '<script>window.location.href="'.home_url('/').$redux_job['job_account_page'].'"; </script>';
    }
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
    <div class="col-xl-12">
        <div class="login-form">
            <form id="login-user" action"" method="post">
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-field">
                        <div class="form-field__control">
                        <label for="firstname" class="form-field__label">Email</label>
                        <input id="firstname" type="text" name="email" class="form-field__input" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-field">
                        <div class="form-field__control">
                        <label for="password"class="form-field__label">Password</label>
                        <input id="password" type="password" name="password" class="form-field__input" />
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-xl-12">
                    <div class="forgot float-right">
                        <a href="'.home_url('/').$redux_job['job_reset_pass_page'].'">Forget Password</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-btn w-100">
                    <a href="" class="btn-theme-btn login-submit">Login</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="signup-link">
                        <p>Already have an account? <a href="/signup"><span>Sign Up</span></a></p>                    
                    </div>
                </div>
            </div>
            </form>  
        </div>
    </div> ';
	return $outputHtml;
}
add_shortcode( 'job_user_login', 'job_user_login' );