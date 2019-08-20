<?php
/**
 * Plugin Name: Job Portal
 * Description: The is job portal plugin for WordPress
 * Version:     1.0.1
 * Author:      CodeCares
 * Author URI:  https://codecares.net/
 * Text Domain: jobportal
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'JP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'JP_PLUGIN_URI', plugins_url( '/', __FILE__ ) );
define( 'JPTD', 'jobportal');

include JP_PLUGIN_PATH.'/inc/JP_Database.php';
include JP_PLUGIN_PATH.'/inc/JP_FollowAndNotification.php';
include JP_PLUGIN_PATH.'/inc/UserMetabox.php';
include JP_PLUGIN_PATH.'/inc/JBAjaxRequestHandaler.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/status.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/signup.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/login.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/reset-password.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/post-management.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/user-create-post.php';
include JP_PLUGIN_PATH. '/inc/register/jobs.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/account-settings.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/add-jobs.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/jobs-manage.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/interview-questions.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/ask-question.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/case-studies.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/articles.php';
include JP_PLUGIN_PATH. '/inc/views/posts-jobs.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/ux-members.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/member-profile.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/ux-jobs.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/ux-challenge.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/search-result.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/post-edit.php';
include JP_PLUGIN_PATH. '/inc/shortcodes/notifications.php';
include JP_PLUGIN_PATH. '/inc/widget/JobPostWidget.php';
require_once JP_PLUGIN_PATH.'/inc/dompdf/autoload.inc.php';

class JobPortal {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0'; 


	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() { 


		// run the install scripts upon plugin activation
		register_activation_hook(__FILE__, array($this, 'jobPortal_init'));
		// add_action('plugins_loaded', array($this,'plugin_loaded'));
		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );    
		// initialize 
		$this->init();
		// register front-end enqueuers
		add_action('wp_enqueue_scripts', array($this, 'register_front_end_enqueuers'));

		// register wp-admin enque
		add_action( 'admin_enqueue_scripts', array($this, 'load_custom_wp_admin_style') );		

		// 
		add_action( 'widgets_init', array($this, 'register_job_widget') );

		//register ajax handaler
		add_action('wp_ajax_jp_ajax', array($this, 'jp_ajax_handaler'));
		add_action('wp_ajax_nopriv_jp_ajax', array($this, 'jp_ajax_handaler') );

		// Register Custom Post Job

		// add_action( 'admin_init', array($this, 'admin_area_restrict'));
		add_filter( 'show_admin_bar', array($this, 'hide_admin_bar') );
		add_action('wp_logout', array($this, 'jp_logout_redirect') );
		add_action( 'wp_insert_post',  array($this, 'insert_post_notification'), 10, 3 );
		add_action( 'wp_insert_comment',  array($this, 'insert_comment_notification'), 10, 2 );
		add_action( 'admin_post_download_resume', array($this, 'user_download_resume') );
		add_action( 'admin_post_nopriv_download_resume', array($this, 'user_download_resume') ); 

	}

	public function jobPortal_init(){
		ob_start();
			$tmdb = new JP_Database();
			$tmdb->init();
		ob_get_clean();
	}

	public function hide_admin_bar(){ 
		if( current_user_can( 'administrator' ) ) {
			return true;
		}else{
			return false; 
		}
	}

	public function jp_logout_redirect(){
		wp_redirect( home_url('/') ); 
		exit();
	}
	
	public function admin_area_restrict() {

		// if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		// 	return;
		// }

		// if( !current_user_can( 'administrator' ) ) {
		// 	wp_redirect( home_url() );
		// 	die();
		// }  
   }

   	public function user_download_resume(){  
		$userID = (int)$_POST['user']; 
		$user = get_user_by('id', $userID);
		// print_r($user);
		
		ob_start();    
			include JP_PLUGIN_PATH. 'views/member-profile.php'; 
			$informaltion = ob_get_contents();
		ob_end_clean();
		if(isset($_POST['pp'])){
			echo $informaltion; 
		}else{ 
			$username = get_user_meta($user->ID, 'first_name', true);
			$username = $username.'.pdf';
			$dompdf = new Dompdf\Dompdf(array('enable_remote' => true));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->set_option('defaultMediaType', 'all');
			$dompdf->set_option('isFontSubsettingEnabled', true);

			$dompdf->loadHtml($informaltion, 'UTF-8'); 
			
			$dompdf->render();
			$dompdf->stream($username);
		} 
   	}

    public function insert_post_notification( $post_ID, $post ) {
		if($post->post_type != 'post') { return true; }
		if( $post && $post->post_status == 'publish' ){
			$user 		= wp_get_current_user(); 
			$ntfObj 	= new JP_FollowAndNotification(); 
			$followers 	= $ntfObj->getFollowersByUserID($user->ID); 
			
			if($followers && count($followers)>0){
				foreach($followers as $follower){  
					$ntfObj->pushNotification($follower['follower_id'], $user->ID, 'post', $post_ID, 'open'); 
				} 
			}
		}
	}

   public function insert_comment_notification($id, $comment){ 
		if( $id && $comment ){ 
			$user 		= wp_get_current_user();
			$ntfObj 	= new JP_FollowAndNotification(); 
			// $followers 	= $ntfObj->getFollowersByUserID($user->ID); 
			$post   	= get_post( $comment->comment_post_ID );  
			$ntfObj->pushNotification( $post->post_author, $comment->user_id, 'comment', $comment->comment_post_ID, 'open' ); 

			// echo '<pre>';
			// print_r($post);
			// die();
			// exit(0);
			// if(count($followers)>0){
			// 	foreach($followers as $follower){  
			// 		$ntfObj->pushNotification( $follower['follower_id'], $comment->user_id, 'comment', $comment->comment_post_ID, 'open' ); 
			// 	} 
			// }
		}
   }

    /**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'jobportal' );
	}
	
	public function init(){
		new UserMetabox();
		// UserMetabox::instance();
		new UXjob();
		new Job_Post_Meta_Boxs();
	}

	public function jp_ajax_handaler(){
		new JBAjaxRequestHandaler($_POST);
	}
    
    /**
	 * Add user roles
	 *
	 * Fired by on plugin activition action hook.
	 * @since 1.0.0
	 * @access public 
	 */
    public static function add_user_roles(){ 
        add_role(
            'ux_professional',
            __( 'UX Professional', JPTD ),
            array(
                'read'         		=> true,  // true allows this capability
                'edit_posts'   		=> true,
                'publish_posts'   	=> true,
                'delete_posts' 		=> true, // Use false to explicitly deny
                'upload_files' 		=> true, // Use false to explicitly deny
            )
        ); 
        add_role(
            'job_recruiter',
            __( 'Job Recruiter', JPTD ),
            array(
                'read'         		=> true,  // true allows this capability
                'edit_posts'   		=> true,
                'publish_posts'   	=> true,
                'delete_posts' 		=> true, // Use false to explicitly deny
                'upload_files' 		=> true, // Use false to explicitly deny

            )
        ); 
	}

    /**
	 * Remove user roles
	 *
	 * Fired by on plugin deactivation action hook.
	 * @since 1.0.0
	 * @access public 
	 */
    public static function remove_user_roles(){
        remove_role('ux_professional');
        remove_role('job_recruiter');
    }

    /**
	 * pluign activation callback
	 *
	 * Fired by on plugin deactivation action hook.
	 * @since 1.0.0
	 * @access public 
	 */
    public static function on_plugin_activation(){
        self::remove_user_roles();
        self::add_user_roles();
    }

    /**
	 * pluign deactivation callback
     * 
	 * Fired by on plugin deactivation action hook.
	 * @since 1.0.0
	 * @access public 
	 */
    public static function on_plugin_deactivation(){ 
        self::remove_user_roles();
	}
	
	public function register_front_end_enqueuers(){
		/* register css for front-end */
		wp_register_style('jp_front_main_css', JP_PLUGIN_URI . 'assets/css/main.css', false, '12.3', 'all'); //$this->version
		wp_register_style('jp_sweetalert', JP_PLUGIN_URI . 'assets/css/sweetalert2.min.css', false, '12.2', 'all'); //$this->version

		/* register js for front-end */
		wp_register_script('jp_front_main_js', JP_PLUGIN_URI . 'assets/js/scripts.js', array('jquery'), '12.13', true); 
		wp_register_script('jp_sweetalert_js', JP_PLUGIN_URI . 'assets/js/sweetalert2.min.js', array('jquery'), '12.12', true);
		wp_register_script('admin-js', JP_PLUGIN_URI . 'assets/js/admin-js.js', array('jquery'), '12.13', true);
		global $redux_job;
		$redux_job['baseUrl'] = home_url('/');
		$userType = false;
		if(is_ux_professional()){
			$userType = 'ux';
		}
		if(is_job_recruiter()){
			$userType = 'jr';
		}

		wp_localize_script('jp_front_main_js', 'jpAjax', array(
			"ajaxurl" 		=> admin_url('admin-ajax.php'),
			"jobSettings" 	=> $redux_job,
			"userType"		=> $userType,
		));
		

		wp_enqueue_style('jp_front_main_css');
		wp_enqueue_style('jp_sweetalert');
		wp_enqueue_script('jp_front_main_js'); 
		wp_enqueue_script('jp_sweetalert_js');
		wp_enqueue_script('admin-js');
	}

	public function load_custom_wp_admin_style(){
		wp_enqueue_style( 'custom_wp_admin_css', plugins_url('assets/css/admin-style.css', __FILE__), false, '12.0', 'all' );
	}

	public function register_job_widget(){
		register_widget( 'JobPostWidget' );
	} 
}

new JobPortal();

//pluign activation hook
register_activation_hook( __FILE__, array('JobPortal', 'on_plugin_activation') );

//pluign deactivation hook
register_deactivation_hook( __FILE__, array('JobPortal', 'on_plugin_deactivation') );