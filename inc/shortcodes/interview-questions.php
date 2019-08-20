<?php
function interview_questions( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Interview Questions',
		'sub-title' => 'How to prepare for a UX Interview'
    ), $atts, 'bartag' );
    ob_start();

    $interview_terms = get_terms( 'interview_cat', array(
        'hide_empty' => false,
    ) );
     include JP_PLUGIN_PATH. '/inc/shortcodes/modal/shareinterview.php';
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
            <div class="col-xl-9 col-lg-8">      
        <div class="interview-section-dropdown">
                <span class="label">Select Role</span>
                <label id="category_label" class="field" for="category" data-value="Select role">
                    <span class="label-name">Choose Category</span>
                    <div id="category"class="psuedo_select"name="category">
                        <span class="selected"></span>
                        <ul id="interview_category_options"class="options">

                            <?php 
                                foreach ($interview_terms as $data){
                                    echo '<li class="option"data-value="' . $data->slug .'">'. $data->name .'</li>';
                                } 
                            ?>

                        </ul>
                    </div>
                </label>
        </div>
        <div class="interview-list">
            <ol>
                <?php

                    $args = array(
                        'post_type' => 'interview-question',
                        'tax_query' => array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'interview_cat',
                                'field'    => 'slug',
                                'terms'    => $interview_terms[0]->slug,
                            ),
                        ),                        
                    );
                    // The Query
                    $query1 = new WP_Query( $args );
                    
                    // The Loop
                    while ( $query1->have_posts() ) {
                        $query1->the_post();
                        echo '<li>' . get_the_title() . '</li>';
                    }
                    

                    wp_reset_postdata();

                
                ?>            

            </ol>
        </div>
    </div>
        <div class="sidebar">           
             <div class="ask w-100 pb-5">
                    <?php 
                    if ( is_user_logged_in() ) {
                        echo '<a href="#" id="ShareInterview" class="btn-theme-btn">Share interview Question</a>';
                    } else {
                        echo '<a href="'. home_url('/login').'" class="btn-theme-btn">Share interview Question</a>';
                    }

                    ?>
                 
            </div>       
             <?php dynamic_sidebar( 'sidebar-3' ); ?>
        </div>
    </div>

    

<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
	wp_reset_postdata();
}
add_shortcode( 'interview_questions', 'interview_questions' );