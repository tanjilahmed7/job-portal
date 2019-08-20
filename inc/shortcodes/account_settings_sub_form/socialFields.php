<fieldset id="five">
    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="icon">
                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                    <span>Linkdin</span>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6"> 
                <input type="text" name="social_linkdin" placeholder="Enter Profile Link" 
                value="<?php echo get_user_meta($current_user->ID, 'social_linkdin', true) ?>" >
            </div>
        </div>
    </div>
    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-dribbble" aria-hidden="true"></i>
                <span>Dribbble</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_bribbble" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_bribbble', true)) ?>" >
            </div>
        </div>
    </div>
    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-behance" aria-hidden="true"></i>
                <span>Behance</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_behance" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_linkdin', true)) ?>" >
            </div>
        </div>
    </div>
    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">
            <div class="icon">
                <i class="fa fa-google-plus" aria-hidden="true"></i>
                <span>Google+</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_google" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_google', true)) ?>" >
            </div>
        </div>
    </div>

    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                <span>Pinterest</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_pinterest" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_pinterest', true)) ?>" >
            </div>
        </div>
    </div>

    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-twitter" aria-hidden="true"></i>
                <span>Twitter</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_twitter" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_twitter', true)) ?>" >
            </div>
        </div>
    </div>

    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-facebook" aria-hidden="true"></i>
                <span>Facebook</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_facebook" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_facebook', true)) ?>" >
            </div>
        </div>
    </div>

    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-instagram" aria-hidden="true"></i>
                <span>Instagram</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_instagram" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_instagram', true)) ?>" >
            </div>
        </div>
    </div>

    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-youtube" aria-hidden="true"></i>
                <span>YouTube</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_youtube" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_youtube', true)) ?>" >
            </div>
        </div>
    </div>

    <div class="social-profiles">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <div class="icon">
                <i class="fa fa-medium" aria-hidden="true"></i>
                <span>Medium</span>
            </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <input type="text" name="social_medium" placeholder="Enter Profile Link" 
            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'social_medium', true)) ?>" >
            </div>
        </div>
    </div>

    <div class="form-pagination w-100">
    <a class="bg-none-with-border update user-profile-submit" href="">Update Information</a>
    </div>
</fieldset>