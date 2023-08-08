<?php
/*
Template Name: LIS Detail
*/
global $suggest_url;

$lis_config = get_option('lis_config');
$site_language = strtolower(get_bloginfo('language'));

$site_link = $_POST['link'];
$site_meta_tags = array();

if ($site_link != ''){
    if ( preg_match('/^http/',$site_link) == false) {
        $site_link = "http://" . $site_link;
    }
    $site_meta_tags = get_site_meta_tags($site_link);
}

?>

<?php get_header('lis'); ?>

<script src='https://www.google.com/recaptcha/api.js'></script>

<script language="javascript">
    function onSubmit(){
        document.getElementById("suggest-form").submit();
    }
</script>

<div id="content" class="row-fluid">
        <div class="ajusta2">
            <div class="row-fluid">
                <a href="<?php echo real_site_url(); ?>"><?php _e('Home','lis'); ?></a> >
                <a href="<?php echo real_site_url($lis_plugin_slug); ?>"><?php _e('Health Information Locator', 'lis') ?> </a> >
                <?php _e('Suggest a site','lis'); ?>
            </div>

            <section id="conteudo">
                <header class="row-fluid border-bottom">
                    <h1 class="h1-header"><?php _e('Suggest a site','lis'); ?></h1>
                </header>
                <div class="row-fluid">
                    <article class="conteudo-loop suggest-form">

                        <form method="post" id="suggest-form" action="<?php echo $suggest_url ?>">
                            <?php _e('Link', 'lis') ?>
                            <p><input type="text"  name="link" size="80" value="<?php echo $site_link ?>"/></p>

                            <?php _e('Title', 'lis') ?>
                            <p><input type="text" name="title" size="80" value="<?php echo $site_meta_tags['title'] ?>"/></p>

                            <?php _e('Keywords', 'lis') ?>
                            <p><input type="text" placeholder="" name="keywords" size="80" value="<?php echo $site_meta_tags['keywords'] ?>"/></p>

                            <?php _e('Abstract', 'lis') ?>
                            <p><textarea placeholder="" name="abstract" rows="6" cols="80"><?php echo $site_meta_tags['description'] ?></textarea>
                            </p>

                            <button
                                class="g-recaptcha"
                                data-sitekey="6Lczl08UAAAAACjpV0PZ_1exDzQ7SJA_TmDrwI2U"
                                data-callback="onSubmit">
                                <?php _e('Send', 'lis') ?>
                            </button>
                        </form>

                    </article>
                </div>
            </section>

        </div>
    </div>

<?php get_footer();?>
