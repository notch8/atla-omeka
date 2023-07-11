<!DOCTYPE html>
<html class="<?php echo get_theme_option('Style Sheet'); ?>" lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>">
    <?php endif; ?>

    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>

    <!-- Stylesheets -->
    <?php
    queue_css_url('//fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic');
    queue_css_url('//fonts.googleapis.com/css?family=PT+Serif:400,700');
    queue_css_url('//fonts.googleapis.com/css?family=Muli:300,400,500,600,700,900');
    queue_css_file(array('iconfonts', 'normalize', 'style'), 'screen');
    queue_css_file('print', 'print');
    echo head_css();
    ?>
    <!-- JavaScripts -->
    <?php
    queue_js_file(array(
        'vendor/selectivizr',
        'vendor/jquery-accessibleMegaMenu',
        'vendor/respond',
        'jquery-extra-selectors',
        'seasons',
        'globals',
        'float-panel'
    ));
    ?>

    <?php echo head_js(); ?>
    <script src="https://kit.fontawesome.com/1c03965ab2.js" crossorigin="anonymous"></script>

</head>
<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <a href="#content" id="skipnav"><?php echo __('Skip to main content'); ?></a>
    <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
    <div id="wrap">
        <div id="atla_header">
             <div id="atla_inner">
                  <a href="https://dl.atla.com/">
                  <img src="https://dl.atla.com/assets/atla-logo-white-37c9b7ad9f9260bcda3f6a191bc1138fdc791ced022e94b1e9f4279b628686c3.png" alt="Atla logo"></a>
             </div>
        </div>

        <nav id="top-nav" class="top" role="navigation">
            <?php echo public_nav_main(); ?>
        </nav>

        <div id="content" role="main" tabindex="-1">
            <?php
                if(! is_current_url(WEB_ROOT)) {
                  fire_plugin_hook('public_content_top', array('view'=>$this));
                }
            ?>
