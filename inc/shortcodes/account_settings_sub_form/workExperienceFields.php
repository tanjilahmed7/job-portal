<fieldset id="two">
    <div class="row">
    <div class="work-experience experience-list" id="work-experience">
        <?php
            $workExpericence = get_user_meta($current_user->ID, '_job_user_exp', true);
            // var_dump($workExpericence);
            $workExpericence =  unserialize($workExpericence);
            // echo '<pre>';
            // print_r($workExpericence);
            if(is_array($workExpericence) && count($workExpericence) > 0 ){
            foreach($workExpericence as $key=>$work){
        ?>
        <div id="items-1" class="items" data-id="<?php echo $key; ?>" data-itemkey="<?php echo $key; ?>">
            <div class="actions float-right">
                <ul>
                <li><a href="#" class="editExpericence" ><i class="fa fa-edit"
                        aria-hidden="true"></i></a></li>
                <li><a class="item-delete deleteExpericenceModelOpen" href="#" ><i
                        class="fa fa-trash" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="text-items">
                <h2><?php echo $work['company_name'] ?></h2>
                <p><?php echo $work['designation'] ?></p>
                <span><?php 
                    $monthList = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    $start_month = (int)$work['start_month'];
                    $start_year = $work['start_year'];
                    $end_month = (int)$work['end_month'];
                    $end_year = $work['end_year'];
                    echo ucwords($monthList[$start_month]).' '.$start_year . ' - '. ucwords($monthList[$end_month]). ' '.$end_year. ' / '.$work['city']. ', ' .$work['country'];
                ?></span>
            </div>  
            
            <input type="hidden" data-name="designation" name="exp[<?php echo $key; ?>][designation]" value="<?php echo $work['designation'] ?>" >
            <input type="hidden" data-name="company_name" name="exp[<?php echo $key; ?>][company_name]" value="<?php echo $work['company_name'] ?>" >
            <input type="hidden" data-name="current" name="exp[<?php echo $key; ?>][current]" value="<?php echo $work['current'] ?>" >
            <input type="hidden" data-name="city" name="exp[<?php echo $key; ?>][city]" value="<?php echo $work['city'] ?>" >
            <input type="hidden" data-name="country" name="exp[<?php echo $key; ?>][country]" value="<?php echo $work['country'] ?>" >
            <input type="hidden" data-name="start_month" name="exp[<?php echo $key; ?>][start_month]" value="<?php echo $work['start_month'] ?>" >
            <input type="hidden" data-name="start_year" name="exp[<?php echo $key; ?>][start_year]" value="<?php echo $work['start_year'] ?>" >
            <input type="hidden" data-name="end_month" name="exp[<?php echo $key; ?>][end_month]" value="<?php echo $work['end_month'] ?>" >
            <input type="hidden" data-name="end_year" name="exp[<?php echo $key; ?>][end_year]" value="<?php echo $work['end_year'] ?>" >
            <input type="hidden" data-name="description" name="exp[<?php echo $key; ?>][description]" value="<?php echo $work['description'] ?>" >
        </div>
        <?php }  } ?>
        <a href="" class="add-view-btn" data-toggle="modal" data-target="#addExpericenceModal"><i
            class="fa fa-plus-circle" aria-hidden="true"></i>
        Add more experience</a>
    </div>
    </div>
    <div class="form-pagination  w-100">
    <a class="bg-none-with-border update user-profile-submit" href="">Update Information</a>
    <input type="button" name="next" class="next action-button skils" value="ADD EDUCATION" />
    </div>
</fieldset>