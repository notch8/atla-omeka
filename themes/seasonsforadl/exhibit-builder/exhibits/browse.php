<?php
$title = __('Atla Digital Library Exhibitions');
echo head(array('title' => $title, 'bodyclass' => 'exhibits browse'));
?>

<h1><?php echo $title; ?> <?php echo __('(%s total)', $total_results); ?></h1>
<?php if (count($exhibits) > 0): ?>
<!--
<nav class="navigation" id="secondary-nav">
    <?php /* echo nav(array(
        array(
            'label' => __('Browse All'),
            'uri' => url('exhibits')
        ),
        array(
            'label' => __('Browse by Tag'),
            'uri' => url('exhibits/tags')
        )
   )); */?>
</nav> put in both html and php comment to hide this -->

<header role="banner">
   <div id="site-title">
        <?php echo link_to_home_page(theme_logo()); ?>
        <!--<p>Exhibits description here.</p>-->
   </div>
</header>

<?php echo pagination_links(); ?>
<div id="exhibits-home">
<?php $exhibitCount = 0; ?>
<?php foreach (loop('exhibit') as $exhibit): ?>
    <?php $exhibitCount++; ?>
    <div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
        <?php if ($exhibitImage = record_image($exhibit, 'fullsize')): ?>
            <?php echo exhibit_builder_link_to_exhibit($exhibit, $exhibitImage, array('class' => 'image')); ?>
        <?php endif; ?>
         <h2><?php echo link_to_exhibit(); ?></h2>
        <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
        <div class="description"><?php echo $exhibitDescription; ?></div>
        <?php endif; ?>
        <?php if ($exhibitTags = tag_string('exhibit', 'exhibits')): ?>
        <p class="tags"><?php echo __('Tags: ') . $exhibitTags; ?></p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>
<?php echo pagination_links(); ?>

<?php else: ?>
<p><?php echo __('There are no exhibits available yet.'); ?></p>
<?php endif; ?>

<?php echo foot(); ?>
