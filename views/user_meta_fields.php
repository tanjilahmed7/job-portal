<h2>Job Additional Info</h2>
<table class="form-table">
    <tr>
        <th>
            <label for="phone">Designation</label>
        </th>
        <td>
            <input type="text" class="regular-text ltr" id="phone" name="designation" 
                value="<?php echo  esc_attr(get_user_meta($user->ID, 'designation', true)); ?>" >
            <p class="description">
                Please enter your designation.
            </p>
        </td>
    </tr>
    <tr>
        <th>
            <label for="account_status">Years of experience</label>
        </th>
        <td>
        <?php  
            $experience = esc_attr(get_user_meta($user->ID, 'experience', true)); 
            echo '<select name="experience" id="experience">'; 
            for($i=0; $i <= 15; $i++){
                if($experience == $i){
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }else{
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
            }
            echo '<option value="15+">15 Plus</option>';
            echo '</select>';
        ?> 
        </td>
    </tr>
    <tr>
        <th>
            <label for="phone">Phone Number</label>
        </th>
        <td>
            <input type="text" class="regular-text ltr" id="phone" name="phone" 
                value="<?php echo  esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" >
            <p class="description">
                Please enter your phone number.
            </p>
        </td>
    </tr>
    <tr>
        <th>
            <label for="city">City</label>
        </th>
        <td>
            <input type="text" class="regular-text ltr" id="city" name="city" 
                value="<?php echo  esc_attr(get_user_meta($user->ID, 'city', true)); ?>" >
            <p class="description">
                Please enter your city.
            </p>
        </td>
    </tr>
    <tr>
        <th>
            <label for="country">Country</label>
        </th>
        <td>
            <input type="text" class="regular-text ltr" id="country" name="country" 
                value="<?php echo  esc_attr(get_user_meta($user->ID, 'country', true)); ?>" >
            <p class="description">
                Please enter your country.
            </p>
        </td>
    </tr> 
    <tr>
        <th>
            <label for="birthday">Address</label>
        </th>
        <td> 
            <textarea name="address" id="address" rows="5" cols="30"><?php echo esc_attr(get_user_meta($user->ID, 'address', true)); ?></textarea>
            <p class="description">
                Please enter your address.
            </p>
        </td>
    </tr>
    <tr>
        <th>
            <label for="birthday">Introduction</label>
        </th>
        <td> 
            <textarea name="introduction" id="introduction" rows="5" cols="30"><?php echo esc_attr(get_user_meta($user->ID, 'introduction', true)); ?></textarea>
            <p class="description">
                Please write your introduction.
            </p>
        </td>
    </tr>
</table>
<?php
    $current_user = wp_get_current_user();
    if ( in_array( 'administrator', (array) $current_user->roles ) ) {
?>
<h2>Job Account Info</h2>
<table class="form-table">
    <tr>
        <th>
            <label for="account_status">Account Status</label>
        </th>
        <td>
        <?php  
            $account_status = esc_attr(get_user_meta($user->ID, 'account_status', true)); 
        ?>
            <select name="account_status" id="account_status">
                <option value="active" <?php if($account_status == 'active'){ echo 'selected'; } ?>>Active</option>
                <option value="deactive" <?php if($account_status == 'deactive'){ echo 'selected'; } ?>>Deactive</option> 		
            </select>
        </td>
    </tr> 
</table>
<?php } ?>