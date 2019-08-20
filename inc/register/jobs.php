<?php
class UXjob{
	/**
 * Register a book post type.
 *
 */
	public function __construct(){
		// register post type
		add_action('init', array($this, 'video_init'));
		add_action('init', array($this, 'add_job_init'));
		add_action('init', array($this, 'ask_question_init'));
		add_action('init', array($this, 'post_taxonomies'));	
		add_action('init', array($this, 'video_taxonomies'));	
		add_action('init', array($this, 'ux_challenge_init'));	
		add_action('init', array($this, 'ux_challenge_taxonomies'));	
	}

	public function ask_question_init() {
		$labels = array(
			'name'               => _x( 'Ask Question', 'Ask Question type general name', 'ux-stories' ),
			'singular_name'      => _x( 'Ask Question', 'Ask Question type singular name', 'ux-stories' ),
			'menu_name'          => _x( 'Ask Question', 'admin menu', 'ux-stories' ),
			'name_admin_bar'     => _x( 'Ask Question', 'add new on admin bar', 'ux-stories' ),
			'add_new'            => _x( 'Add New', 'Ask Question', 'ux-stories' ),
			'add_new_item'       => __( 'Add New Ask Question', 'ux-stories' ),
			'new_item'           => __( 'New Ask Question', 'ux-stories' ),
			'edit_item'          => __( 'Edit Ask Question', 'ux-stories' ),
			'view_item'          => __( 'View Ask Question', 'ux-stories' ),
			'all_items'          => __( 'All Ask Question', 'ux-stories' ),
			'search_items'       => __( 'Search Ask Question', 'ux-stories' ),
			'parent_item_colon'  => __( 'Parent Ask Question:', 'ux-stories' ),
			'not_found'          => __( 'No Ask Question found.', 'ux-stories' ),
			'not_found_in_trash' => __( 'No Ask Question found in Trash.', 'ux-stories' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'ux-stories' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'ask-question' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'ask-question', $args );
	}

	// create two taxonomies, Category and writers for the post type "post"
	public function post_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Category', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Category', 'textdomain' ),
			'all_items'         => __( 'All Category', 'textdomain' ),
			'parent_item'       => __( 'Parent Category', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
			'edit_item'         => __( 'Edit Category', 'textdomain' ),
			'update_item'       => __( 'Update Category', 'textdomain' ),
			'add_new_item'      => __( 'Add New Category', 'textdomain' ),
			'new_item_name'     => __( 'New Category Name', 'textdomain' ),
			'menu_name'         => __( 'Category', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'job_cat' ),
		);

