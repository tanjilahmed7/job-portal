<?php
function add_jobs_form( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'Hiring fast, easy and effective!',
		'sub-title' => 'Summery of your contribution'
  ), $atts, 'bartag' );
   ob_start();


  include JP_PLUGIN_PATH. 'inc/shortcodes/modal/post-review.php';
 is_user_logged_in()
  ?>

<?php 
if ( is_user_logged_in() ) {
?>
<div class="col-xl-12">
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
    <div class="col-xl-8 col-lg-8 col-md-12 offset-lg-2 offset-xl-2 offset-md-0">
        <div id="messeage"></div>
        <form method="POST" id="msform" class="job-post-form">
            <!-- progressbar -->
            <div class="manage-menu">
                <ul id="progressbar">
                    <li class="active" data-id="one">Comapny Details</li>
                    <li data-id="two">Job Details</li>
                    <li data-id="three">Review & Payment </li>
                    <li data-id="four">Confirmation</li>
                </ul>
            </div>
            <!-- fieldsets -->
            <div class="job-step-form">
                <fieldset id="one">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-field">
                              <div class="form-field__control">
                                  <label for="CompanyName" class="form-field__label">Company Name</label>
                                  <input id="CompanyName" name="company_name" type="text" class="form-field__input" />
                              </div>
                          </div>                          
                        </div>
                    </div>     
                    <div class="row">
                      <div class="col-xl-6">
                          <div class="form-field">
                              <div class="form-field__control">
                                  <label for="City" class="form-field__label">City</label>
                                  <input id="City" type="text" name="city" class="form-field__input col-xl-12" />
                              </div>
                          </div>                         
                      </div>
                      <div class="col-xl-6">
                            <div class="form-field">
                                <div class="form-field__control">
                                    <label for="Country" class="form-field__label">Country</label>
                                    <input id="Country" name="country" type="text" class="form-field__input col-xl-12" />
                                </div>
                            </div>                           
                      </div>
                    </div>                                 
                    <div class="row">
                      <div class="col-xl-12">
                          <div class="form-field">
                              <div class="flex-area d-flex">
                                  <div class="upload">
                                      <div class="images_area_upload">
                                          <p class="w-100">Company Logo</p>
                                          <img id="p3" src="<?php echo get_template_directory_uri(); ?>/assets/img/thumbnails.png'" alt="">
                                          <img id="preview-img3" src="" alt="" width="120px" height="120px;"> <br>
                                      </div>
                                  </div>
                                  <div class="upload-btn-pic">
                                      <div class="publish-btn comapny-logo-job">
                                          <input name="company_logo" id="company_logo" type="file" onchange="previewFile3()">
                                          <span class="upload-preview-btn">Upload</span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                          <div class="form-field">
                            <div class="form-field__control">
                                <label for="CompanyWebsiteLink" class="form-field__label">Company Website Link</label>
                                <input id="CompanyWebsiteLink" type="text" name="company_website_link" class="form-field__input" />
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-pagination">
                        <input type="button" name="next" class="job-next action-button" value="CONTINUE" />
                    </div>
                </fieldset>
                <fieldset id="two">
                    <div class="job-details">
                        <div class="row">
                          <div class="col-xl-12">
                            <div class="form-field">
                                <div class="form-field__control">
                                    <label for="JobTitle" class="form-field__label">Job Title</label>
                                    <input id="JobTitle" type="text" name="job_title" class="form-field__input" />
                                </div>
                            </div>
                          </div>

                        </div>
                        <div class="row">
                            <label class="role" for="">Type of Role</label>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="padding:0">
                                <div class="form-field">
                                    <div class="type-of-role">
                                        <ul>
                                            <li class="first-parent">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="job_type" value="full-time" checked="checked">Full Time
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="job_type" value="part-time">Part Time
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="job_type" value="freelance">Freelance
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="job_type" value="contract">Contract
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="last-parent">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="job_type" value="Intership">Intership
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-12">
                            <div class="form-field">
                                <div class="experience">
                                    <label for="">What range of relevant experience are you looking for?</label>
                                    <div class="row">
                                        <select class="form-control theme-select col-xl-4" name="to">
                                            <?php for ($i = 1; $i <= 24; $i++) : ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <span class="col-xl-2">to</span>            
                                        <select class="form-control theme-select col-xl-4" name="from">
                                            <?php for ($i = 1; $i <= 24; $i++) : ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <span class="col-xl-2">years</span>                     
                                    </div>
                                </div>
                            </div>                            
                          </div>

                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-field">
                                    <div class="form-field">
                                        <label for="firstname" class="form-textarea-tinyeditor">Discription</label>
                                        <?php wp_editor( '', 'job_discription'); ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-xl-12">
                                <div class="form-field">
                                    <div class="form-field__control">
                                        <label for="ApplyLink" class="form-field__label">Link to Apply </label>
                                        <input id="ApplyLink" type="text" name="apply_link" class="form-field__input" />
                                    </div>
                                </div>                             
                           </div>
                        </div>
                    </div>
                    <div class="form-pagination">
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        <input type="button" name="next" class="job-next2 action-button" value="CONTINUE" />
                    </div>
                </fieldset>
                <fieldset id="three">
                    <div class="row">
                        <div class="review-page">
                            <div class="form-field">
                                <label for="">How long want to display job post?</label>
                                <div class="form-field__control">
                                    <label for="NumberOfDays" class="form-field__label">Number of days</label>
                                    <input id="NumberOfDays" type="number" name="number_of_days" class="form-field__input" />
                                </div>
                                <span class="post-show"> * minimum 10 days.</span>
                            </div>
                            <div class="pay float-left">
                                <h4>Total cost: <span id="doller">$10</span></h4>
                                <div class="verfiy-message">
                                    <div class="text-area">
                                        <p>You’re almost ready to write your UX stories, but first click the link in
                                            verify email which we’ve sent to <span>example@gmail.com</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-pagination">
                        <!-- <button type="button" name="submit" id="add_job_post" class="action-button" value="Review & Payment" /> -->
                        <button type="button" class="job-next3 action-button" id="review_post">Review & Payment</button>
                    </div>
                </fieldset>
                <fieldset id="four">
                    <div class="confirmation-message">
                        <div class="verfiy-message">
                            <div class="text-area">
                                <p>You’re almost ready to write your UX stories, but first click the link in
                                    verify email which we’ve sent to <span>example@gmail.com</span>
                                </p>
                            </div>
                        </div>
                        <div class="confirm-btn">
                            <a class="viewpost-btn" href="/manage-jobs">Manage jobs</a>
                        </div>
                    </div>
                </fieldset>
            </div>

        </form>
    </div>
</div> 
<?php
} else {
   echo'<script> window.location="/Outsourcing/login"; </script> ';
  
}
?>
  
      <script>
            jQuery('#preview').hide();
            function previewFile() {
              jQuery('#default-img').hide();
              jQuery('#preview').show();
              var preview = document.querySelector('#preview');
              var file = document.querySelector('input[type=file]').files[0];
              var reader = new FileReader();

              
              reader.addEventListener("load", function () {
                  preview.src = reader.result;
              }, false);


              if (file) {
                  reader.readAsDataURL(file);
            }
          }
          
          

      </script>
<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'add_jobs_form', 'add_jobs_form' );