</div><!-- #main -->
<footer id="footer">

	<div id="chibi-footer">
		<a id="mascot-running-left"></a>
		<a id="mascot-running-middle"></a>
		<a id="mascot-running-right"></a>
	</div>

	<?php noel_credit(); ?>

</footer><!-- #footer -->

</section><!-- #wrapper -->

<div class="noel-toolbar">
	<?php 
		noel_facebook();
    	noel_twitter();
    	noel_googleplus();
    	noel_rss();
    ?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'mime-dal' ); ?>" />
	</form>
</div>
<?php wp_footer(); ?>

</BODY>
</HTML>