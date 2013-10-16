<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
$t =& peTheme();
?>

 </div>
    <!-- /Content -->

    <!-- Footer -->
    <div id="footer">
        <div class="container clearfix">
            <?php $t->footer->widgets(); ?>
             <!-- Social Links -->
            <ul class="social-links">
                <?php $t->content->socialLinks($t->options->get("footerSocialLinks"),"footer"); ?>
            </ul>
            <!-- /Social Links -->

        </div>

        <div class="clear"></div>

        <div class="info container clearfix">

            <!-- Copyright -->
            <ul class="copyright">
                <li><?php echo do_shortcode($t->options->get("footerCopyright")) ?></li>
                <?php $t->menu->show("footer","simple"); ?>
            </ul>
            <!-- /Copyright -->

           
        </div>
    </div>
    <!-- /Footer -->

</div>
<!-- /Main Container -->

<!-- Back to Top -->
<div id="back-top"><a href="#top"></a></div>
<!-- /Back to Top -->

<?php $t->footer->wp_footer(); ?>

</body>
</html>
