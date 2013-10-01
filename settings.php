<?php
function lis_page_admin() { 

    $lis_config = get_option('lis_config');

    ?>
    <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h2><?php _e('LIS Plugin Options', 'lis'); ?></h2>
            
            <form method="post" action="options.php">

                <?php settings_fields('lis-settings-group'); ?>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><?php _e('Service URL:', 'lis'); ?></th>
                            <td><input type="text" name="lis_config[service_url]" value="<?php echo $lis_config[service_url] ?>" class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Filter query:', 'lis'); ?></th>
                            <td><input type="text" name="lis_config[initial_filter]" value="<?php echo $lis_config[initial_filter] ?>" class="regular-text code"></td>
                        </tr>                        
                    </tbody>
                </table>

                <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            
            </form>
        </div>

        <?php
}
?>
