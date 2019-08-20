
<div class="profile-full-view ">
    <div class="row">
        <div class="col-md-4">
            <h2>Experience</h2>
        </div>
        <div class="col-md-8">
            <?php 
                $workExpericence = get_user_meta($user->ID, '_job_user_exp', true); 
                if( !empty($workExpericence) ){
                    $workExpericence =  unserialize($workExpericence);
                    //print_r($workExpericence);
                    $monthList = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    if(is_array($workExpericence) && count($workExpericence) > 0 ){

                        foreach($workExpericence as $workexp){ 
                            $start_month = (int)$workexp['start_month'];
                            $start_year = $workexp['start_year'];
                            $end_month = (int)$workexp['end_month'];
                            $end_year = $workexp['end_year'];
                            echo '<article>
                                    <h3>'.$workexp['designation'].', '. $workexp['company_name'].'</h3>';
                                if( $workexp['current'] == 'yes' ){
                                    echo '<span>'.ucwords($monthList[$start_month]).' '.$start_year . ' -  PRESENT / '.$workexp['city']. ', ' .$workexp['country'].'</span>';
                                }else{
                                    echo '<span>'.ucwords($monthList[$start_month]).' '.$start_year . ' - '. ucwords($monthList[$end_month]). ' '.$end_year. ' / '.$workexp['city']. ', ' .$workexp['country'].'</span>';
                                }
                            echo '<p>'.$workexp['description'].'</p></article>';
                        }
                    }else{
                        echo '<div class="empty-msg">Expericence hasn\'t added yet</div>';
                    }
                }else{
                    echo '<div class="empty-msg">Expericence hasn\'t added yet</div>';
                }
            ?>
        </div>
    </div>
</div>