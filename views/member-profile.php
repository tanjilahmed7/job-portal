<!doctype html>
<html lang="en">
    <head>
        <title>Frontpage</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
<style> 
/* *{
    font-family: "Poppins", sans-serif;
} */
    table { 
        width: 100%;
        overflow: hidden;
        clear: both;
    }
    table.header
    table.header tr td:first-child {
        width: 75%;
        padding-right: 10px;
    }
    table.header tr td:first-child .title {
        margin-bottom: 20px;
    } 
    table.header tr td:last-child {
        width: 25%;
    }
    .avater {
        display: block;
        width: 100%;
        text-align: right;
    }
    .avater img {
        display: inline-block;
        width: 150px;
    }
    table.experience tr td.exp-title {
        width: 30%;
        vertical-align: top;
    }
    .skills {
        display: inline-block;
        width: 33.3333%; 
    }
    table.skills-table {
        clear: none;
    }
    table.experience.skills-warp tr td:last-child {
        vertical-align: top;
    }
    table.experience tr td table.skills-table td.skills {
        width: 33%;
        padding: 0px;
        margin: 0px;
        vertical-align: top;
    }
    ul.skll-list {
        margin: 0px;
        padding: 0px;
        list-style: none;
    }
    ul.skll-list.social-icons li {
        height: 16px;
        width: 16px;
        overflow: hidden;
        display: inline-block;
        margin-right: 15px;
        margin-bottom: 15px;
    }
    ul.skll-list.social-icons li img {
        height: 16px;
        width: 16px;
    }
    table.storis-warp tbody tr td {
        width: 25%;
        padding-right: 10px;
    }
    table.storis-warp tbody tr td img {
        width: 170px;
        display: block;
    }
    table.header tr td:first-child .title h3 {
        margin: 0px;
        font-weight: 700;
        font-size: 24px; 
        font-family: "Poppins", sans-serif;
    }
    table.header tr td:first-child .title p {
        margin: 0px;
        font-family: "Poppins", sans-serif;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #888;
    }
    table.header tr td:first-child p {
        font-family: "Poppins", sans-serif;
        font-size: 14px;
        line-height: 14px;
        margin: 0px;
        color: #000;
        font-weight: 500;
    }
