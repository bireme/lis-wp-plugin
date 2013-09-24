<?php
function lis_page_admin() { 

    $lis_config = get_option('lis_config');

    ?>
    <div class="wrap">
            <form method="post" action="options.php">

                <?php settings_fields('lis-settings-group'); ?>

                <h2><?php _e('LIS Plugin Options', 'lis'); ?></h2>

                <h3><?php _e('LIS service information', 'lis'); ?></h3>
                
                <?php _e('Service URL:', 'lis'); ?> <input type="text" name="lis_config[service_url]" value="<?php echo $lis_config[service_url] ?>" class="regular-text code">

                <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            
            </form>
        </div>

        <?php
}
?>
