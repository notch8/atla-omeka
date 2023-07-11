<?php
echo head(array(
    'title' => metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title'),
    'bodyclass' => 'exhibits show'));
    $exhibitNavOption = get_theme_option('exhibits_nav');
?>

<header role="banner">
   <div id="site-title">
        <?php echo link_to_home_page(theme_logo()); ?>
   </div>
   <button class="back-to-all"><?php echo link_to_home_page('All Exhibitions'); ?></button>
   <h1 class="exhibit-title"><?php echo metadata('exhibit', 'title'); ?></h1>
   <div id="search-container" role="search">
        <?php if (get_theme_option('use_advanced_search') === null || get_theme_option('use_advanced_search')): ?>
        <?php echo search_form(array('show_advanced' => true)); ?>
        <?php else: ?>
        <?Php echo search_form(); ?>
        <?php endif; ?>
   </div>
   <?php fire_plugin_hook('public_header', array('view'=>$this)); ?>
</header>


<?php if ($exhibitNavOption == 'full'): ?>
<nav id="exhibit-pages" class="full">
    <?php echo exhibit_builder_page_nav(); ?>
</nav>
<?php endif; ?>


<?php if (count(exhibit_builder_child_pages()) > 0 && $exhibitNavOption == 'full'): ?>
<nav id="exhibit-child-pages" class="secondary-nav">
    <?php echo exhibit_builder_child_page_nav(); ?>
</nav>
<?php endif; ?>

<?php if (($exhibitNavOption == 'side') || !isset($exhibitNavOption)): ?>
<nav id="exhibit-pages" class="side">
    <h4><?php echo exhibit_builder_link_to_exhibit($exhibit); ?></h4>
    <?php echo exhibit_builder_page_tree($exhibit, $exhibit_page); ?>
</nav>

<div role="main" id="exhibit-blocks">
     <h1><span class="exhibit-page"><?php echo metadata('exhibit_page', 'title'); ?></span></h1>
<?php exhibit_builder_render_exhibit_page(); ?>
</div>

<div id="exhibit-page-navigation">
    <?php if ($prevLink = exhibit_builder_link_to_previous_page()): ?>
    <div id="exhibit-nav-prev">
    <?php echo $prevLink; ?>
    </div>
    <?php endif; ?>
    <?php if ($nextLink = exhibit_builder_link_to_next_page()): ?>
    <div id="exhibit-nav-next">
    <?php echo $nextLink; ?>
    </div>
    <?php endif; ?>
    <div id="exhibit-nav-up">
    <?php echo exhibit_builder_page_trail(); ?>
    </div>
</div>


<?php endif; ?>

<?php echo foot(); ?>