table.experience {
    margin-top: 15px;
}
table.experience tr td .title h2 {
    margin: 0px;
    font-size: 24px;
    font-weight: 700;
    font-family: "Poppins", sans-serif;
}
table.experience tr td.exp-list h3 {
    margin: 0px;
    font-size: 18px;
    font-weight: 600;
    font-family: "Poppins", sans-serif;
}
table.experience tr td.exp-list span {
    font-size: 11px;
    color: #888;
    margin-bottom: 10px; 
    width: 100%;
    font-weight: 600;
    font-family: "Poppins", sans-serif;
}
table.experience tr td.exp-list p {
    font-size: 14px;
    line-height: 14px;
    font-weight: 500;
    font-family: "Poppins", sans-serif;
}
table.experience tr td.exp-list {
    overflow: hidden;
    clear: both;
    height: auto;
}
table.experience.skills-warp tr td:first-child {
    width: 30%;
    vertical-align: top;
}
table.experience.skills-warp tr td.skills h3 {
    font-size: 18px;
    font-weight: 600;
    font-family: "Poppins", sans-serif;
    margin-top: 0px;
    margin-bottom: 15px;
    margin-right: 0px;
    margin-left: 0px; 
}
table.experience tr td table.skills-table td.skills ul.skll-list li {
    font-size: 14px;
    font-weight: 400;
    font-family: "Poppins", sans-serif;
    margin-bottom: 0px;
}
table.experience tr td table.skills-table td.skills ul.skll-list.social-icons li {
    margin-right: 15px;
    margin-bottom: 15px;
}
table.experience tr td table.skills-table td.skills ul.skll-list.social-icons li:nth-child(5), 
table.experience tr td table.skills-table td.skills ul.skll-list.social-icons li:nth-child(9) {
    clear: right;
}
table.storis-warp tr td.storis-title h2 {
    margin-top: 0px;
    margin-left: 0px;
    margin-right: 0px;
    margin-bottom: 15px;
    font-size: 24px;
    font-weight: 700;
    font-family: "Poppins", sans-serif;
}
table.storis-warp tbody tr td span.case-stady {
    display: block;
    width: 100%;
    text-transform: uppercase;
    color: #4258fb;
    font-size: 11px;
    font-weight: 600;
    margin-top: 10px;
    font-family: "Poppins", sans-serif;
}
table.storis-warp tbody tr td h3 {
    font-size: 16px;
    font-weight: 600;
    margin-top: 10px;
    margin-left: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    font-family: "Poppins", sans-serif;
}
</style>
    </head>
    <body class="default"> 
        <table class="header"> 
            <tr>
                <td> 
                    <div class="title">
                        <h3><?php echo get_user_meta($user->ID, 'first_name', true).' '.get_user_meta($user->ID, 'last_name', true); ?></h3>
                        <p><?php echo get_user_meta($user->ID, 'designation', true); ?></p>
                    </div>
                    <p><?php echo get_user_meta($user->ID, 'introduction', true); ?></p>
                </td>
                <td>
                    <div class="avater">
                        <?php echo ProfileImage($user); ?>
                    </div>
                </td>
            </tr>
        </table>
        <table class="experience">
        <?php 
                $workExpericence = get_user_meta($user->ID, '_job_user_exp', true); 
                if( !empty($workExpericence) ){
                    $workExpericence =  unserialize($workExpericence);
                    //print_r($workExpericence);
                    $monthList = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    if(is_array($workExpericence) && count($workExpericence) > 0 ){
                        $ei = 1;
                        foreach($workExpericence as $workexp){ 
                            $start_month = (int)$workexp['start_month'];
                            $start_year = $workexp['start_year'];
                            $end_month = (int)$workexp['end_month'];
                            $end_year = $workexp['end_year'];
                            echo '<tr>';
                            if($ei == 1){
                                echo '
                                    <td class="exp-title"> 
                                        <div class="title">
                                            <h2>Experience</h2> 
                                        </div>  
                                    </td> 
                                ';
                            }else{
                                echo '<td></td>';
                            }
                            echo '<td class="exp-list">'; 
                                echo '<h3>'.$workexp['designation'].', '. $workexp['company_name'].'</h3>';
                                if( $workexp['current'] == 'yes' ){
                                    echo '<span>'.ucwords($monthList[$start_month]).' '.$start_year . ' -  PRESENT / '.$workexp['city']. ', ' .$workexp['country'].'</span>';
                                }else{
                                    echo '<span>'.ucwords($monthList[$start_month]).' '.$start_year . ' - '. ucwords($monthList[$end_month]). ' '.$end_year. ' / '.$workexp['city']. ', ' .$workexp['country'].'</span>';
                                }
                                echo '<p>'.$workexp['description'].'</p>';
                            echo '</td> ';
                            echo '</tr>';
                            $ei++;
                        }
                    }else{
                        echo '
                            <tr>
                                <td class="exp-title"> 
                                    <div class="title">
                                        <h2>Experience</h2> 
                                    </div>  
                                </td>
                                <td class=exp-list">Expericence hasn\'t added yet</td> 
                            </tr>
                        ';
                    }
                }else{
                    echo '
                        <tr>
                            <td class="exp-title"> 
                                <div class="title">
                                    <h2>Experience</h2> 
                                </div>  
                            </td>
                            <td class=exp-list">Expericence hasn\'t added yet</td> 
                        </tr>
                    ';
                }
        ?>  
        </table>
        <table class="experience education">
        <?php 
                $eductions = get_user_meta($user->ID, '_job_user_edu', true);
                if( !empty($eductions) ){
                    $eductions =  unserialize($eductions);
                    $monthList = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    if(is_array($eductions) && count($eductions) > 0 ){
                        $eudi = 1;
                        foreach($eductions as $key=>$edu){
                            $start_month = (int)$edu['start_month'];
                            $start_year = $edu['start_year'];
                            $end_month = (int)$edu['end_month'];
                            $end_year = $edu['end_year'];
                            echo '<tr>';
                            if($eudi == 1){
                                echo '
                                    <td class="exp-title"> 
                                        <div class="title">
                                            <h2>Education</h2> 
                                        </div>  
                                    </td> 
                                ';
                            }else{
                                echo '<td></td>';
                            }
                            echo '<td class="exp-list">'; 
                                echo '<h3>'.$edu['course_name'].', '.$edu['institute_name'].'</h3>'; 
                                echo '<span>'.ucwords($monthList[$start_month]).' '.$start_year . ' - '. ucwords($monthList[$end_month]). ' '.$end_year. ' / '.$edu['city']. ', ' .$edu['country'].'</span>';
                                echo '<p>'.$edu['description'].'</p>';
                            echo '</td> ';
                            echo '</tr>';
                            $eudi++;
                        }
                    }else{
                        echo '
                            <tr>
                                <td class="exp-title"> 
                                    <div class="title">
                                        <h2>Education</h2> 
                                    </div>  
                                </td>
                                <td class=exp-list">Education hasn\'t added yet</td> 
                            </tr>
                        ';
                    }
                }else{
                    echo '
                        <tr>
                            <td class="exp-title"> 
                                <div class="title">
                                    <h2>Education</h2> 
                                </div>  
                            </td>
                            <td class=exp-list">Education hasn\'t added yet</td> 
                        </tr>
                    ';
                }
        ?>  
        </table> 

        <table class="experience skills-warp">
            <tr>
                <td> 
                    <div class="title">
                        <h2>Skills</h2> 
                    </div>  
                </td>
                <td>
                <?php
                    $softSkils = get_user_meta($user->ID, 'soft_skils', true);
                    $uxUiSkils = get_user_meta($user->ID, 'ux_ui_skils', true);
                    $toolsSkils = get_user_meta($user->ID, 'tools_skils', true);
                    if( !empty($softSkils) && !empty($uxUiSkils) && !empty($toolsSkils) ){
                ?>
                    <table class="skills-table">
                        <tr>
                            <td class="skills">
                                <h3>Tools</h3> 
                                <ul class="skll-list">
                                    <?php  
                                        if(!empty($toolsSkils)){
                                            $toolsSkils = unserialize($toolsSkils);
                                            if( is_array($toolsSkils) && ( count($toolsSkils) > 0 ) ){
                                                foreach($toolsSkils as $skill){
                                                    echo '<li>'.$skill.'</li>';
                                                }
                                            }
                                        } 
                                    ?>
                                </ul>
                            </td> 
                            <td class="skills">
                                <h3>UI/UX Skills</h3> 
                                <ul class="skll-list">
                                    <?php  
                                        if(!empty($uxUiSkils)){
                                            $uxUiSkils = unserialize($uxUiSkils);
                                            if( is_array($uxUiSkils) && ( count($uxUiSkils) > 0 ) ){
                                                foreach($uxUiSkils as $skill){
                                                    echo '<li>'.$skill.'</li>';
                                                }
                                            }
                                        }
                                    ?>
                                </ul>
                            </td> 
                            <td class="skills">
                                <h3>Soft Skills</h3> 
                                <ul class="skll-list">
                                    <?php  
                                        if(!empty($softSkils)){
                                            $softSkils = unserialize($softSkils);
                                            if( is_array($softSkils) && ( count($softSkils) > 0 ) ){
                                                foreach($softSkils as $skill){
                                                    echo '<li>'.$skill.'</li>';
                                                }
                                            }
                                        }
                                    ?>
                                </ul>
                            </td>
                        </tr>
                    </table>  
                <?php
                    }else{
                        echo 'Skill hasn\'t added yet';
                    }
                ?>
                </td>
            </tr>
        </table>

        <table class="experience skills-warp personal-warp">
            <tr>
                <td> 
                    <div class="title">
                        <h2>Personal</h2> 
                    </div>  
                </td>
                <td>
                <?php 
                    $address = get_user_meta($user->ID, 'address', true);
                    $city = get_user_meta($user->ID, 'city', true);
                    $country = get_user_meta($user->ID, 'country', true); 
                    if( !empty($address) && !empty($city) && !empty($country) ){ 
                ?>
                    <table class="skills-table">
                        <tr>
                            <td class="skills">
                                <h3>Social</h3> 
                                <ul class="skll-list social-icons">
                                    <?php if(!empty(get_user_meta($user->ID, 'social_facebook', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_facebook', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/facebook-logo.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_twitter', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_twitter', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/twitter-black-shape.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_bribbble', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_bribbble', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/dribbble-logo.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_linkdin', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_linkdin', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/linkedin.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_behance', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_behance', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/behance-logo.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_google', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_google', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/google-plus.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_pinterest', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_pinterest', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/pinterest.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_instagram', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_instagram', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/instagram-logo.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_youtube', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_youtube', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/youtube.png" /></a></li>
                                    <?php } ?>

                                    <?php if(!empty(get_user_meta($user->ID, 'social_medium', true))){ ?>
                                        <li><a target="_blank" href="<?php echo get_user_meta($user->ID, 'social_medium', true); ?>"><img src="<?php echo JP_PLUGIN_URI; ?>/assets/images/medium-size.png" /></a></li> 
                                    <?php } ?>
                                </ul>
                            </td>
                            <td class="skills">
                                <h3>Contact</h3> 
                                <ul class="skll-list">
                                    <?php 
                                        $phoneAddressPrivate = get_user_meta($user->ID, 'phone_address_private', true);
                                        if( $phoneAddressPrivate != 'yes' ) {
                                            echo '<li>'.$user->user_email.'</li>
                                                <li>'.esc_attr(get_user_meta($user->ID, 'phone', true)).'</li>
                                                <li>'.$user->user_url.'</li>';
                                        }else{
                                            echo '<li>'.$user->user_email.'</li> 
                                                <li>'.$user->user_url.'</li>';
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="skills">
                                <h3>Address</h3> 
                                <ul class="skll-list">
                                    <?php 
                                        if( $phoneAddressPrivate != 'yes' ) {
                                            echo '<li>'.esc_attr($address).'</li>
                                            <li>'.esc_attr($city).', '.esc_attr($country).'</li>';
                                        }
                                    ?>
                                </ul>
                            </td>   
                        </tr>
                    </table>  
                <?php 
                    }else{
                        echo 'Personal Details hasn\'t added yet';
                    } 
                ?>
                </td>
            </tr>
        </table>

        <table class="storis-warp"> 
            <tbody>
                <tr>
                    <td class="storis-title" colspan="4">
                        <h2>Storis</h2>
                    </td> 
                </tr>
                <tr>
                <?php
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
                                echo '
                                    <td>  
                                        <img src="'.get_the_post_thumbnail_url($post->id,'case-studies').'" alt="" />
                                        <span class="case-stady">'.$terms[0]->name.'</span>
                                        <h3>'.get_the_title().'</h3>
                                    </td> 
                                ';
                            }
                        }else{
                            echo '<td> Stories hasn\'t added yet<td>';
                        }
                    }
                ?> 
                </tr> 
            </tbody>
        </table> 
    </body>
</html>