<?php
function user_create_post( $atts ) {
    $terms = get_terms( array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    ));

    ob_start();

if ( is_user_logged_in() ) {
    if(!empty($_GET['case'])){
        $cat_id = $_GET['case'];
        $cat_name = 'Case';
    }elseif(!empty($_GET['articles'])){
        $cat_id = $_GET['articles'];
        $cat_name = 'Articles';
    }else{
       $cat_id = ''; 
       $cat_name = 'Select Category'; 
    }
    
?>
<div class="col-xl-12">
    <div class="post-form">
        <form method = "POST" id="add-post-job" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-7 offset-xl-1 col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <span class="label">What you want to Share</span>
                                <label for="sel1">Case</label>
                                <select class="form-control theme-select w-30-px" name="case_cat" id="category" required="true">
                                    <option value="<?php echo $cat_id; ?>"><?php echo $cat_name; ?></option>
                                    <?php foreach ($terms as $cat){
                                        echo '<option value="'. $cat->term_id .'">'. $cat->name .'</option>';   
                                        } 
                                        ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-11 col-lg-10">
                            <div class="form-field ">
                                <div class="form-field__control">
                                    <label for="title" class="form-field__label">Title</label>
                                    <input id="title" name="title" type="text" class="form-field__input"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-11 col-lg-10">
                            <div class="form-field">
                                <label for="discrption">Discrption:</label>
                                <?php wp_editor('','job_post');?>  
                            </div>
                        </div>                    
                    </div>
                    <div class="row d-xl-block d-lg-block d-md-none disable">
                        <div class="col-xl-12"><a href="#" id="job-submit" class="btn-theme-btn job-publshed">Publish</a> </div>
                    </div>                    
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                            <div class="form-field w-80">
                                <div class="header-image header-cover">
                                    <h3>Header image</h3>
                                    <div class="label">
                                        <img id="preview-img" src="" alt="" width="250px" height="100px;"> <br>
                                        <span>Use 1300px X 540px Image</span>
                                    </div>
                                    <div class="publish-btn">
                                        <input name="header_img" id="header_img" type="file" onchange="previewFile()">
                                        <span class="upload-preview-btn">Upload</span>
                                    </div>
                                    <!-- <input type="file" name="header_img" id="header_img" class="details-btn" onchange="previewFile()"> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                            <div class="form-field w-80">
                                <div class="header-image featured-post">
                                    <h3>Featured image</h3>
                                    <div class="label">
                                        <img id="preview-img2" src="" alt="" width="120px" height="120px;"> <br>
                                        <span>Use 180px X 180px Image</span>
                                    </div>
                                    <div class="publish-btn">
                                        <input name="header_featured" id="header_featured" type="file" onchange="previewFile2()">
                                        <span class="upload-preview-btn">Upload</span>
                                    </div>
                                    <!-- <input type="file" name="header_featured" id="header_featured" class="details-btn" onchange="previewFile2()"> -->
                                </div>
                            </div>
                        </div>  
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-field w-80">
                                <div class="header-image">
                                    <h3>Add Tags</h3>
                                    <div class="label">
                                        <span>Add tags separate with commas</span>
                                    </div>
                                    <input id="tags" type="text" name="tags" class="form-field__input" />
                                </div>
                            </div>
                        </div>                                              
                    </div>
                    <div class="row d-xl-none d-lg-none d-md-block d-sm-block">
                        <div class="d-flex justify-content-center w-100">
                            <a href="#" id="job-submit" class="btn-theme-btn job-publshed">Publish</a>                             
                        </div>  
                    </div>                      
                </div>
            </div>
        </form>
    </div>
</div>
<?php
} else {
   echo'<script> window.location="/Outsourcing/login"; </script> ';
  
}
?>
<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
    }

add_shortcode( 'user_create_post', 'user_create_post' );