<fieldset id="four" class="skill-fields">
    <div class="row">
            <div class="col-xl-12">
                <div class="form-field">
                <div class="form-field__control">
                <label for="CompanyName" class="form-field__label">Soft Skils</label>
                <div class="skiles-box">
                    <?php 
                        $softSkils = get_user_meta($current_user->ID, 'soft_skils', true);
                        if(!empty($softSkils)){
                            $softSkils = unserialize($softSkils);
                            if( is_array($softSkils) && ( count($softSkils) > 0 ) ){
                                foreach($softSkils as $skill){
                                    echo '<span class="item">'.$skill.'<span class="close">X</span><input type="hidden" name="soft_skils[]" value="'.$skill.'" ></span>';
                                }
                            }
                        }
                    ?>
                </div>
                <input id="CompanyName" type="text" class="form-field__input soft_skils" data-role="tagsinput" placeholder="Type And Press Enter" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="form-field">
                    <div class="form-field__control">
                    <label for="CompanyName" class="form-field__label">UX/ UI Skils</label>
                    <div class="skiles-box">
                        <?php 
                            $uxUiSkils = get_user_meta($current_user->ID, 'ux_ui_skils', true);
                            if(!empty($uxUiSkils)){
                                $uxUiSkils = unserialize($uxUiSkils);
                                if( is_array($uxUiSkils) && ( count($uxUiSkils) > 0 ) ){
                                    foreach($uxUiSkils as $skill){
                                        echo '<span class="item">'.$skill.'<span class="close">X</span><input type="hidden" name="ux_ui_skils[]" value="'.$skill.'" ></span>';
                                    }
                                }
                            }
                        ?>
                    </div>
                    <input id="CompanyName" type="text" class="form-field__input ux_ui_skils"  placeholder="Type And Press Enter" />
                    </div>
                </div>
        </div>
 
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="form-field">
                <div class="form-field__control">
                <label for="CompanyName" class="form-field__label">Tools you use</label>
                <div class="skiles-box">
                    <?php 
                        $toolsSkils = get_user_meta($current_user->ID, 'tools_skils', true);
                        if(!empty($toolsSkils)){ 
                            $toolsSkils = unserialize($toolsSkils); 
                            if( is_array($toolsSkils) && ( count($toolsSkils) > 0 ) ){
                                foreach($toolsSkils as $skill){
                                    echo '<span class="item">'.$skill.'<span class="close">X</span><input type="hidden" name="tools_skils[]" value="'.$skill.'" ></span>';
                                }
                            }
                        }
                    ?>
                </div>
                <input id="CompanyName" type="text" class="form-field__input tools_skils"  placeholder="Type And Press Enter" />
                </div>
            </div>
        </div>
        <div class="form-pagination w-100">
            <a class="bg-none-with-border update user-profile-submit" href="">Update Information</a>
            <input type="button" name="next" class="next action-button skils" value="ADD SOCIAL" />
        </div>
    </div>
</fieldset>