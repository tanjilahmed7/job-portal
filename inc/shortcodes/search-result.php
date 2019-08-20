<?php
function search_result( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Search Result',
		'sub-title' => 'Find 3000 of case stuides  '
    ), $atts, 'bartag' );

    if(isset($_GET['search']) && !empty($_GET['search']) ){
        $keyword = $_GET['search'];
        // var_dump($keyword);
        $searchQuery = new WP_Query(array(
                        's'                 => $keyword, 
                        'post_type' => array( 'post', 'ux-tools', 'ux-books' ),  
                        'post_type'         => 'post', 
                        "posts_per_page"    =>5, 
                        'post_status' => 'publish', 
                        'order' => 'ASC'
                    )); 
    ob_start();
    $atts['sub-title'] ='Find '.$searchQuery->post_count.' of Post from'.$keyword;
    
    ?>

        <div class="col-md-12">
            <div class="header-text-panel-without-bg w-100">
                <section class="head-content flex-container">
                    <div class="text-area">
                    <h1><?php echo $atts['title']; ?></h1>
                    <p><?php echo $atts['sub-title']; ?></p>
                    </div>
                </section>
            </div>
        </div> 
            <div class="case-study search-result-posts">
                <div class="row">       
                    <?php 

                        if($searchQuery->have_posts()): 
                    //         echo '<pre>';
                    // print_r($searchQuery);
                    // echo '</pre>';
                        // The Loop
                        while ( $searchQuery->have_posts() ) {
                            $searchQuery->the_post();
                            global $post;

                            $terms = get_the_terms($post->ID, 'category' );
                        ?>
                                <div class="col-md-4">
                                    <div class="case-studies">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="item">
                                                <div class="image">
                                                    <img src="<?php  echo get_the_post_thumbnail_url($post->id,'full'); ?>"/>
                                                </div>
                                                <div class="content">
                                                    <span><?php echo $terms[0]->name; ?></span>
                                                    <h4><?php the_title(); ?></h4> 
                                                    <span class="author"><?php echo get_the_author_meta('display_name', $post->post_author); ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </div> 
                                </div>             
                        <?php
                        }  
                    wp_reset_postdata();
                    endif;
                    if($searchQuery->post_count == 0){
                        echo '<div class="empty-result"><h2>Not Found</h2></div>';
                    } 

                    
                    ?>                    
                            
                </div>
            </div>    
    <?php
        $output_string = ob_get_contents();
        ob_end_clean();
        return $output_string;
    }
}
add_shortcode( 'search_result', 'search_result' );