<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the main and #page div elements.
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	</main><!-- main -->

	<footer id="footer" role="contentinfo" class="footer-sz">
		<div id="footer-content" class="container">
			<div class="row">
				<div class="copyright col-sm-6">
					<p>Corporación Salvemooz - <a href="mailto:salvemooz@gmail.com" title="Correo electrónico Salvemooz">salvemooz@gmail.com</a></p>
					<!-- <span class="pull-left"><?php printf( __( 'Copyright &copy; %s %s. All Rights Reserved.', 'arcade' ), date( 'Y' ), ' <a href="' . home_url() . '">' . get_bloginfo( 'name' ) .'</a>' ); ?></span>
					<span class="credit-link pull-right"><i class="fa fa-leaf"></i><?php printf( __( 'The %s Theme by %s.', 'arcade' ), BAVOTASAN_THEME_NAME, '<a href="http://themes.bavotasan.com/themes/arcade">bavotasan.com</a>' ); ?></span> -->
				</div><!-- .col-lg-12 -->
				<div class="col-sm-6 redes-sociales">
					<p>También nos puedes encontrar en: </p>
					<ul>
						<li><a href="https://www.facebook.com/salvemooz" class="fb" title="Página oficial de Salvemooz en Facebook" target="_blank"></a> </li>
						<li><a href="https://www.twitter.com/salvemooz" class="tw" title="Perfil oficial de Salvemooz en Twitter" target="_blank"></a> </li>
					</ul>
				</div>
			</div><!-- .row -->
		</div><!-- #footer-content.container -->
	</footer><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>