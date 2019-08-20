<?php
$edit_resource = get_post($post->ID);

if (!empty(get_field('download_link'))){
    $links = get_field('download_link');
}elseif(!empty(get_post_meta($post->ID,'_ux_resourse_link'))){
    $links = get_post_meta($post->ID,'_ux_resourse_link')[0];
}
else{
    $links = '';
}



$post_thumbnail_id = get_post_thumbnail_id( $post->ID);

?>           
           
           <div class="modal fade modal-<?php echo $post->ID; ?>" data-modal="<?php echo $post->ID; ?>" id="EditResourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog font-end modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header-front">
                    <div class="row">
                        <div class="modal-closed col-md-12 float-right">
                        <button type="button" class="close closed-front" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    </div>
                    </div>
                    <div class="modal-body font-end">
                    <h2 class="m-title w-100">Share Resourse</h2>                    
                        <form id="edit-resourse-form-<?php echo $post->ID; ?>" class="w-100" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="form-group">
                                <label for="resourse_select">Resourse Type</label>
                                <select class="form-control theme-select" id="resourse_select" name="resourse_select">
                                    <option value="<?php echo $edit_resource->post_type; ?>"><?php echo ucfirst($edit_resource->post_type); ?></option>
                                    <option value="ux-tools">UX-Tools</option>
                                    <option value="ux-books">UX-Ebook</option>
                                </select>
                            </div> 
                                </div>                               
                            </div>
                            <div class="row">                
                                <div class="col-sm">
                                    <div class="form-field form-field--is-filled">
                                        <div class="form-field__control">
                                            <label for="title"class="default-input form-field__label">Title</label>
                                            <input value="<?php echo $edit_resource->post_title; ?>" id="title"  name="title" type="text" class="form-field__input"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="resourse_images_file">                                  
                                    <div class="preview"><img id="preview4" width="120" height="120" src="<?php echo get_the_post_thumbnail_url($post->ID, 'resourse'); ?>"/></div>
                                        <div class="form-group">
                                            <input type="hidden" name="current_images" value="<?php echo $post_thumbnail_id; ?>">
                                            <input type="file" class="form-control-file" name="featued_resourse" id="featued_resourse" onchange="previewFile4()">
                                            <span class="upload-preview-btn">Upload</span>
                                            <p>Recommended 400px X 400px</p>
                                        </div>                                 
                                </div>                           
                            </div>
                        
                            <div class="row">                
                                <div class="col-sm">
                                    <div class="form-field form-field--is-filled">
                                        <div class="form-field__control">
                                            <label for="resourse_link" class="default-input form-field__label">Resourse Link</label>
                                            <input value="<?php echo $links;  ?>" id="resourse_link"  name="resourse_link" type="text" class="form-field__input" />
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="form-btn w-100">
                                    <a href="#" id="UpdateResourseSubmit-<?php echo $post->ID; ?>" class="btn-theme-btn">Submit for Review</a>
                                </div>
                            </div>
                        </form>          
                        
                    </div>
                </div>
                </div>
            </div>