<?php
function ux_challenge( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'UX Challenge',
		'sub-title' => 'How to prepare for a UX Interview'
    ), $atts, 'bartag' );
    ob_start();



    include JP_PLUGIN_PATH. '/inc/shortcodes/modal/ux-challenge.php';
     

?>


    <div class="col-xl-12">
        <div class="header-text-panel-without-bg w-100">
            <section class="head-content flex-container">
                <div class="text-area">
                <h1> <?php echo $atts['title']; ?> </h1>
                <p><?php echo $atts['sub-title']; ?></p>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-7 offset-xl-1 col-lg-8">
            
            <ul class="ask_question">
                <?php
                    $args = array(
                        'post_type' => 'ux-challenge',                       
                    );
                    // The Query
                    $query1 = new WP_Query( $args );
                    
                    // The Loop
                    // $data = [''];
                    while ( $query1->have_posts() ) {
                        $query1->the_post();
                        global $post;
                        $terms = get_the_terms($post->ID, 'ux-challenge' );
                        
                        if(!empty($terms[0])){
                            $cat_name = $terms[0]->name;
                        }else{
                            $cat_name = '';
                        }
                        
                        echo '<li class="ask-list"><span>'. $cat_name  .'</span><h3><a href="'. get_permalink() .'">' . get_the_title() . '</a></h3></li>';
                        
                    }
                ?>                
            </ul>
            
          
        </div>
        <div class="col-xl-3 col-lg-4 col-md-12 offset-xl-1">
            <?php 
            if ( is_user_logged_in() ) {
            ?>
                <div class="ask w-100 pb-5">
                    <a href="#" id="ux-challenge-modal" class="btn-theme-btn">Submit Challenge</a>
                </div>
            <?php
            }
            ?>   
            <div class="sidebar">
                <?php dynamic_sidebar( 'sidebar-3' ); ?>
            </div>
        </div>


<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
	wp_reset_postdata();
}
add_shortcode( 'ux_challenge', 'ux_challenge' );