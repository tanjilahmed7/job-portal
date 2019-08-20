<?php
function post_management( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Manage Contribution',
		'sub-title' => 'Summery of your contribution'
    ), $atts, 'bartag' );
     ob_start();
     
?>

    <div class="col-xl-12">
        <div class="header-text-panel-without-bg w-100">
            <section class="head-content flex-container">
                <div class="text-area">
                    <h1><?php echo $atts['title']; ?></h1>
                    <p><?php echo $atts['sub-title']; ?></p>
                </div>
            </section>
        </div>
    </div> 
    <div class="col-xl-8 offset-xl-2">
        <div class="manage-menu">
            <ul>
                <li data-tab="one"><a href="#">Pending</a></li>
                <li data-tab="two" ><a href="#">Published</a></li>
            </ul>
        </div>
        <div data-tab="one" id="Pending"> 
        <?php 
            $args = array (
                'post_type'     => array('post', 'ux-tools', 'ux-books'),
                'post_status'   => 'pending',
                'author'        => get_current_user_id()
            );
            // the query
            $the_query = new WP_Query( $args ); ?>
            
            <?php if ( $the_query->have_posts() ) : ?>
            
                <!-- pagination here -->
            
                <!-- the loop -->
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 

                    global $post;
                    include JP_PLUGIN_PATH. '/inc/shortcodes/modal/edit-resource.php';
                    // echo "<pre>";
                    // var_dump($post);
                    // echo "</pre>";
                    $terms = get_the_terms($post->ID, 'category' );
                    if ($post->post_type == 'post') {
                     ?>
                        <div id="items-<?php echo $post->ID; ?>" class="items" data-id="<?php echo $post->ID; ?>">
                            <div class="actions float-right">
                            <ul>
                                <li><a href="<?php echo get_permalink( get_page_by_path( 'edit-post' ) ) ?>?post=<?php echo $post->ID; ?>"><i class="fa fa-edit"data-id="<?php echo $post->ID; ?>" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="post-delete"  data-id="<?php echo $post->ID; ?>" class="item-delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                            </ul>
                            </div>
                            <div class="text-items">
                                <h2><?php the_title(); ?></h2>
                                <p><?php echo content(40); ?></p>
                                <span>Last edited <?php echo meks_time_ago(); /* post date in time ago format */ ?>  | <?php echo $terms[0]->name; ?></span>
                            </div>
                        </div>                           
                     <?php
                    } else if( $post->post_type == 'ux-tools'){
                        
                    ?>
                        <div id="items-<?php echo $post->ID; ?>" class="items" data-id="<?php echo $post->ID; ?>">
                            <div class="actions float-right">
                            <ul>
                                <li><a href="#" class="resource-edit"><i class="fa fa-edit " data-id="<?php echo $post->ID; ?>" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="post-delete"  data-id="<?php echo $post->ID; ?>" class="item-delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                            </ul>
                            </div>
                            <div class="text-items">
                                <h2><?php the_title(); ?></h2>
                                <span>Last edited <?php echo meks_time_ago(); /* post date in time ago format */ ?>  | UX-Tools</span>
                            </div>
                        </div>   

                    <?php
                    } 
                     else if( $post->post_type == 'ux-books'){

                    ?>
                        <div id="items-<?php echo $post->ID; ?>" class="items" data-id="<?php echo $post->ID; ?>">
                            <div class="actions float-right">
                            <ul>
                                <li><a href="#" class="resource-edit"><i class="fa fa-edit "data-id="<?php echo $post->ID; ?>" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="post-delete"  data-id="<?php echo $post->ID; ?>" class="item-delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                            </ul>
                            </div>
                            <div class="text-items">
                                <h2><?php the_title(); ?></h2>
                                <span>Last edited <?php echo meks_time_ago(); /* post date in time ago format */ ?>  | UX-Books</span>
                            </div>
                        </div>   

                    <?php
                    } 
                    ?>
              
                <?php endwhile; ?>
                <!-- end of the loop -->
            
                <!-- pagination here -->
            
                <?php wp_reset_postdata(); ?>
            
            <?php else : ?>
                <p><?php _e( 'No posts pending your criteria.' ); ?></p>
            <?php endif; ?>        
        </div>

        <div data-tab="two" id="Published" style="display:none"> 
            <?php 
            $args = array (
                'post_type'     => array('post', 'ux-tools', 'ux-books'),
                'post_status'   => 'publish',
                'author'        => get_current_user_id()
            );
            // the query
            $the_query = new WP_Query( $args ); ?>

            <?php if ( $the_query->have_posts() ) : ?>
            
                <!-- pagination here -->
            
                <!-- the loop -->
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 

                    global $post;
                    include JP_PLUGIN_PATH. '/inc/shortcodes/modal/edit-resource.php';
                    // echo "<pre>";
                    // var_dump($post);
                    // echo "</pre>";
                    $terms = get_the_terms($post->ID, 'category' );
                    if ($post->post_type == 'post') {
                        
                     ?>
                        <div id="items-<?php echo $post->ID; ?>" class="items" data-id="<?php echo $post->ID; ?>">
                            <div class="actions float-right">
                            <ul>
                                <li><a href="<?php echo get_permalink( get_page_by_path( 'edit-post' ) ) ?>?post=<?php echo $post->ID; ?>"><i class="fa fa-edit"data-id="<?php echo $post->ID; ?>" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="post-delete"  data-id="<?php echo $post->ID; ?>" class="item-delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                            </ul>
                            </div>
                            <div class="text-items">
                                <h2><?php the_title(); ?></h2>
                                <p><?php echo content(40); ?></p>
                                <span>Last edited <?php echo meks_time_ago(); /* post date in time ago format */ ?>  | <?php echo $terms[0]->name; ?></span>
                            </div>
                        </div>                           
                     <?php
                    } else if( $post->post_type == 'ux-tools'){
                        
                    ?>
                        <div id="items-<?php echo $post->ID; ?>" class="items" data-id="<?php echo $post->ID; ?>">
                            <div class="actions float-right">
                            <ul>
                                <li><a href="#" class="resource-edit"><i class="fa fa-edit "data-id="<?php echo $post->ID; ?>" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="post-delete"  data-id="<?php echo $post->ID; ?>" class="item-delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                            </ul>
                            </div>
                            <div class="text-items">
                                <h2><?php the_title(); ?></h2>
                                <span>Last edited <?php echo meks_time_ago(); /* post date in time ago format */ ?>  | UX-Tools</span>
                            </div>
                        </div>   

                    <?php
                    } 
                     else if( $post->post_type == 'ux-books'){
                    ?>
                        <div id="items-<?php echo $post->ID; ?>" class="items" data-id="<?php echo $post->ID; ?>">
                            <div class="actions float-right">
                            <ul>
                                <li><a href="#" class="resource-edit"><i class="fa fa-edit "data-id="<?php echo $post->ID; ?>" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="post-delete"  data-id="<?php echo $post->ID; ?>" class="item-delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                            </ul>
                            </div>
                            <div class="text-items">
                                <h2><?php the_title(); ?></h2>
                                <span>Last edited <?php echo meks_time_ago(); /* post date in time ago format */ ?>  | UX-Books</span>
                            </div>
                        </div>   

                    <?php
                    } 
                    ?>
              
                <?php endwhile; ?>
                <!-- end of the loop -->
            
                <!-- pagination here -->
            
                <?php wp_reset_postdata(); ?>
            
            <?php else : ?>
                <p><?php _e( 'No posts pending your criteria.' ); ?></p>
            <?php endif; ?>  
        
        </div>

        



    </div>
<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'post_management', 'post_management' );