<?php
function ux_members_callback( $atts ) {

	$atts = shortcode_atts( array(
		'title' => 'UX professionals',
		'sub-title' => 'Reach 10000 plus of great UX candidates quickly.'
	), $atts, 'bartag' );
    $outputHtml = '';
    $members = get_users( [ 'role__in' => [ 'ux_professional'] ] );
    function displayProfileImage($current_user){
        $image = wp_get_attachment_url( get_user_meta($current_user->ID, 'profile_image', true) );
        if( !empty($image) ){
          return '<img src="'.$image.'" alt="">';
        }else{
          return '<img src="'.JP_PLUGIN_URI.'/assets/images/circle.png" alt="">';
        }
    } 
    
    global $redux_job; 
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
                    <div class="row">
                        <div id="ux-user-filter" class="member-filter job-search-form col-xl-10 offset-xl-2"> 
                                <div class="search-items">
                                    
                                    <div class="form-group">
                                        <img class="search-icon-ux-pro" src="'.get_template_directory_uri().'/assets/img/serarch-icon.png" alt="">
                                        <input type="text" class="form-control" name="name" id="search-job"  placeholder="Ux Professional Name">
                                    </div>
                                </div>
                                <div class="search-items">
                                    <div class="form-group">
                                        <img class="location-icon-ux-pro" src="'.get_template_directory_uri().'/assets/img/location.png" alt="">
                                        <input type="text" class="form-control" name="city" id="search-job"  placeholder="Search Location">
                                    </div>
                                </div>
                                <div class="search-items">
                                    <div class="form-group">
                                    <span class="number-of-count">0</span>
                                        <div class="dropdown">
                                            <a href="#"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-align-center" aria-hidden="true"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <ul class="filter-dropdown">';
                                            for($i=5; $i <= 15; $i+=5){
                                                $prev = $i == 0 ? $i: $i-5;
                                                $outputHtml .= '
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input exp" type="checkbox" name="exp[]" value="'.$i.'">
                                                        <label class="form-check-label">'.$prev.' - '.$i.' Exp</label>
                                                    </div>
                                                </li>'; 
                                            }
                                            $outputHtml .= '
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input exp" type="checkbox" name="exp[]" value="16">
                                                        <label class="form-check-label">15 + Exp</label>
                                                    </div>
                                                </li>
                                            </ul>'; 

                                $outputHtml .= '</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-items">
                                    <div class="form-group">
                                        <div class="find-btn">
                                            <a id="ux-user-filter-submit" href="#" class="filter-btn">Find</a>
                                        </div>
                                    </div>
                                </div> 
                        </div>
                    </div> 
                    <div class="col-xl-12">
                    <div class="row member-list-row">'; 
                        if( count($members) > 0 ){
                            foreach($members as $member){ 
                                $outputHtml .= '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                    <div class="members-list"> 
                                                        <div class="members">
                                                        
                                                            <div class="image"><a href="'.$redux_job['job_profile_page'].'?user='.$member->ID.'">'.displayProfileImage($member).'</a></div>
                                                            <div class="content">
                                                                <span class="location">'.esc_attr(get_user_meta($member->ID, 'city', true)).', '.esc_attr(get_user_meta($member->ID, 'country', true)).'</span>
                                                                <h3>'.esc_attr($member->user_firstname).' '.esc_attr($member->user_lastname).'</h3>
                                                                <p>'.get_user_meta($member->ID, 'designation', true).'</p>
                                                                <ul>
                                                                    <li>'.get_user_meta($member->ID, 'experience', true).' Yrs Experience </li>
                                                                    <li>'.get_user_meta($member->ID, '_job_flowers_count', true).' Followers</li>
                                                                </ul>
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                </div>';
                            }
                        } 


        $outputHtml .= ' </div>';
    $outputHtml .= ' </div>';
    
	return $outputHtml;
}
add_shortcode( 'ux_members', 'ux_members_callback' );