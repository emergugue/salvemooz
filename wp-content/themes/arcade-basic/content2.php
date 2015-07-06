<?php
/**
 * The default template for displaying content
 *
 * Used for both single and front-page/index/archive/search.
 *
 * @since 1.0.0
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
		<?php
		// Display a thumbnail if one exists and not on single post
		bavotasan_display_post_thumbnail();

	    get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content description clearfix">
	    	<div class="ctn_informacion row">
		    	<div class="ctn_thumbnail col-sm-6">
		    		<figure>
			            <?php the_post_thumbnail( "large", array( 'class' => 'img-responsive' ) ); ?>
			        </figure>
		    	</div>
		    	<div class="ctn_informacion_item col-sm-6">
		    		<ul>
						<li class="informacion-item edad"><strong>Edad:</strong> <?php the_field('edad'); ?></li>
						<li class="informacion-item tamano"><strong>Tamaño:</strong> <?php the_field('tamano'); ?></li>
						<li class="informacion-item raza"><strong>Raza:</strong> <?php the_field('raza'); ?></li>
						<li class="informacion-item esterilizado"><strong>Esterilizado:</strong> <?php the_field('esterilizado'); ?></li>
						<li class="informacion-item vacunado"><strong>Vacunado:</strong> <?php the_field('vacunado'); ?></li>
						<li class="informacion-item sexo"><strong>Sexo:</strong> <?php the_field('sexo'); ?></li>
					</ul>
		    	</div>
			</div>
		    <?php
			if ( is_singular() && ! is_front_page() )
			    the_content( __( 'Read more', 'arcade') );
			else
				the_excerpt();
			?>
		<div><a href="<?php bloginfo( "url" ); ?>/adopciones/proceso-de-adopcion" class="btn-adoptar">Quiero adoptarlo</a></div>
	    </div><!-- .entry-content -->
	    <?php if ( is_singular() && ! is_front_page() )
	    	get_template_part( 'content', 'footer' ); ?>
	</article><!-- #post-<?php the_ID(); ?> -->