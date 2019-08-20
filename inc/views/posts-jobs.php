<?php
class Job_Post_Meta_Boxs 
{
    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [$this, 'save']);
    }
    public static function add()
    {
        $screens = ['posts-jobs'];
        foreach ($screens as $screen) {
            add_meta_box(
                'jobs_box_id',          // Unique ID
                'User Job Information', // Box title
                [self::class, 'html'],   // Content callback, must be of type callable
                $screen                  // Post type
            );
        }
    }

    public static function save($post_id)
    {


        if(!empty($_POST['company_name'])){
            $company    =  $_POST['company_name'];
            update_post_meta($post_id, '_job_company_name', $company);
        }
        if(!empty($_POST['city'])){
            $city  =  $_POST['city'];
            update_post_meta($post_id, '_job_city', $city);
        }
        if(!empty($_POST['country'])){
            $country  =  $_POST['country'];
            update_post_meta($post_id, '_job_country', $country);
        }
        if(!empty($_POST['company_website_link'])){
            $companylink  =  $_POST['company_website_link'];
            update_post_meta($post_id, '_job_company_website_link', $companylink);
        }
        if(!empty($_POST['job_type'])){
            $job_type  =  $_POST['job_type'];
            update_post_meta($post_id, '_job_job_type', $job_type);
        }
        if(!empty($_POST['to'])){
            $to   =  $_POST['to'];
            update_post_meta($post_id, '_job_to', $to);
        }
        if(!empty($_POST['from'])){
            $from   =  $_POST['from'];
            update_post_meta($post_id, '_job_from', $from);
        }
        if(!empty($_POST['apply_link'])){
            $apply_link  =  $_POST['apply_link'];
            update_post_meta($post_id, '_job_apply_link', $apply_link);
        }
        if(!empty($_POST['number_of_days'])){
            $numberofdays  =  $_POST['number_of_days'];
            update_post_meta($post_id, '_job_number_of_days', $numberofdays);
        }


        // Update Post Job


    }

   public static function html($post)
    {   
        $company                = get_post_meta($post->ID, '_job_company_name', true);
        $city                   = get_post_meta($post->ID, '_job_city', true);
        $country                = get_post_meta($post->ID, '_job_country', true);
        $company_website_link   = get_post_meta($post->ID, '_job_company_website_link', true);
        $job_type               = get_post_meta($post->ID, '_job_job_type', true);
        $to                     = get_post_meta($post->ID, '_job_to', true);
        $from                   = get_post_meta($post->ID, '_job_from', true);
        $apply_link             = get_post_meta($post->ID, '_job_apply_link', true);
        $number_of_days         = get_post_meta($post->ID, '_job_number_of_days', true);
    ?>
        <div class="form-group">
            <label for="company">Company Name</label>
            <input type="text" class="form-control" id="company" name="company_name"  value="<?php echo $company; ?>">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city"  value="<?php echo $city; ?>">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country"  value="<?php echo $country; ?>">
        </div>

        <div class="form-group">
            <label for="companylink">Companylink Website Link</label>
            <input type="text" class="form-control" id="companylink" name="company_website_link"  value="<?php echo $company_website_link; ?>">
        </div>
        
        <div class="form-group">
            <label for="job_type">Job Type</label>
            <input type="text" class="form-control" id="job_type" name="job_type"  value="<?php echo $job_type; ?>">
        </div>

        <div class="form-group">
            <label for="to">Experience To</label>
            <input type="text" class="form-control" id="to" name="to"  value="<?php echo $to; ?>">
        </div>

        <div class="form-group">
            <label for="from">Experience From</label>
            <input type="text" class="form-control" id="from" name="from"  value="<?php echo $from; ?>">
        </div>
        
        <div class="form-group">
            <label for="from">Apply Link</label>
            <input type="text" class="form-control" id="apply_link" name="apply_link"  value="<?php echo $apply_link; ?>">
        </div>

        <div class="form-group">
            <label for="numberofdays">Number Of Days</label>
            <input type="text" class="form-control" id="numberofdays" name="number_of_days"  value="<?php echo $number_of_days; ?>">
        </div>

    <?php 
    }    
     
}
