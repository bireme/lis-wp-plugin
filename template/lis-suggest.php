<?php
/*
Template Name: LIS Detail
*/

$lis_config = get_option('lis_config');

$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);

$request_uri = $_SERVER["REQUEST_URI"];
$request_parts = explode('/', $request_uri);
$resource_id = end($request_parts);

$lis_service_url = $lis_config['service_url'];
$lis_service_request = $lis_service_url . 'api/resource/search/?q=id:"main.resource.' .$resource_id . '"';

$response = @file_get_contents($lis_service_request);

if ($response){
    $response_json = json_decode($response);
    $resource = $response_json->diaServerResponse[0]->response->docs[0];
}

?>

<?php get_header(); ?>

<div id="content" class="row-fluid">
        <div class="ajusta2">
            <div class="row-fluid">
                <a href="<?php echo home_url(); ?>"><?php _e('Home','lis'); ?></a> > 
                <a href="<?php echo home_url($plugin_slug); ?>"><?php _e('Health Information Locator', 'lis') ?> </a> > 
                <?php _e('Suggest a site','lis'); ?>
            </div>

            <section id="conteudo">
                <header class="row-fluid border-bottom">
                    <h1 class="h1-header"><?php _e('Suggest a site','lis'); ?></h1>
                </header>
                <div class="row-fluid">
                    <article class="conteudo-loop">
                        <div class="conteudo-loop-rates">
                            <div class="star" data-score="1"></div>
                        </div>

                        <form method="post" action="<?php echo $lis_service_url ?>suggest-resource">

                           
                            <?php _e('Title', 'lis') ?> 
                            <p><input type="text" name="title" size="80"/></p>
                            
                            <?php _e('Link', 'lis') ?>
                            <p><input type="text"  name="link" size="80"/></p>

                            
                            <?php _e('Comments', 'lis') ?>
                            <p><textarea placeholder="" name="comments" rows="6" cols="80"></textarea>
                            </p>

                            <?php _e('Keywords', 'lis') ?>
                            <p><input type="text" placeholder="" name="keywords" size="80"/></p>


                            <script type="text/javascript">
                                var RecaptchaOptions = {
                                    theme : 'clean',
                                    lang : '<?php echo $site_lang ?>'
                                };
                            </script>
                            <script type="text/javascript"
                               src="http://www.google.com/recaptcha/api/challenge?k=6LcV0ugSAAAAAEpxBvqmNlnOZIAKSf_E6M-s8abc">
                            </script>
                            <noscript>
                               <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcV0ugSAAAAAEpxBvqmNlnOZIAKSf_E6M-s8abc"
                                   height="300" width="500" frameborder="0"></iframe><br>
                               <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                               </textarea>
                               <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                            </noscript>


                            <div>
                                <input type="submit" value="<?php _e('Send', 'lis') ?>"/>
                            </div>

                        </form>
    
                    </article>
                </div>
            </section>

        </div>
    </div>

<?php get_footer();?>