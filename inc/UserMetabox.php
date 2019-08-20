<?php
class UserMetabox {

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
	public function __construct() {

        // add the fields to user's own profile editing screen
        add_action('edit_user_profile', array($this, 'add_user_meta_fields') );
        add_action('show_user_profile', array($this, 'add_user_meta_fields') );

        // add the save action to user profile editing screen update
        add_action('edit_user_profile_update', array($this, 'update_user_meta_fields') ); 
    }

    public function add_user_meta_fields($user){ 
        include JP_PLUGIN_PATH.'/views/user_meta_fields.php';
    }

    function update_user_meta_fields($user_id){ 
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        // echo '<pre>';
        // print_r($_POST);
        // die();
    
        // create/update user meta for the $user_id
        // add_user_meta($user_id, 'phone',$_POST['phone'] );
        update_user_meta($user_id, 'designation',$_POST['designation'] );
        update_user_meta($user_id, 'experience',$_POST['experience'] );
        update_user_meta($user_id, 'phone',$_POST['phone'] );
        update_user_meta($user_id, 'city',$_POST['city'] ); 
        update_user_meta($user_id, 'country',$_POST['country'] ); 
        update_user_meta($user_id, 'introduction',$_POST['introduction'] ); 
        update_user_meta($user_id, 'address',$_POST['address'] ); 
        update_user_meta($user_id, 'account_status', $_POST['account_status'] );
    }
}