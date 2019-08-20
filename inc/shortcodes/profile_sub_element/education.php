<div class="profile-full-view ">
    <div class="row">
        <div class="col-md-4">
            <h2>Education</h2>
        </div>
        <div class="col-md-8">
            <?php
                    $eductions = get_user_meta($user->ID, '_job_user_edu', true);
                    if( !empty($eductions) ){
                        $eductions =  unserialize($eductions);
                        if(is_array($eductions) && count($eductions) > 0 ){

                            foreach($eductions as $key=>$edu){
                                $start_month = (int)$edu['start_month'];
                                $start_year = $edu['start_year'];
                                $end_month = (int)$edu['end_month'];
                                $end_year = $edu['end_year'];
                                echo  '
                                    <article>
                                        <h3>'.$edu['course_name'].', '.$edu['institute_name'].'</h3>
                                        <span>'.ucwords($monthList[$start_month]).' '.$start_year . ' - '. ucwords($monthList[$end_month]). ' '.$end_year. ' / '.$edu['city']. ', ' .$edu['country'].'</span>
                                        <p>'.$edu['description'].'</p>
                                    </article>';
                            }
                        }else{
                            echo '<div class="empty-msg">Education hasn\'t added yet</div>';
                        }
                    }else{
                        echo '<div class="empty-msg">Education hasn\'t added yet</div>';
                    }
            ?>
        </div>
    </div>
</div>