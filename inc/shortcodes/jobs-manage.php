<?php
function user_manage_jobs( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Manage Jobs',
		'sub-title' => 'Summery of your contribution'
  ), $atts, 'bartag' );
  ob_start();

  $args=array(
    'post_type' => 'posts-jobs',
    'author' => get_current_user_id()
);                       
$wp_query = new WP_Query($args);

$UXJob = new UXjob();

?>
    <div class="col-md-12">
        <div class="header-text-panel-without-bg w-100">
            <section class="head-content flex-container">
                <div class="text-area">
                  <h1> <?php echo $atts['title']; ?> </h1>
                  <p> <?php echo $atts['sub-title']; ?> </p>
                </div>
            </section>
        </div>
    </div> 
      <div class="row">
        <div class="col-md-8 offset-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jobs</th>
                        <th scope="col">Total View</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // the query
                    $the_query = new WP_Query( $args ); ?>
                    
                    <?php if ( $the_query->have_posts() ) : ?>
                    
                        <!-- pagination here -->
                    
                        <!-- the loop -->
                        <?php $count = 1; ?>
                        <?php 
                            while ( $the_query->have_posts() ) : $the_query->the_post(); 
                            global $post;                        
                            $city       = get_post_meta( $post->ID, '_job_city');
                            $country    = get_post_meta( $post->ID, '_job_country');

                            $apply_date                         = get_the_date('F d Y');

                            $stapply_time                       = strtotime( $apply_date );
                            
                            // echo $exp                                = 1563321601;
                            $exp                                = strtotime('1 Days', $stapply_time);
                            $current_date                       = strtotime(date('F d Y'));
                            

                            



                        
                        ?>
                            
                            <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td>
                                    <h4><?php echo the_title(); ?></h4>
                                    <span><?php echo $city[0] . ', ' . $country[0]; ?></span>
                                    
                                </td>
                                <td><?php echo $UXJob->setPostViews($post->ID); ?></td>
                                <td> 
                                    <?php 
                                        if($current_date <= $exp ){
                                            echo '<span class="status">ACTIVE</span> <span class="renew">RENEW</span>';
                                        }else{
                                            echo '<span class="status">Closed</span> <span class="renew">RENEW</span>';
                                        }
                                                                           
                                    ?>
                                    
                                </td>
                            </tr>     
                        <?php $count ++; ?>                     
                        <?php endwhile; ?>
                        <!-- end of the loop -->
                    
                        <!-- pagination here -->
                    
                        <?php wp_reset_postdata(); ?>
                    
                    <?php else : ?>
                        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                    <?php endif; ?>                


                </tbody>
            </table>
        </div>
      </div> 

<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'user_manage_jobs', 'user_manage_jobs' );