<fieldset id="three">
    <div class="row">
    <div class="work-experience eductions-list">
        <?php
            $eductions    = get_user_meta($current_user->ID, '_job_user_edu', true);
            $eductions    =  unserialize($eductions);
            // echo '<pre>';
            // print_r($workExpericence);
            if(is_array($eductions) && count($eductions) > 0 ){
            foreach($eductions as $key=>$edu){
        ?>
        <div id="items-1" class="items" data-id="<?php echo $key; ?>" data-itemkey="<?php echo $key; ?>">
            <div class="actions float-right">
                <ul>
                <li><a href="#" class="editeduModal" ><i class="fa fa-edit"
                        aria-hidden="true"></i></a></li>
                <li><a class="item-delete deleteEduModal" href="#" ><i
                        class="fa fa-trash" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="text-items">
                <h2><?php echo $edu['course_name'] ?></h2>
                <p><?php echo $edu['institute_name'] ?></p>
                <span><?php 
                    $monthList = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    $start_month = (int)$edu['start_month'];
                    $start_year = $edu['start_year'];
                    $end_month = (int)$edu['end_month'];
                    $end_year = $edu['end_year'];
                    echo ucwords($monthList[$start_month]).' '.$start_year . ' - '. ucwords($monthList[$end_month]). ' '.$end_year. ' / '.$edu['city']. ', ' .$edu['country'];
                ?></span>
            </div>
            <input type="hidden" data-name="course_name" name="edu[<?php echo $key; ?>][course_name]" value="<?php echo $edu['course_name'] ?>" >
            <input type="hidden" data-name="institute_name" name="edu[<?php echo $key; ?>][institute_name]" value="<?php echo $edu['institute_name'] ?>" >
            <input type="hidden" data-name="city" name="edu[<?php echo $key; ?>][city]" value="<?php echo $edu['city'] ?>" >
            <input type="hidden" data-name="country" name="edu[<?php echo $key; ?>][country]" value="<?php echo $edu['country'] ?>" >
            <input type="hidden" data-name="start_month" name="edu[<?php echo $key; ?>][start_month]" value="<?php echo $edu['start_month'] ?>" >
            <input type="hidden" data-name="start_year" name="edu[<?php echo $key; ?>][start_year]" value="<?php echo $edu['start_year'] ?>" >
            <input type="hidden" data-name="end_month" name="edu[<?php echo $key; ?>][end_month]" value="<?php echo $edu['end_month'] ?>" >
            <input type="hidden" data-name="end_year" name="edu[<?php echo $key; ?>][end_year]" value="<?php echo $edu['end_year'] ?>" >
            <input type="hidden" data-name="description" name="edu[<?php echo $key; ?>][description]" value="<?php echo $edu['description'] ?>" >
        </div>
        <?php }  } ?>
        <a href="" class="add-view-btn" data-toggle="modal" data-target="#addeduModal"><i
            class="fa fa-plus-circle" aria-hidden="true"></i>
        Add more Educations</a>
    </div>
    </div>
    <div class="form-pagination  w-100">
    <a class="bg-none-with-border update user-profile-submit" href="">Update Information</a>
    <input type="button" name="next" class="next action-button skils" value="ADD SKILS" />
    </div>
</fieldset>