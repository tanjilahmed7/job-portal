<!-- education edit -->
<div class="modal fade" id="editeduModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog font-end" role="document">
      <div class="modal-content">
        <div class="modal-header-front">
          <div class="row">
            <div class="modal-closed col-xl-12 float-right">
              <button type="button" class="close closed-front" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
        <div class="modal-body font-end">
          <h2 class="m-title w-100">Edit Education</h2>
          <form class="modal-form" id="editeduForm" action="">
            <div class="row">
              <div class="col-xl-12">
                <div class="form-field form-field--is-filled">
                  <div class="form-field__control">
                    <label for="CompanyName" class="form-field__label">Course Name</label>
                    <input id="CompanyName" type="text" name="course_name" class="form-field__input" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-12">
                <div class="form-field form-field--is-filled">
                  <div class="form-field__control">
                    <label for="CompanyName" class="form-field__label">Institute Name</label>
                    <input id="CompanyName" type="text" name="institute_name" class="form-field__input" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-6">
                <div class="form-field form-field--is-filled" style="">
                  <div class="form-field__control" style="">
                    <label for="City" class="form-field__label">City</label>
                    <input id="City" type="text" name="city" class="form-field__input" />
                  </div>
                </div>
              </div>
              <div class="col-xl-6">
                <div class="form-field" style="">
                  <div class="form-field__control" style="">
                    <label for="Country" class="form-field__label">Country</label>
                    <input id="Country" type="text" name="country" class="form-field__input" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-3">
                <div class="date-section-dropdown">
                  <span class="label">Start</span>
                  <label id="category_label" class="field" for="category" data-value="Select role"></label>
                  <select class="theme-select w-100" name="start_month">
                    <?php
                      $monthList = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                      echo '<option value>Month</option>';
                      foreach($monthList as $key=>$value){
                        echo '<option value="'.$key.'">'.$value.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-3">
                <div class="date-section-dropdown">
                  <span class="label">Start</span>
                  <label id="category_label" class="field" for="category" data-value="Select role"></label>
                  <select class="theme-select w-100" name="start_year">
                    <?php 
                      $currentDate = date("Y");
                      $currentDate = (int)$currentDate;
                      echo '<option value>Year</option>';
                      for($i = 1900; $i <= $currentDate ; $i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-3">
                <div class="date-section-dropdown">
                  <span class="label">End</span>
                  <label id="category_label" class="field" for="category" data-value="Select role"></label>
                  <select class="theme-select w-100" name="end_month">
                    <?php
                      $monthList = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                      echo '<option value>Month</option>';
                      foreach($monthList as $key=>$value){
                        echo '<option value="'.$key.'">'.$value.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-3">
                <div class="date-section-dropdown">
                <span class="label">End</span>
                  <label id="category_label" class="field" for="category" data-value="Select role"></label>
                  <select class="theme-select w-100" name="end_year">
                    <?php 
                      $currentDate = date("Y");
                      $currentDate = (int)$currentDate;
                      echo '<option value>Year</option>';
                      for($i = 1900; $i <= $currentDate ; $i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-12">
                <div class="form-field form-field--is-filled">
                  <div class="form-field__control">
                    <label for="CompanyName" class="form-field__label">Course Discription</label> 
                    <textarea class="form-field__input" name="description" cols="30" rows="6"></textarea> 
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-btn">
                <a class="modal-cancel-btn mr-3" href="#" data-dismiss="modal" aria-label="Close">Close</a>
                <a class="modal-submit-btn editEduModal-submit" href="">Submit</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
  