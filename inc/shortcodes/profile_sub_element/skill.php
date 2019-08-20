<?php
    $softSkils = get_user_meta($user->ID, 'soft_skils', true);
    $uxUiSkils = get_user_meta($user->ID, 'ux_ui_skils', true);
    $toolsSkils = get_user_meta($user->ID, 'tools_skils', true);
?>
<div class="profile-full-view ">
    <div class="row">
        <div class="col-md-4">
            <h2>Skills</h2>
        </div>
        <div class="col-md-8">
        <?php 
            if( !empty($softSkils) && !empty($uxUiSkils) && !empty($toolsSkils) ){
        ?>
            <div class="row">
                <div class="col-md-4">
                    <h3>Soft Skills</h3>
                    <ul class="skll-list">
                        <?php  
                            if(!empty($softSkils)){
                                $softSkils = unserialize($softSkils);
                                if( is_array($softSkils) && ( count($softSkils) > 0 ) ){
                                    foreach($softSkils as $skill){
                                        echo '<li>'.$skill.'</li>';
                                    }
                                }
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>UX/UI Skills</h3>
                    <ul class="skll-list">
                        <?php  
                            if(!empty($uxUiSkils)){
                                $uxUiSkils = unserialize($uxUiSkils);
                                if( is_array($uxUiSkils) && ( count($uxUiSkils) > 0 ) ){
                                    foreach($uxUiSkils as $skill){
                                        echo '<li>'.$skill.'</li>';
                                    }
                                }
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Tools</h3>
                    <ul class="skll-list">
                        <?php  
                            if(!empty($toolsSkils)){
                                $toolsSkils = unserialize($toolsSkils);
                                if( is_array($toolsSkils) && ( count($toolsSkils) > 0 ) ){
                                    foreach($toolsSkils as $skill){
                                        echo '<li>'.$skill.'</li>';
                                    }
                                }
                            } 
                        ?>
                    </ul>
                </div>
            </div>
        <?php
            }else{
                echo '<div class="empty-msg">Skill hasn\'t added yet</div>';
            }
        ?>
        </div>
    </div>
</div>