		register_taxonomy( 'job_cat', array( 'ux-jobs' ), $args );
	}

	public function add_job_init() {
		$labels = array(
			'name'               => _x( 'Jobs', 'Jobs type general name', 'ux-stories' ),
			'singular_name'      => _x( 'Jobs', 'Jobs type singular name', 'ux-stories' ),
			'menu_name'          => _x( 'Jobs', 'admin menu', 'ux-stories' ),
			'name_admin_bar'     => _x( 'Jobs', 'add new on admin bar', 'ux-stories' ),
			'add_new'            => _x( 'Add New', 'Jobs', 'ux-stories' ),
			'add_new_item'       => __( 'Add New Jobs', 'ux-stories' ),
			'new_item'           => __( 'New Jobs', 'ux-stories' ),
			'edit_item'          => __( 'Edit Jobs', 'ux-stories' ),
			'view_item'          => __( 'View Book', 'ux-stories' ),
			'all_items'          => __( 'All Jobs', 'ux-stories' ),
			'search_items'       => __( 'Search Jobs', 'ux-stories' ),
			'parent_item_colon'  => __( 'Parent Jobs:', 'ux-stories' ),
			'not_found'          => __( 'No Jobs found.', 'ux-stories' ),
			'not_found_in_trash' => __( 'No Jobs found in Trash.', 'ux-stories' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'ux-job' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'posts-jobs' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'   		=> 'dashicons-businessperson',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
		);

		register_post_type( 'posts-jobs', $args );
	}


	// Video Tutorials
	public function video_init() {
		$labels = array(
			'name'               => _x( 'Videos', 'Videos type general name', 'ux-stories' ),
			'singular_name'      => _x( 'Videos', 'Videos type singular name', 'ux-stories' ),
			'menu_name'          => _x( 'Videos', 'admin menu', 'ux-stories' ),
			'name_admin_bar'     => _x( 'Videos', 'add new on admin bar', 'ux-stories' ),
			'add_new'            => _x( 'Add New', 'Videos', 'ux-stories' ),
			'add_new_item'       => __( 'Add New Videos', 'ux-stories' ),
			'new_item'           => __( 'New Videos', 'ux-stories' ),
			'edit_item'          => __( 'Edit Videos', 'ux-stories' ),
			'view_item'          => __( 'View Book', 'ux-stories' ),
			'all_items'          => __( 'All Videos', 'ux-stories' ),
			'search_items'       => __( 'Search Videos', 'ux-stories' ),
			'parent_item_colon'  => __( 'Parent Videos:', 'ux-stories' ),
			'not_found'          => __( 'No Videos found.', 'ux-stories' ),
			'not_found_in_trash' => __( 'No Videos found in Trash.', 'ux-stories' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'ux-stories' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'videos' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'   		=> 'dashicons-format-video',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'videos', $args );
	}


	// create two taxonomies, Category and writers for the post type "post"
	public function video_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Category', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Category', 'textdomain' ),
			'all_items'         => __( 'All Category', 'textdomain' ),
			'parent_item'       => __( 'Parent Category', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
			'edit_item'         => __( 'Edit Category', 'textdomain' ),
			'update_item'       => __( 'Update Category', 'textdomain' ),
			'add_new_item'      => __( 'Add New Category', 'textdomain' ),
			'new_item_name'     => __( 'New Category Name', 'textdomain' ),
			'menu_name'         => __( 'Category', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'videos' ),
		);

		register_taxonomy( 'videos', array( 'videos' ), $args );
	}


		// Video Tutorials
	public function ux_challenge_init() {
		$labels = array(
			'name'               => _x( 'Ux Challenge', 'Ux Challenge type general name', 'ux-stories' ),
			'singular_name'      => _x( 'Ux Challenge', 'Ux Challenge type singular name', 'ux-stories' ),
			'menu_name'          => _x( 'Ux Challenge', 'admin menu', 'ux-stories' ),
			'name_admin_bar'     => _x( 'Ux Challenge', 'add new on admin bar', 'ux-stories' ),
			'add_new'            => _x( 'Add New', 'Ux Challenge', 'ux-stories' ),
			'add_new_item'       => __( 'Add New Ux Challenge', 'ux-stories' ),
			'new_item'           => __( 'New Ux Challenge', 'ux-stories' ),
			'edit_item'          => __( 'Edit Ux Challenge', 'ux-stories' ),
			'view_item'          => __( 'View Book', 'ux-stories' ),
			'all_items'          => __( 'All Ux Challenge', 'ux-stories' ),
			'search_items'       => __( 'Search Ux Challenge', 'ux-stories' ),
			'parent_item_colon'  => __( 'Parent Ux Challenge:', 'ux-stories' ),
			'not_found'          => __( 'No Ux Challenge found.', 'ux-stories' ),
			'not_found_in_trash' => __( 'No Ux Challenge found in Trash.', 'ux-stories' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'ux-stories' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'ux-challenge' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'   		=> 'dashicons-format-video',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'ux-challenge', $args );
	}


		// create two taxonomies, Category and writers for the post type "post"
	public function ux_challenge_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Category', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Category', 'textdomain' ),
			'all_items'         => __( 'All Category', 'textdomain' ),
			'parent_item'       => __( 'Parent Category', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
			'edit_item'         => __( 'Edit Category', 'textdomain' ),
			'update_item'       => __( 'Update Category', 'textdomain' ),
			'add_new_item'      => __( 'Add New Category', 'textdomain' ),
			'new_item_name'     => __( 'New Category Name', 'textdomain' ),
			'menu_name'         => __( 'Category', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'ux-challenge' ),
		);

		register_taxonomy( 'ux-challenge', array( 'ux-challenge' ), $args );
	}




	// Image Upload Functions
	public static function SetImageUpload($header_featured, $postId, $featuredsetImage = true, $metaKey = null, $width1 = null, $height1 = null, $delete = false){
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
	
		$featured_img = wp_handle_upload( $header_featured, array('test_form' => false ) );
        $filename = $featured_img['file'];
		list($width, $height) = getimagesize($filename);

		if($width === $width1 && $height === $height1 ){
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
			
			if($featuredsetImage == true){
				if( 0 < intval( $attachment_id ) ) {
				return set_post_thumbnail( $postId, $attachment_id );
				}
			}else{
				add_post_meta($postId, $metaKey, $attachment_id);
			}
		}else{
			if($delete === true){
				wp_delete_post( $postId );
				wp_send_json( array('image_errors'=> 'error', 'data'=> array('USE 180PX X 180PX IMAGE') ) );
			}
			
		}


	}


	public static function ImageUpload($header_featured, $postId, $featuredsetImage = true, $metaKey = null){
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
	
		$featured_img = wp_handle_upload( $header_featured, array('test_form' => false ) );
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
		
		if($featuredsetImage == true){
			if( 0 < intval( $attachment_id ) ) {
			return set_post_thumbnail( $postId, $attachment_id );
			}
		}else{
			add_post_meta($postId, $metaKey, $attachment_id);
		}
		


	}

	public static function SetUpdateImageUpload($header_featured, $postId, $featuredsetImage = true, $metaKey = null){
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
	
		$featured_img = wp_handle_upload( $header_featured, array('test_form' => false ) );
		$filename = $featured_img['file'];
		$size = getimagesize($filename);
		// $dimenetion = $size[3];
		// $getsize = explode(' ', $dimenetion);
		// var_dump(explode('=', $getsize));

		list($width, $height) = getimagesize($filename);

		if($width === 1300 && $height === 540 ){
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
			
			if($featuredsetImage == true){
				if( 0 < intval( $attachment_id ) ) {
				return set_post_thumbnail( $postId, $attachment_id );
				}
			}else{
				update_post_meta($postId, $metaKey, $attachment_id);
			}
		}else{
			wp_send_json( array('header_img'=> 'error', 'data'=> array('USE 1300PX X 540PX IMAGE') ) );
		}



	}


	public function setPostViews($postID) {
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
	
}

