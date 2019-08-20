<?php
function ask_question( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Ask Questions',
		'sub-title' => 'How to prepare for a UX Interview'
    ), $atts, 'bartag' );
    ob_start();

    include JP_PLUGIN_PATH. '/inc/shortcodes/modal/ask-question.php';

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
                        'post_type' => 'ask-question',                       
                    );
                    // The Query
                    $query1 = new WP_Query( $args );
                    
                    // The Loop
                    // $data = [''];
                    while ( $query1->have_posts() ) {
                        $query1->the_post();
                        echo '<li class="ask-list"><h3><a href="'. get_permalink() .'">' . get_the_title() . '</a></h3><span class="res">'. get_comments_number() .' Response</span></li>';
                        
                        
                    }
                ?>                
            </ul>
            
          
        </div>
    <div class="col-xl-3 offset-xl-1 col-lg-4 col-md-12">

            <div class="sidebar">
                    <?php 
                    if ( is_user_logged_in() ) {
                ?>
                        <div class="ask w-100 pb-5">
                            <a href="#" id="ask-question" class="btn-theme-btn">Ask Question</a>
                        </div>
                <?php
                    }else{
                        echo '<a href="'. home_url('/login') .'" class="btn-theme-btn">Ask Question</a>';
                    }
                    ?>        
                    <?php dynamic_sidebar( 'sidebar-3' ); 
                    ?>

            </div>
            
    </div>


<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
	wp_reset_postdata();
}
add_shortcode( 'ask_question', 'ask_question' );