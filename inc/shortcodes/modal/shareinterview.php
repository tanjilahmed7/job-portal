<!-- education Modal Add-->
<div class="modal fade" id="ShareInterviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <h2 class="m-title w-100">Interview Question</h2>                    
              <form id="interview-form" class="w-100" method="POST">
                  <div class="row">
                      <div class="col-sm">
                          <div class="form-field">
                              <div class="form-field__control">
                                  <label for="write_interview_question"class="form-field__label">Write your Question</label>
                                  <textarea maxlength="150" id="write_interview_question" name="write_interview_question" class="form-field__input" cols="10" rows="5"></textarea>
                                  <div class="shareinterview-text-count float-right"> <span id="count-digit">0</span> / 150 </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-btn w-100">
                          <a href="#" id="share_interview_submit" class="btn-theme-btn">Submit for Review</a>
                      </div>
                  </div>
              </form>          
            
        </div>
      </div>
    </div>
</div>
  