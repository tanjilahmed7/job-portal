<?php
/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class JobPostWidget extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_job_post_entries', 'description' => __( "The most recent posts on your site") );
        parent::__construct('job-posts', __('Job Posts'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }
    
    private function getTallerUser( $limit = 10){
        global $wpdb;
        $table = $wpdb->prefix.'posts';
        $topuser = $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM {$table} WHERE ( ( post_type = 'post' AND ( post_status = 'publish' OR post_status = 'private' ) ) ) GROUP BY post_author ORDER BY count DESC LIMIT ".$limit );
        if(is_array($topuser) && count($topuser) > 0){
            return $topuser;
        }
        return false;
        
    }
    
    private function countFollowersByUserID($userId){
        global $wpdb;
        $table = $wpdb->prefix.'user_followers';
        $query = 'SELECT * FROM '.$table.' WHERE user_id='.$userId;  
        $results = $wpdb->get_results($query); 
        return $wpdb->num_rows;
    }
    
    private function ProfileImage($current_user){
        $image = wp_get_attachment_url( get_user_meta($current_user->ID, 'profile_image', true) );
        if( !empty($image) ){
          return $image;
        }else{
          return get_template_directory_uri().'/assets/img/plato.png';
        }
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $job_post_type  = ( ! empty( $instance['job_post_type'] ) ) ? $instance['job_post_type'] : 'post';
        $job_cat_type   = ( ! empty( $instance['job_cat_type'] ) ) ? $instance['job_cat_type'] : '';
        $view_all_text  = ( ! empty( $instance['view_all_text'] ) ) ? $instance['view_all_text'] : 'View all';
        $view_all_link  = ( ! empty( $instance['view_all_link'] ) ) ? $instance['view_all_link'] : '#';
        $title          = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
        $title          = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number         = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        if($job_post_type == 'top-user'){
            $popularUser = $this->getTallerUser(); 

            echo '<div class="top-story-tellers">';
                if ( $title ) echo '<h3>' . $title . '</h3>';  
                if($popularUser){
                    foreach($popularUser as $singleuser){
                        $userObj = get_user_by('id', $singleuser->post_author);
                        echo '<div class="top-item">
                                <div class="image">
                                    <img src="'.$this->ProfileImage($userObj).'" alt="">
                                </div>
                                <div class="content">
                                    <h4>'.get_user_meta($userObj->ID, 'first_name', true).' '.get_user_meta($userObj->ID, 'last_name', true).'</h4>
                                    <span class="author">'.get_user_meta($userObj->ID, 'designation', true).'</span>
                                    <span class="follwers">'.$this->countFollowersByUserID($userObj->ID).' Followers</span>
                                </div>
                            </div>';
                    }
                    echo '<div class="all-view-ebooks w-100"><a href="'.$view_all_link.'" class="sidebar-btn">'.$view_all_text.'</a></div>';
                }
            echo '</div>';
        }else{
            $r = new WP_Query( array( 
                    'post_type'             => $job_post_type,
                    'posts_per_page'        => $number, 
                    'no_found_rows'         => true, 
                    'post_status'           => 'publish', 
                    'ignore_sticky_posts'   => true 
                ));
                
            
            if ($r->have_posts()) :
                $parent_class = '';
                if($job_post_type == 'ux-books'){ 
                    $parent_class = 'ux-ebooks';
                    $link = '#';
                    
                 }
                if($job_post_type == 'posts-jobs'){ 
                    $parent_class = 'ux-jobs'; 
                    $link = get_permalink();


                }
                echo '<div class="'.$parent_class.'">';
                    // echo $before_widget;
                            // if ( $title ) echo $before_title . $title . $after_title;  
                            if ( $title ) echo '<h3>' . $title . '</h3>';  
                            while ( $r->have_posts() ) : $r->the_post();
                                global $post; 
                                if($job_post_type == 'ux-books'){
                                    $terms = get_the_terms( $post->ID, 'uxbooks_cat' );
                                }else{
                                    $terms = get_the_terms($post->ID, 'category' );
                                }
                                echo '<div class="top-item col-xl-12 col-lg-12 col-md-6">';
                                    echo '<div class="image">';
                                        echo '<a href="'. $link  .'"><img src="'.get_the_post_thumbnail_url($post->id,'sidebar_thumb').'"/></a>';
                                    echo '</div>'; 
                                    echo '<div class="content">';
                                        if($job_post_type == 'posts-jobs'){
                                            $job_type = get_post_meta($post->ID, '_job_job_type');
                                            echo '<span>'.$job_type[0].'</span>';
                                        }else{
                                            if(!empty($terms[0])){
                                                $name = $terms[0]->name;
                                            }
                                            echo '<span>'.$name.'</span>';
                                        }

                                        echo '<h4>'.get_the_title().'</h4>';
                                        if($job_post_type == 'posts-jobs'){
                                            $city = get_post_meta($post->ID, '_job_city');
                                            $country = get_post_meta($post->ID, '_job_country'); 
                                            echo '<span class="author">'.$city[0].', '.$country[0].'</span>';
                                        }
                                        if($job_post_type == 'ux-books'){
                                            echo '<div class="jobs w-100"><a href="'.get_field('download_link').'" class="btn-theme-btn">Download</a></div>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            endwhile; 
                    // echo $after_widget;  
                    wp_reset_postdata();
                    echo '<div class="all-view-ebooks w-100"><a href="'.$view_all_link.'" class="sidebar-btn">'.$view_all_text.'</a></div>';
                echo '</div>'; 
            endif;
        }

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']              = strip_tags($new_instance['title']);
        $instance['number']             = (int) $new_instance['number'];
        $instance['job_post_type']      = $new_instance['job_post_type'];
        $instance['job_cat_type']       = $new_instance['job_cat_type'];
        $instance['view_all_text']      = $new_instance['view_all_text'];
        $instance['view_all_link']      = $new_instance['view_all_link'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $view_all_text  = isset( $instance['view_all_text'] ) ?  $instance['view_all_text'] : '';
        $view_all_link  = isset( $instance['view_all_link'] ) ?  $instance['view_all_link'] : '#';
        $post_type      = isset( $instance['job_post_type'] ) ?  $instance['job_post_type'] : 'post';
        $cat_type       = isset( $instance['job_cat_type'] ) ? (int)$instance['job_cat_type'] : '';
        $title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5; 

        $categories = get_categories( array(
            'orderby' => 'name',
            'order'   => 'ASC'
        ) );
        // echo '<pre>';
        // print_r($instance);
        // echo '</pre>';
?>
        <p>
			<label for="widget-pages-2-sortby">Select Post Type:</label>
			<select 
                name="<?php echo $this->get_field_name( 'job_post_type' ); ?>" 
                id="<?php echo $this->get_field_id( 'job_post_type' ); ?>" class="widefat">
				<option value="post" <?php if($post_type == 'post'){ echo 'selected="selected"'; } ?> >Post</option>  
				<option value="posts-jobs" <?php if($post_type == 'posts-jobs'){ echo 'selected="selected"'; } ?> >Jobs</option>  
				<!-- <option value="videos" <?php //if($post_type == 'videos'){ echo 'selected="selected"'; } ?> >Videos</option>   -->
				<!-- <option value="ux-tools" <?php //if($post_type == 'ux-tools'){ echo 'selected="selected"'; } ?>>Ux Tools</option>   -->
				<option value="ux-books" <?php if($post_type == 'ux-books'){ echo 'selected="selected"'; } ?>>Ux Books</option>  
				<option value="top-user" <?php if($post_type == 'top-user'){ echo 'selected="selected"'; } ?>>Top Teller</option>  
			</select>
        </p>
        <p>
			<label for="widget-pages-2-sortby">Select Category Type:</label>
			<select 
                name="<?php echo $this->get_field_name( 'job_cat_type' ); ?>" 
                id="<?php echo $this->get_field_id( 'job_cat_type' ); ?>" class="widefat">
                <?php
                    if(is_array($categories) && count($categories) > 0){
                        foreach ($categories as $cat) {
                            $selected = '';
                            if($cat->term_id == $cat_type){ 
                                $selected = 'selected="selected"'; 
                            }
                            echo '<option value="'.$cat->term_id.'" '.$selected.' >'.$cat->name.'</option>';
                        }
                    }
                ?> 
			</select>
		</p>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><label for="<?php echo $this->get_field_id( 'view_all_text' ); ?>"><?php _e( 'View All Button Text:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'view_all_text' ); ?>" name="<?php echo $this->get_field_name( 'view_all_text' ); ?>" type="text" value="<?php echo $view_all_text; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'view_all_link' ); ?>"><?php _e( 'View All Button Link:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'view_all_link' ); ?>" name="<?php echo $this->get_field_name( 'view_all_link' ); ?>" type="text" value="<?php echo $view_all_link; ?>" /></p>
<?php
    }
}