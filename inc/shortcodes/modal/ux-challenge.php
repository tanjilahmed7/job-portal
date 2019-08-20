<!-- education Modal Add-->
<div class="modal fade" id="UxChallengeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <h2 class="m-title w-100">UX Challenge</h2>                   
              <form id="ux-challenge-form" method="POST">
              <!--
                <div class="row">
                  <div class="col-sm">
                        <div class="form-group">
                          <select class="form-control theme-select" name="ux_challenge_cat" id="sel1" required="">
                           <option value="" selected="">Select Category</option> 
                              <?php 
                                  $ux_challenge_terms = get_terms( array(
                                      'taxonomy' => 'ux-challenge',
                                      'hide_empty' => false,
                                  ) );                              
                                foreach ($ux_challenge_terms as $cat) {
                                  echo '<option value="'. $cat->term_id  .'">'. $cat->name .'</option>';  
                                }  
                              ?>
                          </select>
                          
                      </div>
                  </div>

                </div>-->
                  <div class="row">
                      <div class="col-sm">
                          <div class="form-field">
                              <div class="form-field__control">
                                  <label for="Title"class="form-field__label">Title</label>
                                  <input id="ux_challenge_title"  name="ux_challenge_title" type="text" class="form-field__input" />
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm">
                           <div class="form-group">
                             <?php wp_editor('', 'ux_challege_discription'); ?>      
                           </div>     
                            
                      </div>
                  </div>

                  <div class="row">
                      <div class="form-btn w-100">
                          <a href="#" id="ux_challenge_submit" class="btn-theme-btn">Submit for Review</a>
                      </div>
                  </div>
              </form>          
            
        </div>
      </div>
    </div>
</div>
  