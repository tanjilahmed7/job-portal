<?php
function job_notification( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'All Notifications',
        'sub-title' => 'Summery of your notifications'
    ), $atts, 'bartag' );
    global $redux_job;
    $outputHtml = '';
    if(!is_user_logged_in()){
        return '<script>window.location.href="'.home_url('/').'"; </script>';
    }else{ 
        $user = wp_get_current_user();
        $fanObj = new JP_FollowAndNotification();  
        $notificationData = $fanObj->getAllNotificationDataByUserID($user); 
        $fanObj->updateNotificationByUserID($user);
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
        <div class="all-notifications">';
            if( count($notificationData) > 0 ){
                foreach( $notificationData as $notification){
                    $outputHtml .= '<div class="single-notifications">';
                    $outputHtml .= '<div class="image"><img src="'.$notification['from_user_avater'].'" alt=""></div>';
                    if($notification['type'] == 'follow'){
                        $outputHtml .= '<p><strong>'.$notification['from_user_name'].'</strong> started following you.</p>';
                    }else if($notification['type'] == 'post'){
                        $outputHtml .= '<p><strong>'.$notification['from_user_name'].'</strong> published new '.$notification['post_cat'].' " <a href="'.$notification['post_link'].'">'.$notification['post_title'].'</a> ".</p>';
                    }else if($notification['type'] == 'comment'){
                        $outputHtml .= '<p><strong>'.$notification['from_user_name'].'</strong> commented on your post " <a href="'.$notification['post_link'].'">'.$notification['post_title'].'</a> ".</p>';
                    }
                    $outputHtml .= '</div>';
                }
            }
    $outputHtml .= '</div></div> ';
	return $outputHtml;
}
add_shortcode( 'job_notification', 'job_notification' );