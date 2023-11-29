<?php
global $lis_service_url;
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";

$lis_config = get_option('lis_config');
$lis_initial_filter = $lis_config['initial_filter'];

$site_language = strtolower(get_bloginfo('language'));

$query = ( isset($_GET['s']) ? sanitize_text_field($_GET['s']) : sanitize_text_field($_GET['q']) );
$query = stripslashes( trim($query) );
$sanitize_user_filter = sanitize_text_field($_GET['filter']);
$user_filter = stripslashes($sanitize_text_field);
$page = ( isset($_GET['pg']) ? sanitize_text_field($_GET['pg']) : 1 );
$total = 0;
$count = 10;
$filter = '';

if ($lis_initial_filter != ''){
    if ($user_filter != ''){
        $filter = $lis_initial_filter . ' AND ' . $user_filter;
    }else{
        $filter = $lis_initial_filter;
    }
}else{
    $filter = $user_filter;
}
$start = ($page * $count) - $count;

$lis_service_request = $lis_service_url . 'api/resource/search/?q=' . urlencode($query) . '&fq=' .urlencode($filter) . '&start=' . $start;

//print $lis_service_request;

$response = @file_get_contents($lis_service_request);
if ($response){
    $response_json = json_decode($response);
    //var_dump($response_json);
    $total = $response_json->diaServerResponse[0]->response->numFound;
    $start = $response_json->diaServerResponse[0]->response->start;
    $resource_list = $response_json->diaServerResponse[0]->response->docs;
    $descriptor_list = $response_json->diaServerResponse[0]->facet_counts->facet_fields->descriptor_filter;
}

$page_url_params = home_url($lis_plugin_slug) . '?q=' . urlencode($query) . '&filter=' . urlencode($filter);


?>
<rss version="2.0">
    <channel>
        <title><?php _e('Health Information Locator', 'lis') ?> | <?php echo $query ?></title>
        <link><?php echo htmlspecialchars($page_url_params) ?></link>
        <description><?php echo $query ?></description>
        <?php
            foreach ( $resource_list as $resource) {
                echo "<item>\n";
                echo "   <title>". htmlspecialchars($resource->title) . "</title>\n";
                if ($resource->author){
                    echo "   <author>". implode(", ", $resource->author) . "</author>\n";
                }
                echo "   <link>" . home_url($lis_plugin_slug) .'/resource/?id=' . $resource->django_id . "</link>\n";
                echo "   <description>". htmlspecialchars($resource->abstract) . "</description>\n";
                echo "   <guid isPermaLink=\"false\">" . $resource->django_id . "</guid>\n";
                echo "</item>\n";
            }
        ?>
    </channel>
</rss>
