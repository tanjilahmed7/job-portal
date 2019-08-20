<?php
function job_user_signup( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Lets create space to store your stories for future.',
		'sub-title' => 'No worries, we made this process simple for youand it\'s Free forever'
	), $atts, 'bartag' );
    $outputHtml = '';
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
        <div class="sign-up-form">
            <div class="sign-up-container">
                <div class="tab-slider--nav">
                    <ul class="tab-slider--tabs">
                    <li class="tab-slider--trigger active" rel="tab1">UX PRofessional
                        <input type="radio" name="reg_type" value="ux_professional" checked>
                    </li>
                    <li class="tab-slider--trigger" rel="tab2">Job Recruiter
                        <input type="radio" name="reg_type" value="job_recruiter" >
                    </li>
                    </ul>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body">
                    <div class="form-sign-up">
                        <form id="signup-ux" action"" method="post">
                            <div class="row">
                                <div class="col-sm">
                                <div class="form-field">
                                    <div class="form-field__control">
                                    <label for="rfirstname" class="form-field__label">Name</label>
                                    <input id="rfirstname" type="text" name="fullname" class="form-field__input" />
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                <div class="form-field">
                                    <div class="form-field__control">
                                    <label for="remail"class="form-field__label">Email</label>
                                    <input id="remail" type="email" name="email" class="form-field__input" />
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                <div class="form-field">
                                    <div class="form-field__control">
                                    <label for="rpassword"class="form-field__label">Password</label>
                                    <input id="rpassword" type="password" name="password" class="form-field__input" />
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                <div class="form-field">
                                    <div class="form-field__control">
                                        <input class="styled-checkbox" id="rstyled-checkbox-1" type="checkbox" name="stories_mail" value="yes" checked>
                                        <label for="rstyled-checkbox-1">Like to received new stories in mail box? We never smap. We never sm
                                            We never smapp.</label>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-btn w-100">
                                    <a href="#"  class="btn-theme-btn signup-submit">Create space</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="below-msg">
                                   <p>By clicking "Create Space" I agree to InVision\'s <a href="'.home_url('/terms-of-service').'">Terms of Service</a> and <a href="'.home_url('/privacy-policy').'">Privacy Policy</a>.</p>
                                </div>
                            </div>
                        </form>  
                    </div>
                    </div>
                    <div id="tab2" class="tab-slider--body">
                        <div class="form-sign-up">
                            <form  id="signup-jr" action"" method="post">
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                        <label for="firstname" class="form-field__label">Name</label>
                                        <input id="firstname" type="text" name="fullname" class="form-field__input" />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                        <label for="email"class="form-field__label">Email</label>
                                        <input id="email" type="email" name="email" class="form-field__input" />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                        <label for="password"class="form-field__label">Password</label>
                                        <input id="password" type="password" name="password" class="form-field__input" />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                        <label for="phone"class="form-field__label">Phone</label>
                                        <input id="phone" type="text" name="phone" class="form-field__input" />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                        <label for="address"class="form-field__label">Address</label>
                                        <input id="address" type="text" name="address" class="form-field__input" />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                        <label for="city"class="form-field__label">City</label>
                                        <input id="city" type="text" name="city" class="form-field__input" />
                                        </div>
                                    </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-field">
                                        <div class="form-field__control">
                                            <label for="website"class="form-field__label">Website</label>
                                            <input id="website" type="text" name="website" class="form-field__input" />
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" name="stories_mail" value="yes" checked>
                                            <label for="styled-checkbox-1">Like to received new stories in mail box? We never smap. We never sm
                                                We never smapp.</label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-btn w-100">
                                    <a href="#" class="btn-theme-btn signup-submit">Create space</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="below-msg">
                                        <p>By clicking "Create Space" I agree to InVision\'s <a href="'.home_url('/terms-of-service').'">Terms of Service</a> and <a href="'.home_url('/privacy-policy').'">Privacy Policy</a>.</p>
                                    </div>
                                </div>
                            </form> 
                        </div>

                    </div>
                    </div>
                </div>
                </div>
        </div>
    </div> ';
	return $outputHtml;
}
add_shortcode( 'job_user_signup', 'job_user_signup' );