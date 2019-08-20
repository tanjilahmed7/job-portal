<?php
function member_profile( $atts ) { 
	$atts = shortcode_atts( array(
        'userid'    => false,
		'title'     => 'Interview Questions',
		'sub-title' => 'How to prepare for a UX Interview'
	), $atts, 'bartag' );
    $outputHtml = ''; 

    if( isset($_GET['user']) && !empty($_GET['user']) ){
        $userID = (int)$_GET['user']; 
        $user = get_user_by('id', $userID);
        if(is_user_logged_in()){  
            $CurrentUser = wp_get_current_user(); 
        }
    }else{
        if(is_user_logged_in()){  
            $user = wp_get_current_user(); 
        }else{
            echo '<script>window.location.href = "'.home_url().'"</script>';
        }
    }

    if($user){ 
        $flowersStatus  = null;
        $flowersCount   = 0.0;
        $followingCount  = 0.0;
        $fanObj         = new JP_FollowAndNotification();
        $flowersCount   = $fanObj->countFollowersByUserID($user->ID);
        $followingCount = $fanObj->countFolloweingByUserID($user->ID);

        if(is_user_logged_in() && isset($CurrentUser)){   
            if($fanObj->isUserFollowing($user->ID, $CurrentUser->ID)){ 
                $flowersStatus = 'unfollow'; 
            }else{
                $flowersStatus = 'follow';
            }
        }
    } 

    if(!empty($user)){ 
        $outputHtml .= '
            <div class="col-xl-12 member-profile">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="member-name">
                                    <div class="avater d-lg-none d-xl-none">'.ProfileImage($user).'</div>
                                    <h3>'.get_user_meta($user->ID, 'first_name', true).' '.get_user_meta($user->ID, 'last_name', true).'</h3>
                                    <p>'.get_user_meta($user->ID, 'designation', true).'</p>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="followers">
                                    <ul> 
                                        <li>'.$followingCount.' '.' Following </li>
                                        <li>'.$flowersCount.' '.' Followers </li>
                                    </ul>
                                </div>';
            if(isset($flowersStatus)){
                $outputHtml .= '<a id="ux-user-flowing" href="" data-status="'.$flowersStatus.'" data-id="'.$user->ID.'" class="follow">'.$flowersStatus.'</a>';
            }
            $outputHtml .= '</div>
                            <div class="col-xl-12">
                                <div class="profile-bio">
                                    <article>
                                            <p>'.get_user_meta($user->ID, 'introduction', true).'</p>
                                    </article>
                                    <div class="story-btn">
                                        <a href="#" class="btn-theme-btn view-full-profile">View Full Profile <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 d-xl-block d-lg-block d-md-none d-sm-none">
                        <div class="avater">'.ProfileImage($user).'</div>
                    </div>
                </div>
            </div>';  
        
        ob_start();  
            include JP_PLUGIN_PATH. 'inc/shortcodes/profile_sub_element/exprience.php';
            include JP_PLUGIN_PATH. 'inc/shortcodes/profile_sub_element/education.php';
            include JP_PLUGIN_PATH. 'inc/shortcodes/profile_sub_element/skill.php';
            include JP_PLUGIN_PATH. 'inc/shortcodes/profile_sub_element/personal.php';
            $informaltion = ob_get_contents();
        ob_end_clean();    
        $outputHtml .= $informaltion;
        
        // stories
        $outputHtml .= '
            <h2 class="stoties-title">Stories</h2>
            <div class="ux-ebooks-items latest-stories member-profile-stories">
                <div class="col-xl-12">
                <div class="row">';
                if($user->ID){
                    $args = array(
                        'author'        =>  $user->ID,
                        'post_type' => 'post',
                        'tax_query' => array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'slug',
                                'terms'    => 'case-study',
                            ),
                        ),                        
                    );
                    // The Query
                    $stories = new WP_Query( $args );
                    if($stories->have_posts()){
                        while ( $stories->have_posts() ) {
                            $stories->the_post();
                            global $post;
                            $terms = get_the_terms($post->ID, 'category' );
                        $outputHtml .= '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <div class="top-item">
                                    <div class="image">
                                        <a href="'. get_permalink($post->ID) .'"><img src="'.get_the_post_thumbnail_url($post->id,'case-studies').'" alt=""></a>
                                    </div>
                                    <div class="content">
                                        <span class="download-type">'.$terms[0]->name.'</span>
                                        <h4><a href="'. get_permalink($post->ID) .'">'.get_the_title().'</a></h4>
                                    </div>
                                </div> 
                            </div>';
                        }
                    }else{
                        $outputHtml .= '<div class="empty-msg">Stories hasn\'t added yet</div>';
                    }
                }
    $outputHtml .= '</div>   
                </div>
            </div>';
        //$outputHtml .= '</div>';
    }
	return $outputHtml;
}
add_shortcode( 'member_profile', 'member_profile' );