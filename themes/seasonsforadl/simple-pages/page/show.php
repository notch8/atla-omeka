<?php echo head(array(
    'title' => metadata('simple_pages_page', 'title'),
    'bodyclass' => 'page simple-page',
    'bodyid' => metadata('simple_pages_page', 'slug')
)); ?>

<header role="banner">
   <div id="site-title">
        <?php echo link_to_home_page(theme_logo()); ?>
   </div>
   <button class="back-to-all"><?php echo link_to_home_page('All Exhibitions'); ?></button>
   <h1><?php echo metadata('simple_pages_page', 'title'); ?></h1>
   <div id="search-container" role="search">
        <?php if (get_theme_option('use_advanced_search') === null || get_theme_option('use_advanced_search')): ?>
        <?php echo search_form(array('show_advanced' => true)); ?>
        <?php else: ?>
        <?Php echo search_form(); ?>
        <?php endif; ?>
   </div>
   <?php fire_plugin_hook('public_header', array('view'=>$this)); ?>
</header>

<div id="primary">
    <?php
    $text = metadata('simple_pages_page', 'text', array('no_escape' => true));
    echo $this->shortcodes($text);
    ?>
</div>

<?php echo foot(); ?>
