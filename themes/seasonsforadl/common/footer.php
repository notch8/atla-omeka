</div><!-- end content -->

<footer role="contentinfo">
     <div id="atla_footer">
          <ul>
               <li><a href="https://dl.atla.com/collections">Collections</a></li>
               <li><a href="https://dl.atla.com/institutions">Institutions</a></li>
               <li><a href="https://dl.atla.com/about">About</a></li>
               <li><a href="https://dl.atla.com/participate">Participate</a></li>
               <li><a href="https://dl.atla.com/search_tips">Search Tips</a></li>
               <li><a href="https://dl.atla.com/help">Help</a></li>
          </ul>
          <div>
               <span class="footer-name-one">Atla</span><br>
               <a href="https://www.atla.com/about/contact-us/" target="_blank">Contact us <i class="fas fa-external-link-alt"></i></a>
          </div>
     </div>
        <div id="custom-footer-text">
            <?php if ( $footerText = get_theme_option('Footer Text') ): ?>
            <p><?php echo $footerText; ?></p>
            <?php endif; ?>
            <?php if ((get_theme_option('Display Footer Copyright') == 1) && $copyright = option('copyright')): ?>
                <p><?php echo $copyright; ?></p>
            <?php endif; ?>
        </div>

    <?php fire_plugin_hook('public_footer', array('view' => $this)); ?>
    <div id="backtop">&#9650;</div>
</footer>

</div><!--end wrap-->

<script type="text/javascript">
jQuery(document).ready(function () {
    Omeka.showAdvancedForm();
    Omeka.skipNav();
    Omeka.megaMenu("#top-nav");
    Seasons.mobileSelectNav();
});
</script>

</body>

</html>
