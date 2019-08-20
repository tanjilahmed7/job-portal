<?php
function casestudies( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'UX Case Studies',
		'sub-title' => 'Find 3000 of case stuides from UX professionals '
  ), $atts, 'bartag' );
  ob_start();
  
?>

    <div class="col-lg-12 col-sm-12">
        <div class="header-text-panel-without-bg w-100">
            <section class="head-content flex-container">
                <div class="text-area">
                <h1><?php echo $atts['title']; ?></h1>
                <p><?php echo $atts['sub-title']; ?></p>
                </div>
            </section>
        </div>
    </div> 
         <div class="case-study">
            <div class="row">       
                  <?php

                      $args = array(
                          'post_type' => 'post',
                          'posts_per_page'=> 100,
                          'tax_query' => array(
                              'relation' => 'OR',
                              array(
                                  'taxonomy' => 'category',
                                  'field'    => 'slug',
                                  'terms'    => 'case-study',
                              ),
                          ),                        
                      );
                      // The Query
                      $query1 = new WP_Query( $args );

                      // The Loop
                      while ( $query1->have_posts() ) {
                          $query1->the_post();
                          global $post;
                            // echo "<pre>";
                            //     print_r($post);
                            // echo "</pre>";
                          $terms = get_the_terms($post->ID, 'category' );
                      ?>
                        <div class="col-lg-6 col-sm-12">
                            <div class="case-studies">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="item">
                                        <div class="image">
                                            <img src="<?php  echo get_the_post_thumbnail_url($post->id,'case-studies'); ?>"/>
                                        </div>
                                        <div class="content">
                                            <span><?php echo $terms[0]->name; ?></span>
                                            <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                                            <p><?php echo wp_trim_words( get_the_content(), 15 ); ?></p>
                                            <span class="author"><?php echo get_the_author_meta('first_name', $post->post_author); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div> 
                        </div> 

                                            
                                
                        
                      <?php
                      }
                      

                      wp_reset_postdata();

                  
                  ?>                    
                           
             </div>
         </div>    
<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'casestudies', 'casestudies' );