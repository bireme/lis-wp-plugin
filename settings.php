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
                            <th scope="row"><?php _e('Plugin page', 'lis'); ?>:</th>
                            <td><input type="text" name="lis_config[plugin_slug]" value="<?php echo ($lis_config[plugin_slug] != '' ? $lis_config[plugin_slug] : 'lis'); ?>" class="regular-text code"></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?php _e('Filter query', 'lis'); ?>:</th>
                            <td><input type="text" name="lis_config[initial_filter]" value='<?php echo $lis_config[initial_filter] ?>' class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Search form', 'lis'); ?>:</th>
                            <td>
                                <input type="checkbox" name="lis_config[show_form]" value="1" <?php if ( $lis_config['show_form'] == '1' ): echo ' checked="checked"'; endif;?> >
                                <?php _e('Show search form', 'lis'); ?>
                            </td>
                        </tr>

                        <?php
                        if ( function_exists( 'pll_the_languages' ) ) {
                            $available_languages = pll_languages_list();
                            $available_languages_name = pll_languages_list(array('fields' => 'name'));
                            $count = 0;
                            foreach ($available_languages as $lang) {
                                $key_name = 'plugin_title_' . $lang;
                                $home_url = 'home_url_' . $lang;
                                echo '<tr valign="top">';
                                echo '    <th scope="row"> ' . __("Page title", "lis") . ' (' . $available_languages_name[$count] . '):</th>';
                                echo '    <td><input type="text" name="lis_config[' . $key_name . ']" value="' . $lis_config[$key_name] . '" class="regular-text code"></td>';
                                echo '</tr>';
                                $count++;
                            }
                        }else{
                            echo '<tr valign="top">';
                            echo '   <th scope="row">' . __("Page title", "lis") . ':</th>';
                            echo '   <td><input type="text" name="lis_config[plugin_title]" value="' . $lis_config["plugin_title"] .'" class="regular-text code"></td>';
                            echo '</tr>';
                        }
                        ?>

                        <tr valign="top">
                            <th scope="row"><?php _e('Disqus shortname', 'lis'); ?>:</th>
                            <td><input type="text" name="lis_config[disqus_shortname]" value="<?php echo $lis_config[disqus_shortname] ?>" class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('AddThis profile ID', 'lis'); ?>:</th>
                            <td><input type="text" name="lis_config[addthis_profile_id]" value="<?php echo $lis_config[addthis_profile_id] ?>" class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Google Analytics code', 'lis'); ?>:</th>
                            <td><input type="text" name="lis_config[google_analytics_code]" value="<?php echo $lis_config[google_analytics_code] ?>" class="regular-text code"></td>
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
