<?php

function lis_page_admin() {

    $lis_config = get_option('lis_config');

    $filter_db = array(
        "MEDLINE" => __("MEDLINE", "biblio"),
        "LILACS" => __("LILACS", "biblio"),
        "MedCarib" => __("MedCarib", "biblio"),
        "BBO" => __("BBO - Dentistry", "biblio"),
        "colecionaSUS" => __("Coleciona SUS", "biblio"),
        "BDENF" => __("BDENF - Nursing", "biblio"),
        "IBECS" => __("IBECS", "biblio"),
        "tese" => __("Index Psychology - Theses", "biblio"),
        "SIRPEP" => __("Index Psychology - Scientific divulgation", "biblio"),
        "RIPSA-CONSULTA" => __("RIPSA", "biblio"),
        "RIPSA-RELATORIOS" => __("RIPSA - Reports", "biblio"),
        "RIPSA-PRODUTOS" => __("RIPSA - Products", "biblio"),
        "fichasidb" => __("RIPSA - Qualification record", "biblio"),
        "RIPSA-NORMATIVOS" => __("RIPSA - Normative acts", "biblio"),
        "Puerto" => __("Theses - Puerto Rico", "biblio"),
        "A_DOLEC" => __("ADOLEC - Adolescence", "biblio"),
        "CidSaude" => __("CidSaúde - Healthy Cities", "biblio"),
        "DESASTRES" => __("Desastres - Disasters", "biblio"),
        "HANSENIASE" => __("Hanseníase - Leprosy", "biblio"),
        "HISA" => __("HISA - History of Health", "biblio"),
        "HomeoIndex" => __("HomeoIndex - Homeopathy", "biblio"),
        "INDEXPSI" => __("Index Psychology - Scientific journals", "biblio"),
        "REPIDISCA" => __("REPIDISCA", "biblio"),
        "respostas_aps" => __("SOF - Formative Second Opinion", "biblio"),
        "PAHO" => __("PAHO", "biblio"),
        "WHOLIS" => __("WHO IRIS", "biblio"),
        "CUMED" => __("CUMED", "biblio"),
    );

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
                        <td><input type="text" name="lis_config[plugin_slug]" value="<?php echo ($lis_config['plugin_slug'] != '' ? $lis_config['plugin_slug'] : 'lis'); ?>" class="regular-text code"></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Filter query', 'lis'); ?>:</th>
                        <td><input type="text" name="lis_config[initial_filter]" value='<?php echo $lis_config['initial_filter'] ?>' class="regular-text code"></td>
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
                        } else {
                            echo '<tr valign="top">';
                            echo '   <th scope="row">' . __("Page title", "lis") . ':</th>';
                            echo '   <td><input type="text" name="lis_config[plugin_title]" value="' . $lis_config["plugin_title"] .'" class="regular-text code"></td>';
                            echo '</tr>';
                        }
                    ?>

                    <tr valign="top">
                        <th scope="row"><?php _e('Disqus shortname', 'lis'); ?>:</th>
                        <td><input type="text" name="lis_config[disqus_shortname]" value="<?php echo $lis_config['disqus_shortname'] ?>" class="regular-text code"></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('AddThis profile ID', 'lis'); ?>:</th>
                        <td><input type="text" name="lis_config[addthis_profile_id]" value="<?php echo $lis_config['addthis_profile_id'] ?>" class="regular-text code"></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Google Analytics code', 'lis'); ?>:</th>
                        <td><input type="text" name="lis_config[google_analytics_code]" value="<?php echo $lis_config['google_analytics_code'] ?>" class="regular-text code"></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Related Documents filter', 'lis'); ?>:</th>
                        <td>
                            <input type="text" name="lis_config[default_filter_db]" value='<?php echo $lis_config['default_filter_db']; ?>' class="regular-text code">
                            <small style="display: block;">* <?php _e('The filters must be separated by commas.', 'lis'); ?></small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('More Related Documents filter', 'lis'); ?>:</th>
                        <td>
                            <input type="text" name="lis_config[extra_filter_db]" value='<?php echo $lis_config['extra_filter_db']; ?>' class="regular-text code">
                            <small style="display: block;">* <?php _e('The filters must be separated by commas.', 'lis'); ?></small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <?php _e('Page Layout', 'lis'); ?>:
                        </th>
                        <td>
                            <label for="whole_page">
                                <input type="radio" id="whole_page" value="whole_page" name="lis_config[page_layout]"  <?php if($lis_config['page_layout'] == 'whole_page' ){ echo 'checked'; }?>>
                                <?php _e('Show filters as whole page', 'lis'); ?>
                            </label>
                            <br />
                            <br />
                            <label for="normal_page">
                                <input type="radio" id="normal_page" value="normal_page" name="lis_config[page_layout]" <?php if(!isset($lis_config['page_layout']) || $lis_config['page_layout'] == 'normal_page' ){ echo 'checked'; }?> >
                                <?php _e('Show normal page', 'lis'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Sidebar order', 'lis');?>:</th>

                        <?php
                            if(!isset($lis_config['available_filter'])){
                                $lis_config['available_filter'] = 'Subjects';
                                $order = explode(';', $lis_config['available_filter'] );
                            } else {
                                $order = array_filter(explode(';', $lis_config['available_filter']));
                            }
                        ?>

                        <td>

                            <table border=0>
                                <tr>
                                    <td>
                                        <p align="right"><?php _e('Available', 'lis');?><br />
                                            <ul id="sortable1" class="droptrue">
                                                <?php
                                                    if(!in_array('Subjects', $order) && !in_array('Subjects ', $order) ){
                                                        echo '<li class="ui-state-default" id="Subjects">'.translate('Subjects','lis').'</li>';
                                                    }
                                                ?>
                                            </ul>
                                        </p>
                                    </td>

                                    <td>
                                        <p align="left"><?php _e('Selected', 'lis');?><br />
                                            <ul id="sortable2" class="sortable-list">
                                                <?php
                                                    foreach ($order as $index => $item) {
                                                        $item = trim($item); // Important
                                                        if($item != ''){
                                                            echo '<li class="ui-state-default" id="'.$item.'">'.translate($item ,'lis').'</li>';
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                            <input type="hidden" id="order_aux" name="lis_config[available_filter]" value="<?php echo trim($lis_config['available_filter']); ?> " >
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </tbody>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>

        </form>
    </div>
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        
        $j( function() {
          $j( "ul.droptrue" ).sortable({
            connectWith: "ul"
          });

          $j('.sortable-list').sortable({

            connectWith: 'ul',
            update: function(event, ui) {
              var changedList = this.id;
              var order = $j(this).sortable('toArray');
              var positions = order.join(';');
              $j('#order_aux').val(positions);

            }
          });
        } );
    </script>

    <?php
}
?>
