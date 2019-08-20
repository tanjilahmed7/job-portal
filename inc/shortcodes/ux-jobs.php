<?php
function ux_jobs( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'UX Jobs',
		'sub-title' => 'Find 1000 UX jobs from aorund the world'
    ), $atts, 'bartag' );
    



$args = array(
    'post_type'  => 'posts-jobs',
);



$the_query = new WP_Query( $args ); ?>


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
    <div class="row">
        <div class="col-xl-9 offset-xl-1 col-lg-9 col-md-9 col-sm-12">
            <div class="ux-job-form col-sm-10 offset-sm-12">
                <div class="row">
                        <form method="POST" id="msform">
                            <div class="job-search-form ">
                                <div class="search-items">
                                    <div class="form-group">
                                        <!-- <i class="fa fa-search" aria-hidden="true"></i> -->
                                        <img class="search-icon" src="<?php echo get_template_directory_uri() ?>/assets/img/serarch-icon.png" alt="">
                                        <input type="text" class="form-control" id="search-job" name="search_job" placeholder="Search Job">
                                    </div>
                                </div>
                                <div class="search-items">
                                    <div class="form-group">
                                        <img class="location-icon" src="<?php echo get_template_directory_uri() ?>/assets/img/location.png" alt="">
                                        <input type="text" class="form-control" id="search-job" name="search_location" placeholder="Search Location">
                                    </div>
                                </div>
                                <div class="search-items">
                                    <div class="form-group">
                                        <span class="number-of-count">0</span>
                                        <div class="dropdown">
                                            <a href="#"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-align-center" aria-hidden="true"></i></a>
                                            
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <ul class="filter-dropdown">
                                                    <li>
                                                        <div class="form-check">
                                                            
                                                            <input class="form-check-input" type="checkbox" name="search_type[]" value="full-time" id="search-job-type">
                                                            <label class="form-check-label" for="search-job-type">
                                                                Full-Time
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="part-time" name="search_type[]" id="search-job-type">
                                                            <label class="form-check-label" for="search-job-type">
                                                                Part-Time
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="remote"  name="search_type[]"id="search-job-type">
                                                            <label class="form-check-label" for="search-job-type">
                                                                Remote
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="freelance" name="search_type[]" id="search-job-type">
                                                            <label class="form-check-label" for="search-job-type">
                                                                Freelance
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-items">
                                    <div class="form-group">
                                    <div class="find-btn">
                                        <a href="#" id="ux-job-filter" class="filter-btn">Find</a>
                                    </div>   
                                    </div>
                                </div>
                            </div>                
                        </form>
                    </div>                
            </div>
            <div class="ux_job_filter col-sm-12 col-md-12">
                    <?php if ( $the_query->have_posts() ) : ?>
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        
                        <?php global $post; ?>
                        <?php 
                            $title = get_post_meta($post->ID, '_job_job_title');
                            $city = get_post_meta($post->ID, '_job_city');
                            $country = get_post_meta($post->ID, '_job_country');
                            $job_type = get_post_meta($post->ID, '_job_job_type');
                        ?>
                        <div class="row">
                            <div class="job-list">
                                <div class="job-list-items">
                                    <div class="job-items">
                                        <div class="image">
                                            <a href="<?php the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url($post->ID, 'thumbnail'); ?>" alt="image"></a>
                                        </div>
                                        <div class="text-block">    
                                        <h3><a href="<?php the_permalink(); ?>"><?php echo $title[0]; ?></a></h3>
                                        <span><?php echo $city[0]; ?>, <?php echo $country[0] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list-items">
                                <div class="job-type">
                                    <span><?php echo $job_type[0]; ?></span>
                                </div>
                                </div>
                                <div class="job-list-items">
                                <div class="times">
                                    <span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
                                </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    <!-- end of the loop -->
                
                    <!-- pagination here -->
                
                    <?php wp_reset_postdata(); ?>
                
                <?php else : ?>
                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                <?php endif; ?>

            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 d-sm-flex justify-content-sm-center">
            <div class="ux-jobs sidebar">
                <div class="ux-practise-box">
                    <h2>Starting at $50
                        for 30 days</h2>
                    <h6><a href="/add-job">Post a Job</a></h6>
                </div>
            </div>            
        </div>
        
    </div>
    
<?php    

}
add_shortcode( 'ux_jobs', 'ux_jobs' );