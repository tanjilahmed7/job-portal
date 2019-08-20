<?php
function post_edit( $atts ) {
    $terms = get_terms( array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    ));

    ob_start();

$id =  $_GET['post'];
$post = get_post($id);
$header_image_id = get_post_meta($post->ID, '__add_job_header_img')[0];
$header_img_attachment = wp_get_attachment_url($header_image_id);
$category = get_the_terms($post->ID, 'category')[0];
$featued_img = get_the_post_thumbnail_url($post->ID);
$post_thumbnail_id = get_post_thumbnail_id( $post->ID);
$tags = get_the_tags($post->ID);
if ( is_user_logged_in() ) {
?>

<div class="col-xl-12">
    <div class="post-form" data-id=<?php echo $id; ?>>
        <form method = "POST" id="edit-post-job" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-7 offset-xl-1 col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <span class="label">What you want to Share</span>
                                <label for="sel1">Case</label>
                                <select class="form-control theme-select w-30-px" name="case_cat" id="category" required="true">
                                    <option value="<?php echo $category->term_id ?>"><?php echo $category->name ?></option>
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
                            <div class="form-field  form-field--is-filled  form-field--is-active">
                                <div class="form-field__control">
                                    <label for="title" class="form-field__label">Title</label>
                                    <input value="<?php echo $post->post_title ?>" id="title" name="title" type="text" class="form-field__input"/>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-11 col-lg-10">
                            <div class="form-field">
                                <label for="discrption">Discrption:</label>
                                <?php wp_editor($post->post_content,'job_post');?>  
                            </div>
                        </div>
                    </div>
                    <div class="row d-xl-block d-lg-block d-md-none disable">
                        <div class="col-xl-12">
                            <a href="#" id="job-update" class="btn-theme-btn">Update</a>                                            
                        </div>
                    </div>                     
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 ">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-6 post-edit-side-compontent col-sm-12 mb-4">
                            <div class="header-image header-cover">
                                <h3>Header image</h3>
                                <div class="label">
                                    <img id="preview-img" src="<?php echo $header_img_attachment; ?>" alt="" width="250px" height="100px;"> <br>
                                    <span id="headerSize">Use 1300px X 540px Image</span>
                                </div>
                                <div class="publish-btn">
                                    <input type="hidden" name="header_update_img" value="<?php echo $header_image_id; ?>">
                                    <input name="header_img" value="" id="header_img" type="file" onchange="previewFile()">
                                    <span class="upload-preview-btn">Upload</span>
                                </div>
                                <!-- <input type="file" name="header_img" id="header_img" class="details-btn" onchange="previewFile()"> -->
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-6 post-edit-side-compontent col-sm-12 mb-4">
                            <div class="header-image featured-post">
                                <h3>Featured image</h3>
                                <div class="label">
                                    <img id="preview-img2" src="<?php echo $featued_img; ?>" alt="" width="120px" height="120px;"> <br>
                                    <span id="featuedSize">Use 180px X 180px Image</span>
                                </div>
                                <div class="publish-btn">
                                    <input type="hidden" name="featured_update_img" value="<?php echo $post_thumbnail_id; ?>">
                                    <input name="header_featured" value="" id="header_featured" type="file" onchange="previewFile2()">
                                    <span class="upload-preview-btn">Upload</span>
                                </div>
                                <!-- <input type="file" name="header_featured" id="header_featured" class="details-btn" onchange="previewFile2()"> -->
                            </div>
                        </div> 
                       <div class="col-xl-12 col-lg-12 col-md-12 post-edit-side-compontent col-sm-12 mb-4">
                            <div class="header-image">
                                <h3>Add Tags</h3>
                                <div class="label">
                                    <span>Add tags separate with commas</span>
                                </div>
                                <input id="tags" value=" <?php if(!empty($tags)){foreach ($tags as $key => $value) { echo $value->name.','; } }?>"  type="text" name="tags" class="form-field__input" />
                            </div>
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

add_shortcode( 'post_edit', 'post_edit' );