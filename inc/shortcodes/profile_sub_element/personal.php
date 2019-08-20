<?php

    $address = get_user_meta($user->ID, 'address', true);
    $city = get_user_meta($user->ID, 'city', true);
    $country = get_user_meta($user->ID, 'country', true);
    
?>
<div class="profile-full-view ">
    <div class="row">
        <div class="col-md-4">
            <h2>Personal</h2>
        </div>
        <div class="col-md-8">
        <?php if( !empty($address) && !empty($city) && !empty($country) ){ ?>
            <div class="row">
                <div class="col-md-4">
                    <h3>Contact</h3>
                    <ul class="skll-list">
                        <?php 
                            $phoneAddressPrivate = get_user_meta($user->ID, 'phone_address_private', true);
                            if( $phoneAddressPrivate != 'yes' ) {
                            echo '<li><a href="mailto:'.$user->user_email.'">'.$user->user_email.'</a></li>
                                <li><a href="tel:'.esc_attr(get_user_meta($user->ID, 'phone', true)).'">'.esc_attr(get_user_meta($user->ID, 'phone', true)).'</a></li>
                                <li><a href="'.$user->user_url.'">Visit Website</a></li>';
                            }else{
                                echo '<li><a href="mailto:'.$user->user_email.'">'.$user->user_email.'</a></li> 
                                <li><a href="'.$user->user_url.'">Visit Website</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Address</h3>
                    <ul class="skll-list">
                    <?php 
                        if( $phoneAddressPrivate != 'yes' ) {
                            echo '<li>'.esc_attr($address).'</li>
                                <li>'.esc_attr($city).', '.esc_attr($country).'</li>';
                        }
                    ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Social</h3>
                    <div class="social-list">
                    <?php
                        if(!empty(get_user_meta($user->ID, 'social_facebook', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_facebook', true).'"
                            class="icon"><i class="fa fa-facebook" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_twitter', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_twitter', true).'"
                            class="icon"><i class="fa fa-twitter" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_bribbble', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_bribbble', true).'"
                            class="icon"><i class="fa fa-dribbble" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_linkdin', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_linkdin', true).'"
                            class="icon"><i class="fa fa-linkedin" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_behance', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_behance', true).'"
                            class="icon"><i class="fa fa-behance" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_google', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_google', true).'"
                            class="icon"><i class="fa fa-google-plus" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_pinterest', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_pinterest', true).'"
                            class="icon"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_instagram', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_instagram', true).'"
                            class="icon"><i class="fa fa-instagram" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_youtube', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_youtube', true).'"
                            class="icon"><i class="fa fa-youtube" aria-hidden="true"></i></a> ';
                        }
                        if(!empty(get_user_meta($user->ID, 'social_medium', true))){
                            echo '<a target="_blank" href="'.get_user_meta($user->ID, 'social_medium', true).'"
                            class="icon"><i class="fa fa-medium" aria-hidden="true"></i></a> ';
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="download-resume">
                    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                        <input type="hidden" name="action" value="download_resume" >    
                        <input type="hidden" name="user" value="<?php echo $user->ID; ?>" > 
                        <input type="submit" value="Download Resume" >
                    </form>
                </div>
            </div>
        <?php 
            }else{
                echo '<div class="empty-msg">Personal Details hasn\'t added yet</div>';
            } 
        ?>
        </div>
    </div>
</div>