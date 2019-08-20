<?php
class JBAjaxRequestHandaler {

    /**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
    public static $_instance = null;

    /**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Plugin The request Data of the class.
	 */
    protected $requestData = null;
    
    /**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }

    /**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct($requestData) {
        $this->requestData = $requestData;
        $this->requestHandaler();
    }


    public function requestHandaler(){
        if($this->inputCheck('requestType') == 'signup'){
            $this->userSignUp();
        }elseif($this->inputCheck('requestType') == 'login'){
            $this->userLogin();
        }elseif($this->inputCheck('requestType') == 'resetPassword'){
            $this->resetPassword();
        }elseif($this->inputCheck('requestType') == 'newPassword'){
            $this->newPassword();
        }elseif($this->inputCheck('requestType') == 'userProfileUpdate'){
            $this->userProfileUpdate();
        }elseif($this->inputCheck('requestType') == 'UserjobPost'){
            $this->UserjobPost();
        }elseif($this->inputCheck('requestType') == 'interviewQuestion'){
            $this->interviewQuestion();
        }
        elseif($this->inputCheck('requestType') == 'askQuestion'){
            $this->askQuestion();
        }elseif($this->inputCheck('requestType') == 'resourseModal'){
            $this->resourseModal();
        }elseif($this->inputCheck('requestType') == 'resourseModalData'){
            $this->resourseModalData();
        }elseif($this->inputCheck('requestType') == 'ux-user-filter'){
            $this->uxUserFilter();
        }elseif($this->inputCheck('requestType') == 'UXJobFilter'){
            $this->UXJobFilter();
        }elseif($this->inputCheck('requestType') == 'uxUserFlowing'){
            $this->uxUserFlowing();
        }elseif($this->inputCheck('requestType') == 'UXChallengeSubmission'){
            $this->UXChallengeSubmission();
        }elseif($this->inputCheck('requestType') == 'AddPost'){
            $this->AddPost();
        }elseif($this->inputCheck('requestType') == 'DeletedPost'){
            $this->DeletedPost();
        }elseif($this->inputCheck('requestType') == 'EditPost'){
            $this->EditPost();
        }elseif($this->inputCheck('requestType') == 'notificationCheck'){
            $this->notification();      
        }elseif($this->inputCheck('requestType') == 'ShareQuestion'){
            $this->ShareQuestion();       
        }elseif($this->inputCheck('requestType') == 'PostComments'){
            $this->PostComments();       
        }elseif($this->inputCheck('requestType') == 'TopStoriesPosts'){
            $this->TopStoriesPosts();
        }elseif($this->inputCheck('requestType') == 'EditResourseModalData'){
            $this->EditResourseModalData();
        }elseif($this->inputCheck('requestType') == 'ReactPostLove'){
            $this->ReactPostLove();
        }        
    }

    public function inputCheck($inputName){
        return ( isset($this->requestData[$inputName]) && !empty($this->requestData[$inputName]) ) ? $this->requestData[$inputName] : false;
    }

    public function notification(){
        if(is_user_logged_in()){
            $user = wp_get_current_user();
            $fanObj = new JP_FollowAndNotification();  
            $notificationData = $fanObj->getNewNotificationByUserID($user);
            wp_send_json( array('status'=> 'success', 'auth'=>true, 'data'=>$notificationData) );
        }
        wp_send_json( array('status'=> 'success', 'auth'=>false) );

    }

    protected function resetPassword(){ 
        $user_email 	= $this->inputCheck('email');
        $user = get_user_by( 'email', $user_email);
        if($user && $user->ID){
            $account_status = get_user_meta($user->ID, 'account_status', true);
            if($account_status == 'active'){
                $this->send_reset_mail_to_user($user->ID, $user_email);
                wp_send_json( array('status'=> 'success' ) );
            }else{
                wp_send_json( array('status'=> 'failed', 'error'=> array('User account deactived.') ) );
            }
        }
        wp_send_json( array('status'=> 'failed', 'error'=> array('User Not Found With This Email.') ) );
    }
    
    protected function newPassword(){ 
        $token 	= $this->inputCheck('_jb_token');
        $uid 	= $this->inputCheck('_jb_user');
        $password 	= $this->inputCheck('password');
        $cpassword 	= $this->inputCheck('confirm_password'); 
        if($token && $uid){
            $user = get_user_by( 'ID', $uid);
            if($user && $user->ID){
                $usertoken = get_user_meta($user->ID, '_job_reset_token', true);
                if($usertoken == $token){
                    if($password == $cpassword){
                        wp_set_password( $password, $uid );
                        update_user_meta($uid, '_job_reset_token',  '');
                        wp_send_json( array('status'=> 'success' ) );
                    }  
                    wp_send_json( array('status'=> 'failed', 'error'=> array('Password Does not Match.') ) );
                }else{
                    wp_send_json( array('status'=> 'failed', 'error'=> array('User account deactived.') ) );
                }
            }
        }
        wp_send_json( array('status'=> 'failed', 'error'=> array('User Not Found.') ) );
    }


    public function send_reset_mail_to_user($user, $user_email){
        global $redux_job;
        //user posted variables 
        $number = rand(10,100);
        $token =  base64_encode( $user.'/'.$user_email.'/'.$number );
        $email = get_option('admin_email');
        // $email = 'mamunahmed678@gmail.com';
        $message = 'click hare to set new password <a href="'.home_url('/').$redux_job['job_reset_pass_page'].'/?reset_code='.$token.'">Reset Password</a>';

        //php mailer variables
        $to = $user_email;
        $subject = "Reset Your Password";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        update_user_meta($user, '_job_reset_token',  $token);
        //Here put your Validation and send mail
        $sent = wp_mail($to, $subject, $message, $headers);  
        
    }

    protected function userLogin(){
        $user_email 	= $this->inputCheck('email');
        $password 		= $this->inputCheck('password'); 
        $user = get_user_by( 'email', $user_email);
        $account_status = get_user_meta($user->ID, 'account_status', true);
        
        if( ($account_status == 'active') && ( in_array('ux_professional', $user->roles)  || in_array('job_recruiter' , $user->roles) ) ){   
            $loginStatus = wp_authenticate( $user_email, $password );
            // var_dump($loginStatus);
            if($loginStatus && !is_wp_error( $loginStatus )){
                wp_clear_auth_cookie();
                wp_set_current_user ( $loginStatus->ID );
                wp_set_auth_cookie  ( $loginStatus->ID );
                wp_send_json( array('status'=> 'success' ) );
            }
            wp_send_json( array('status'=> 'failed', 'error'=> array('Incorrect email or password') ) );
        }else{
            if( $account_status == 'deactive' ){
                wp_send_json( array('status'=> 'failed', 'error'=> array('Your account is deactived') ) );
            }
        }  
        wp_send_json( array('status'=> 'failed', 'error'=> array('Incorrect email or password.') ) );
    }

    protected function userSignUp(){
        $full_name 	    = $this->inputCheck('fullname');
        $user_email 	= $this->inputCheck('email');
        $password 		= $this->inputCheck('password');
        $regType 		= $this->inputCheck('reg_type');
        if($full_name && $user_email && $password){
            $user_detail = array( 
                'first_name' => $full_name, 
                'user_login' => $user_email,
                'user_email' => $user_email,
                'user_pass'  => $password // no plain password here!
            ); 
            $user = wp_insert_user($user_detail);
            if(is_email( $user_email )){
                if (!is_wp_error($user)) {  
                    $this->setUserRole($user, $regType);
                    $this->setRegUserMeta($user, $user_email, $regType);
                    $this->send_activition_mail_to_user($user, $user_email);
                    wp_send_json( array('status'=> 'success', 'data'=> array('email'=>$user_email) ) );
                }else{ 
                    // print_r($user->errors);
                    wp_send_json( array(
                        'status'=> 'failed', 
                        'errors'=>$user->errors 
                    ) );
                }
            }else{
                wp_send_json( array(
                    'status'=> 'failed', 
                    'errors'=>'Invalid email address' 
                ) );
            }
        }
        wp_send_json( array('status'=> 'failed', 'error_message'=>'All Fields Required.') );
    }

    public function send_activition_mail_to_user($user, $user_email){
        //user posted variables 
        $token =  base64_encode( $user.'/'.$user_email.'/'.$user );
        $email = get_option('admin_email');
        // $email = 'mamunahmed678@gmail.com';
        $message = 'click hare to active your account <a href="'.home_url('/').'status/?activion_code='.$token.'">Active</a>';

        //php mailer variables
        $to = $user_email;
        $subject = "Active Your Account";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        //Here put your Validation and send mail
        $sent = wp_mail($to, $subject, $message, $headers);  
    }

    private function setRegUserMeta($user, $user_email, $regType){
        $token =  base64_encode( $user.'/'.$user_email.'/'.$user );
        if($regType == 'ux_professional'){
            $stories_mail   = $this->inputCheck('stories_mail');
            if($stories_mail){
                add_user_meta( $user, 'stories_mail', $stories_mail );
            } 

            add_user_meta( $user, '_activision_tokan', $token );
            add_user_meta( $user, 'account_status', 'deactive' );
        }
        if($regType == 'job_recruiter'){
            $phone          = $this->inputCheck('phone');
            $address        = $this->inputCheck('address');
            $city           = $this->inputCheck('city');
            $website        = $this->inputCheck('website');
            $stories_mail   = $this->inputCheck('stories_mail');
            if($address){
                add_user_meta( $user, 'phone', $phone );
            } 

            if($address){
                add_user_meta( $user, 'address', $address );
            } 

            if($city){
                add_user_meta( $user, 'city', $city );
            } 

            if($website){
                wp_update_user( array( 'ID' => $user, 'user_url' => $website ) );
                // update_user_meta( $user, 'user_url', $website );
            } 

            if($stories_mail){
                add_user_meta( $user, 'stories_mail', $stories_mail );
            } 

            add_user_meta( $user, '_activision_tokan', $token );
            add_user_meta( $user, 'account_status', 'deactive' );
        }
    } 

    private function setUserRole($user, $regType){
        if($user && $regType){ 
            $userObj = new \WP_User($user);

            if($regType == 'ux_professional'){
                $userObj->set_role( 'ux_professional' );
                $userObj->add_role( 'editor' );
            }elseif($regType == 'job_recruiter'){
                $userObj->set_role( 'job_recruiter' );
                $userObj->add_role( 'editor' );
            }else{
                $userObj->set_role( 'subscriber' );
            }
        } 
    }

    private function updateUserMeta($userID, $key, $value, $setToDefaultValue = false){
        if($setToDefaultValue === true){
            wp_update_user( array( 'ID' => $userID, $key => $value ) );
        }else{ 
            if( $key && !empty($value)){ 
                update_user_meta($userID, $key, $value );
            }
        }
    }

    public function userProfileUpdate(){  
        if($this->requestData){
            $user = wp_get_current_user(); 
            if(isset($_FILES['profileImage'])){
                $attachment_id = $this->uploadProfileImage($_FILES['profileImage']);
                if($attachment_id){
                    $this->updateUserMeta( $user->ID, 'profile_image', $attachment_id );
                }
            }
            // print_r($this->requestData['designation']);
            $this->updateUserMeta($user->ID, 'first_name', $this->requestData['name'], true);
            $this->updateUserMeta($user->ID, 'designation', $this->requestData['designation']);
            $this->updateUserMeta($user->ID, 'experience', $this->requestData['experience']);
            $this->updateUserMeta($user->ID, 'phone', $this->requestData['phone']);
            $this->updateUserMeta($user->ID, 'address', $this->requestData['address']);
            $this->updateUserMeta($user->ID, 'city', $this->requestData['city']);
            $this->updateUserMeta($user->ID, 'country', $this->requestData['country']);
            $this->updateUserMeta($user->ID, 'user_url', $this->requestData['website'], true);
            if(!empty($this->requestData['phone_address_private'])){
                $this->updateUserMeta($user->ID, 'phone_address_private', $this->requestData['phone_address_private']);
            }else{ 
                update_user_meta($user->ID, 'phone_address_private', '' );
            } 
            
            $this->updateUserMeta($user->ID, 'introduction', $this->requestData['introduction']);

            //update Eduction links
            $this->userProfileExperienceUpdate($user);

            //update Eduction links
            $this->userProfileEductionUpdate($user);

            //update social links
            $this->userProfileSocialUpdate($user);

            //update user skills 
            $this->userProfileSkillsUpdate($user);
            wp_send_json( array('status'=> 'success') );
        }
        wp_send_json( array('status'=> 'failed', 'error_message'=>'Invalid Request.') );
    }

    public function userProfileExperienceUpdate($user){
        $exp = $this->inputCheck('exp'); 
        
        if(is_array($exp) && count($exp) > 0){
            // print_r($edu);
            $expSerialize = serialize($exp); 
            // serialize() and unserialize()
            $this->updateUserMeta($user->ID, '_job_user_exp', $expSerialize); 
            // print_r($exp);
        }else{
            $expSerialize = serialize(array()); 
            $this->updateUserMeta($user->ID, '_job_user_exp', $expSerialize); 
        }
    }

    public function userProfileEductionUpdate($user){
        $edu = $this->inputCheck('edu'); 
        if(is_array($edu) && count($edu) > 0){
            // print_r($edu);
            $eduSerialize = serialize($edu); 
            // serialize() and unserialize()
            $this->updateUserMeta($user->ID, '_job_user_edu', $eduSerialize); 
        }else{
            $eduSerialize = serialize(array());
            $this->updateUserMeta($user->ID, '_job_user_edu', $eduSerialize); 
        }
    }

    public function userProfileSkillsUpdate($user){
        $soft_skils = $this->inputCheck('soft_skils');
        // print_r($soft_skils);
        if( $soft_skils && (count($soft_skils) > 0 ) ){
            $serializeSoftSkils = serialize($soft_skils);
            $this->updateUserMeta($user->ID, 'soft_skils', $serializeSoftSkils);
        }

        $ux_ui_skils = $this->inputCheck('ux_ui_skils');
        // print_r($ux_ui_skils);
        if( $ux_ui_skils && (count($ux_ui_skils) > 0 ) ){
            $serializeUxUiSkils = serialize($ux_ui_skils);
            $this->updateUserMeta($user->ID, 'ux_ui_skils', $serializeUxUiSkils);
        }

        $tools_skils = $this->inputCheck('tools_skils');
        // print_r($tools_skils);
        if( $tools_skils && (count($tools_skils) > 0 ) ){
            $serializeToolsSkils = serialize($tools_skils);
            $this->updateUserMeta($user->ID, 'tools_skils', $serializeToolsSkils);
        }
    }

    public function userProfileSocialUpdate($user){
        if($this->inputCheck('social_linkdin')){
            $this->updateUserMeta($user->ID, 'social_linkdin', $this->requestData['social_linkdin']);
        }
        if($this->inputCheck('social_bribbble')){
            $this->updateUserMeta($user->ID, 'social_bribbble', $this->requestData['social_bribbble']);
        }
        if($this->inputCheck('social_behance')){
            $this->updateUserMeta($user->ID, 'social_behance', $this->requestData['social_behance']);
        }
        if($this->inputCheck('social_google')){
            $this->updateUserMeta($user->ID, 'social_google', $this->requestData['social_google']);
        }
        if($this->inputCheck('social_pinterest')){
            $this->updateUserMeta($user->ID, 'social_pinterest', $this->requestData['social_pinterest']);
        }
        if($this->inputCheck('social_twitter')){
            $this->updateUserMeta($user->ID, 'social_twitter', $this->requestData['social_twitter']);
        }
        if($this->inputCheck('social_facebook')){
            $this->updateUserMeta($user->ID, 'social_facebook', $this->requestData['social_facebook']);
        }
        if($this->inputCheck('social_instagram')){
            $this->updateUserMeta($user->ID, 'social_instagram', $this->requestData['social_instagram']);
        }
        if($this->inputCheck('social_youtube')){
            $this->updateUserMeta($user->ID, 'social_youtube', $this->requestData['social_youtube']);
        }
        if($this->inputCheck('social_medium')){
            $this->updateUserMeta($user->ID, 'social_medium', $this->requestData['social_medium']);
        } 
    } 

    private function uploadProfileImage($file){
        //Upload featured image / attachment
        require_once( ABSPATH . 'wp-admin/includes/admin.php' );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $featured_img = wp_handle_upload( $file, array('test_form' => false ) );

        $filename = $featured_img['file'];

        $attachment = array(
            'post_mime_type' => $featured_img['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $featured_img['url']
        );

        $attachment_id = wp_insert_attachment( $attachment, $featured_img['url'] );
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
        wp_update_attachment_metadata( $attachment_id, $attachment_data );
        return $attachment_id;
    } 
    
    protected function UserjobPost(){
        $company_name               = $_POST['company_name'];
        $city                       = $_POST['city'];
        $country                    = $_POST['country'];
        $company_website_link       = $_POST['company_website_link'];
        $job_title                  = $_POST['job_title'];
        $job_type                   = $_POST['job_type'];
        $to                         = $_POST['to'];
        $from                       = $_POST['from'];
        $discrption                 = $_POST['job_discrption'];
        $apply_link                 = $_POST['apply_link'];
        $number_of_days             = $_POST['number_of_days'];

        // Image
        $company_logo               = $_FILES['company_logo'];
  
        // Args Parameter
        $args = array(
            'post_author'           => get_current_user_id(),
            'post_content'          => $discrption,
            'post_title'            => $job_title,
            'post_status'           => 'publish',
            'post_type'             => 'posts-jobs',
                    
        );

        // Insert the post into the database.
        $postId = wp_insert_post( $args );
        print_r($postId);
        
        add_post_meta($postId, '_job_company_name', $company_name);
        add_post_meta($postId, '_job_city', $city);
        add_post_meta($postId, '_job_country', $country);
        add_post_meta($postId, '_job_company_website_link', $company_website_link);
        add_post_meta($postId, '_job_job_title', $job_title);
        add_post_meta($postId, '_job_job_type', $job_type);
        add_post_meta($postId, '_job_to', $to);
        add_post_meta($postId, '_job_from', $from);
        add_post_meta($postId, '_job_discrption', $discrption);
        add_post_meta($postId, '_job_apply_link', $apply_link);
        add_post_meta($postId, '_job_number_of_days', $number_of_days);

        UXjob::ImageUpload($company_logo, $postId);
    }

    public function interviewQuestion(){
        if(isset($_POST)){

            $args = array(
                'post_type' => 'interview-question',
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'interview_cat',
                        'field'    => 'slug',
                        'terms'    => $_POST['name'],
                    ),
                ),                        
            );
            // The Query
            $query1 = new WP_Query( $args );
            
            // The Loop
            // $data = [''];
            while ( $query1->have_posts() ) {
                $query1->the_post();
                $data .= '<li>' . get_the_title() . '</li>';
                
            }
            wp_send_json( array('status'=> 'success', 'data'=>$data) );
            

            wp_reset_postdata();
      
        }
    }

    public function askQuestion(){
        $write_question = $_POST['write_question'];
        // Create post object
        $my_post = array(
        'post_type'     => 'ask-question',
        'post_title'    => wp_strip_all_tags( $_POST['write_question'] ),
        'post_status'   => 'pending',
        'post_author'   => get_current_user_id(),
        );
        
        // Insert the post into the database
        wp_insert_post( $my_post );


        wp_send_json( array('status'=> 'success', 'data'=>$write_question) );
    }

    public function resourseModal(){
        $modal = '
            <div class="modal fade" id="ResourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog font-end" role="document">
                <div class="modal-content">
                    <div class="modal-header-front">
                    <div class="row">
                        <div class="modal-closed col-md-12 float-right">
                        <button type="button" class="close closed-front" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    </div>
                    </div>
                    <div class="modal-body font-end">
                    <h2 class="m-title w-100">Share Resourse</h2>                    
                        <form id="resourse-form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="form-group">
                                <label for="resourse_select">Resourse Type</label>
                                <select class="form-control theme-select" id="resourse_select" name="resourse_select">
                                    <option value="ux-tools">UX-Tools</option>
                                    <option value="ux-books">UX-Ebook</option>
                                </select>
                            </div> 
                                </div>                               
                            </div>
                            <div class="row">                
                                <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                            <label for="title"class="default-input form-field__label">Title</label>
                                            <input id="title"  name="title" type="text" class="form-field__input"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="resourse_images_file">
                                    <div class="preview"><img id="preview4" width="120" height="120" src="'.get_template_directory_uri().'/assets/img/thumbnails.png"/></div>
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="featued_resourse" id="featued_resourse" onchange="previewFile4()">
                                        <span class="upload-preview-btn">Upload</span>
                                        <p>Recommended 400px X 400px</p>
                                    </div>                                 
                                </div>                           
                            </div>
                            <div class="row">                
                                <div class="col-sm">
                                    <div class="form-field">
                                        <div class="form-field__control">
                                            <label for="resourse_link" class="default-input form-field__label">Resourse Link</label>
                                            <input id="resourse_link"  name="resourse_link" type="text" class="form-field__input" />
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="form-btn w-100">
                                    <a href="#" id="resourseSubmit" class="btn-theme-btn">Submit for Review</a>
                                </div>
                            </div>
                        </form>          
                        
                    </div>
                </div>
                </div>
            </div>
            ';

             wp_send_json( array('status'=> 'success', 'data'=>$modal) );
    }

    public function resourseModalData(){
        $post_type          =   $_POST['resourse_select'];
        $title              =   $_POST['title'];
        $resourse_link      =   $_POST['resourse_link'];
        $resourse_image     =   $_FILES['featued_resourse'];

        // Args Parameter
        $args = array(
            'post_author'           => get_current_user_id(),
            'post_title'            => $title,
            'post_status'           => 'pending',
            'post_type'             => $post_type,
                    
        );

        // Insert the post into the database.
        $postId = wp_insert_post( $args );
        add_post_meta($postId, '_ux_resourse_link', $resourse_link);
        UXjob::SetImageUpload($resourse_image, $postId, true, '', 400,400, true);
    }


    public function uxUserFilter(){
        $name = $this->inputCheck('name');
        $city = $this->inputCheck('city');
        $exp = $this->inputCheck('exp');

        
        $metaQuery = array(
                array(
                    'key' => 'account_status',
                    'value' => 'active',
                    'compare' => '=='
                ),  
            );
        if(!empty($name)){
            $metaQuery[] = array(
                'relation' => 'OR',
                array(
                    'key' => 'first_name',
                    'value' => $name,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'designation',
                    'value' => $name,
                    'compare' => 'LIKE'
                )
            );
        }
        if(!empty($city)){
            $metaQuery[] = array(
                'key' => 'city',
                'value' => $city,
                'compare' => '=='
            );
        }
        if(is_array($exp) && count($exp) > 0){
            // print_r($exp);
            $startEl = null;
            $endEl = end($exp);
            if($exp[0] == 5){ $startEl = 0; }
            if($exp[0] == 10){ $startEl = 5; }
            if($exp[0] == 15){ $startEl = 10; }
            if($exp[0] == 16){ $startEl = 16; $endEl = 16; }

            $metaQuery[] = array(
                'key' => 'experience',
                'value'   => array( $startEl, $endEl ),
                'type'    => 'numeric',
                'compare' => 'BETWEEN'
            );
        }
        $users = get_users(
            array(
                'role' => 'ux_professional',
                'meta_query' => $metaQuery
            )
        );
        if(count($users) > 0 ){ 
            $allData = array();
            foreach($users as $user){
                $data = array();
                $data['id'] = $user->ID;
                $data['name'] = get_user_meta($user->ID, 'first_name', true);
                $data['last_name'] = get_user_meta($user->ID, 'last_name', true);
                $data['designation'] = get_user_meta($user->ID, 'designation', true);
                $data['city'] = get_user_meta($user->ID, 'city', true);
                $data['country'] = get_user_meta($user->ID, 'country', true);
                $data['exp'] = get_user_meta($user->ID, 'experience', true);
                $data['profile_link'] = home_url().'/ux-professionals/?user='.$user->ID;

                $image = wp_get_attachment_url( get_user_meta($user->ID, 'profile_image', true) );
                if( !empty($image) ){
                    $data['thumb'] = $image;
                }else{
                    $data['thumb'] = JP_PLUGIN_URI.'/assets/images/circle.png';
                }
                $allData[] = $data;
            }
            wp_send_json( array('status'=> 'success', 'data'=>$allData) );
        }else{
            wp_send_json( array('status'=> 'success', 'data'=>false, 'message'=>'Search Result Not Found !') );
        }
        wp_send_json( array('status'=> 'failed', 'error_message'=>'Invalid Request.') );
    }

    public function uxUserFlowing(){
        $userId = $this->inputCheck('user_id');
        $status = $this->inputCheck('status');
        $fanObj = new JP_FollowAndNotification();  
        if($status == 'follow'){ 
            $fanObj->setFollower($userId);
        }
        if($status == 'unfollow'){ 
            $fanObj->unsetFollower($userId);
        } 
    }  

    public function UXJobFilter(){
        $search_location = $_POST['search_location'];
        $explode_location = explode(',', $search_location);
        
        // Values
        $SearchTitle = $_POST['search_job'];
        $Country = $explode_location[0];
        $SearchType = $_POST['search_type'];

        if(!empty($SearchTitle)){
            $metaQuery = array(
                array(
                    'key' => '_job_job_title',
                    'value' => $SearchTitle,
                    'compare' => 'LIKE'
                )
            );
        }

        if(!empty($Country)){
            $metaQuery[] = array(
                'key' => '_job_country',
                'value' => $Country,
            );
        }

        if(!empty($SearchType)){
            $metaQuery[] = array(
                'key' => '_job_job_type',
                'value' => $SearchType,
            );
        }

            

        $args = array(
            'post_type'  => 'posts-jobs',    
            'meta_query' => $metaQuery
        );

        $the_query = new WP_Query( $args );



?>  


           <?php if ( $the_query->have_posts() ) : ?>
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                
                <?php 
                    global $post; 
                    $title = get_post_meta($post->ID, '_job_job_title');
                    $city = get_post_meta($post->ID, '_job_city');
                    $country = get_post_meta($post->ID, '_job_country');
                    $job_type = get_post_meta($post->ID, '_job_job_type');

                    $html .= '<div class="row"><div class="job-list"><div class="job-list-items"><div class="job-items"><div class="image"><img src="'. get_the_post_thumbnail_url($post->ID, 'thumbnail') .'" alt="image"></div><div class="text-block"><h3>'. $title[0] .'</h3><span>'. $city[0] .', '. $country[0] .'</span></div></div></div><div class="job-list-items"><div class="job-type"><span>'. $job_type[0] .'</span></div></div><div class="job-list-items"><div class="times"><span>'. human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago' .'</span></div></div></div></div>';
                
            ?>
             
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        
        <?php else : ?>
            <?php $html .= '<p>Sorry, no posts matched your criteria.</p>'; ?>
        <?php endif; ?>

        <?php wp_send_json( array('status'=> 'success', 'data'=>$html) ); ?>        

<?php
    }
   
    
   public function UXChallengeSubmission(){
       echo "<pre>";
       print_r($_POST);
       echo "</pre>";

       $category        = $_POST['ux_challenge_cat'];
       $title           = $_POST['ux_challenge_title'];
       $discrption     = $_POST['discription'];

        // Args Parameter
        $args = array(
            'post_author'           => get_current_user_id(),
            'post_content'          => $discrption,
            'post_title'            => $title,
            'post_status'           => 'Pending',
            'post_type'             => 'ux-challenge',
            'tax_input'             =>  array(
                'ux-challenge'           =>   array ($category),
            )
                    
        );

        
        // Insert the post into the database.
        $postId = wp_insert_post( $args );

   } 

   public function AddPost(){
        if (!empty($_POST['case_cat'])) {
            $cateory = $_POST['case_cat'];	
        }
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];	
        }
        if (!empty($_POST['discription'])) {
            $discrption = $_POST['discription'];	
        }
        if (!empty($_FILES['header_img'])) {
            $header_img = $_FILES['header_img'];	
        }
        if (!empty($_FILES['header_featured'])) {
            $header_featured = $_FILES['header_featured'];	
        } 
        if (!empty($_POST['tags'])) {
            $tags = $_POST['tags'];	
        } 
        
        $term_object = get_term( $cateory );

        if($term_object->slug == 'articles'){
            $status = 'pending';
        }else{
            $status = 'publish';
        }

        // Args Parameter
        $args = array(
            'post_author'           => get_current_user_id(),
            'post_content'          => $discrption,
            'post_title'            => $title,
            'post_status'           => $status,
            'post_type'             => 'post',
            'tax_input'             =>  array(
                'category'           =>   array ($cateory),
            )
                    
        );

        
        // Insert the post into the database.
        $postId = wp_insert_post( $args );


        UXjob::SetImageUpload($header_featured, $postId, true, '', 180,180, true);

        UXjob::SetImageUpload($header_img, $postId, false, '__add_job_header_img', 1300, 540, true);

        // $featured_img_upload->SetImageUpload($header_featured);
        wp_set_post_tags( $postId, $tags, true );
        
        wp_send_json( array('success'=> 'publish') );
        echo "OK";
   }

   public function DeletedPost(){
       $id = $_POST['id'];
        wp_delete_post($id);
   }

   public function EditPost(){
        $cateory = $_POST['case_cat'];	
        $title = $_POST['title'];	
        $discrption = $_POST['discription'];	
        $header_img = $_FILES['header_img'];	
        $header_featured = $_FILES['header_featured'];	
        $header_update_img = $_POST['header_update_img'];	
   

        // if(!empty($header_featured)){ echo "file is not empty"; }
    
        $tags = $_POST['tags'];	
    
        
        $term_object = get_term( $cateory );

        $status = get_post_status($_POST['postid']);

        // Args Parameter
        $args = array(
            'ID'                    => $_POST['postid'],
            'post_author'           => get_current_user_id(),
            'post_content'          => $discrption,
            'post_title'            => $title,
            'post_status'           => $status,
            'post_type'             => 'post',
            'tax_input'             =>  array(
                'category'           =>   array ($cateory),
            )
                    
        );

        
        // Insert the post into the database.
        $postId = wp_update_post( $args );


        
        if($header_featured['name'] == ''){
            set_post_thumbnail($_POST['featured_update_img'], $_POST['postid'] );
        } else{
             UXjob::SetImageUpload($header_featured, $_POST['postid'], true, '', 180,180, true);
        }

        if($header_img['name'] == ''){
            // echo $header_update_img
            update_post_meta($_POST['postid'], '__add_job_header_img', $header_update_img);
        } else{
            UXjob::SetUpdateImageUpload($header_img, $_POST['postid'], false, '__add_job_header_img');
        }

       

        // $featured_img_upload->SetImageUpload($header_featured);
        wp_set_post_tags( $postId, $tags, true );
   }

   public function ShareQuestion(){
        // Create post object
        $my_post = array(
        'post_type'     => 'interview-question',
        'post_title'    => wp_strip_all_tags( $_POST['write_interview_question'] ),
        'post_status'   => 'pending',
        'post_author'   => get_current_user_id(),
        );
        
        // Insert the post into the database
        wp_insert_post( $my_post );


        wp_send_json( array('status'=> 'success') );       
   }

   public function PostComments(){
       if(!empty($_POST['comment'])){
            $comment_post_id        = $_POST['post_id'];
            $comments               = $_POST['comment'];
            $current_id             = get_current_user_id();        
            $comment_author         = get_the_author_meta('first_name', $current_id);
            $comment_author_email   = get_the_author_meta('user_email', $current_id);

            $time = current_time('mysql');
            $data = array(
                'comment_post_ID' => $comment_post_id,
                'comment_author' => $comment_author,
                'comment_author_email' => $comment_author_email,
                'comment_content' => $comments,
                'user_id' => $current_id,
                'comment_date' => $time,
                'comment_approved' => 1,
            );

            wp_insert_comment($data);

            $args = array (
                'post_id'   => $comment_post_id,
            );
            $commnets = get_comments($args);

            foreach ($commnets as $comment) {
                $get_image = wp_get_attachment_url( get_user_meta($comment->user_id,'profile_image', true) );
                $author = get_comment_author( $comment->ID );

                 $data = '<div class="post-comment "><div class="avaters"><div class="img"><img src="'. $get_image .'" alt="'. $author .'"></div><div class="info"><h3>'. $comment->comment_author .'</h3>  <p>'. date("M-d", strtotime($comment->comment_date)) .'</p></div></div><div class="content"><article><p>'. $comment->comment_content .'</p></article></div></div> ';
                
                 wp_send_json( array('status'=> 'success', 'data'=> $data ) );     
            }
            
       }


   }


   public function TopStoriesPosts () {
       global $post;
           global $wp_query;

       $paged = (int)$_POST['page']+1;
        $args = array(
            'post_type'   => 'post',
            'post_status' => 'publish',  
            'paged'       => $paged,
            'meta_key' => 'wpb_post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'               
            );
        $popularpost = new WP_Query($args);
        // print_r($popularpost);
        ob_start(); 
        while ( $popularpost->have_posts() ) : $popularpost->the_post();
    ?>
            <div class="top-item">
                <div class="image">
                    <a href="<?php the_permalink(); ?>"><img src="<?php  echo get_the_post_thumbnail_url($post->id,'top-items'); ?>"/></a>
                </div>
                <div class="content">
                    <span><?php echo get_the_terms($post->ID, 'category')[0]->name ?></span>
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <p><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>
                    <span class="author"><?php echo get_the_author_meta('first_name', $post->post_author); ?></span>
                </div>
            </div>
    <?php
    endwhile;
    $html = ob_get_contents();
    ob_end_clean();
        if( $popularpost->max_num_pages < $paged ){
            wp_send_json( array('status'=> 'success', 'data'=>$html, 'nextpage'=>'loaded') ); 
        }else { 
            wp_send_json( array('status'=> 'success', 'data'=>$html, 'nextpage'=>$paged) ); 
        }
   }

   public function EditResourseModalData(){
        echo "<pre>";
        print_r($_POST);
        echo "<pre>";
        
        
        $post_id            =   $_POST['post_id'];
        $status             =    get_post_status($post_id);
        $post_type          =   $_POST['resourse_select'];
        $title              =   $_POST['title'];
        $resourse_link      =   $_POST['resourse_link'];
        $featured_img       =   $_FILES['featued_resourse'];

 
        $args = array(
            'ID'                    => $post_id,
            'post_title'            => $title,
            'post_status'           => $status,
            'post_type'             => $post_type,
                    
        );

        // Update the post into the database
        wp_update_post( $args);

 
        update_post_meta( $post_id, '_ux_resourse_link', $resourse_link);

                
        if($featured_img['name'] == ''){
            set_post_thumbnail($_POST['current_images'], $post_id  );
        } else{
             UXjob::SetImageUpload($featured_img, $post_id, true, '', 400,400, true);
        }

       

    die();

   }

   public function ReactPostLove(){
       global $post;
        $count = $_POST['count'];
        $postID = $_POST['postID'];
        $current_id = get_current_user_id();
        
        $user_id = get_post_meta($postID, 'post_love_react_user_id');

        if (!in_array($current_id, $user_id))
        {
            add_post_meta($postID,'post_love_react_count', $count );
            add_post_meta($postID,'post_love_react_user_id', $current_id );
            
            $count = count($user_id);
            wp_send_json(array('status' => 'success', 'data' => $count));
        }
        

        
        


        
    die();
   }
}