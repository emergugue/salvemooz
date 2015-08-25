<?php
/**
 * About This Version administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

wp_enqueue_style( 'wp-mediaelement' );
wp_enqueue_script( 'wp-mediaelement' );
wp_localize_script( 'mediaelement', '_wpmejsSettings', array(
	'pluginPath' => includes_url( 'js/mediaelement/', 'relative' ),
	'pauseOtherPlayers' => ''
) );

$title = __( 'About' );

list( $display_version ) = explode( '-', $wp_version );

include( ABSPATH . 'wp-admin/admin-header.php' );
<<<<<<< HEAD

$video_url = 'https://videopress.com/embed/T54Iy7Tw';
$locale    = str_replace( '_', '-', get_locale() );
if ( 'en-AU' !== $locale ) {
	list( $locale ) = explode( '-', $locale );
}
if ( 'en' !== $locale ) {
	$video_url = add_query_arg( 'defaultLangCode', $locale, $video_url );
}

$major_features = array(
	array(
		'src'         => array(
			'mp4'  => '//s.w.org/images/core/4.3/formatting.mp4',
			'ogv'  => '//s.w.org/images/core/4.3/formatting.ogv',
			'webm' => '//s.w.org/images/core/4.3/formatting.webm',
		),
		'heading'     => __( 'Formatting Shortcuts' ),
		/* Translators: 1: asterisks; 2: number sign; */
		'description' => sprintf( __( 'Your writing flow just got faster with new formatting shortcuts in WordPress 4.3. Use asterisks to create lists and number signs to make a heading. No more breaking your flow; your text looks great with a %1$s and a %2$s.' ), '<code>*</code>', '<code>#</code>' ),
	),
	array(
		'src'         => '//s.w.org/images/core/4.3/menu-customizer.png',
		'heading'     => __( 'Menus in the Customizer' ),
		'description' => __( 'Create your menu, update it, and assign it, all while live-previewing in the customizer. The streamlined customizer design provides a mobile-friendly and accessible interface. With every release, it becomes easier and faster to make your site just the way you want it.' ),
	),
	array(
		'src'         => '//s.w.org/images/core/4.3/better-passwords.png',
		'heading'     => __( 'Better Passwords' ),
		'description' => __( 'Keep your site more secure with WordPress&#8217; improved approach to passwords. Instead of receiving passwords via email, you&#8217;ll get a password reset link. When you add new users to your site or edit a user profile, WordPress will automatically generate a secure password.' ),
	),
	array(
		'src'         => '//s.w.org/images/core/4.3/site-icon-customizer.png',
		'heading'     => __( 'Site Icons' ),
		'description' => __( 'Site icons represent your site in browser tabs, bookmark menus, and on the home screen of mobile devices. Add your unique site icon in the customizer; it will even stay in place when you switch themes. Make your whole site reflect your brand.' ),
	),
);
shuffle( $major_features );

$minor_features = array(
	array(
		'src'         => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0MDAgNDAwIj48cGF0aCBmaWxsPSIjMDBhMGQyIiBkPSJNNTAgMjE1aDI0MHYzMEg1MHpNNTAgMjc1aDI0MHYzMEg1MHpNNTAgMTU1aDI0MHYzMEg1MHpNNTAgOTVoMjQwdjMwSDUwek0zMTAuMSA5NWwxOS45IDMwIDIwLjEtMzAiLz48L3N2Zz4=',
		'heading'     => __( 'A smoother admin experience' ),
		'description' => __( 'Refinements to the list view across the admin make your WordPress more accessible and easier to work with on any device.' ),
	),
	array(
		'src'         => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMCAyMCI+PHBhdGggZmlsbD0iIzAwYTBkMiIgZD0iTTUgMmgxMHEuODIgMCAxLjQxLjU5VDE3IDR2OHEwIC44Mi0uNTkgMS40MVQxNSAxNGgtMmwtNSA1di01SDVxLS44MiAwLTEuNDEtLjU5VDMgMTJWNHEwLS44Mi41OS0xLjQxVDUgMnptOC41IDguNUwxMSA4bDIuNS0yLjUtMS0xTDEwIDcgNy41IDQuNWwtMSAxTDkgOGwtMi41IDIuNSAxIDFMMTAgOWwyLjUgMi41eiIvPjwvc3ZnPg==',
		'heading'     => __( 'Comments turned off on pages' ),
		'description' => __( 'All new pages that you create will have comments turned off. Keep discussions to your blog, right where they&#8217;re supposed to happen.' ),
	),
	array(
		'src'         => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iIzAwYTBkMiIgZD0iTTI5LjMyOCA1LjcxMnEuMDQ4LS4xNDQuMDk2LS4zODR0LS4wNjQtLjgxNi0uNTI4LS45NzZxLS4zODQtLjM2OC0uODcyLS40NjR0LS43OTIgMGwtLjI4OC4wOHEtMS40NTYuNzItNS44OCAzLjczNnQtNi4zOTIgNS4xNzZxLS43MzYuODMyLTEuNDA4IDIuMzJ0LS44OCAzIC41NDQgMi4zOTJxLjgzMi43MzYgMi4zNDQuNTc2dDMuMDcyLS44MjQgMi4yNDgtMS4zNTJxMi4xNDQtMi4xNDQgNS4xNjgtNi42NTZ0My42MzItNS44MDh6TTIuMjQgMjguMjRxMS4wNTYtLjY4OCAxLjcxMi0xLjUyOHQuOTUyLTEuNjE2LjU0NC0xLjUyLjcyLTEuNDggMS4yNC0xLjI4cTEuMDg4LS44IDIuNTA0LS43MDR0Mi40MjQgMS4xNjhxLjgxNi44OC44MjQgMi42NHQtMS4wOCAyLjg5NnEtMS4yMTYgMS4xMi0yLjkwNCAxLjYyNHQtMy40MjQuNDI0LTMuNTEyLS42MjR6Ii8+PC9zdmc+',
		'heading'     => __( 'Customize your site quickly' ),
		'description' => __( 'Wherever you are on the front-end, you can click the customize link in the toolbar to swiftly make changes to your site.' ),
	),
);

$tech_features = array(
	array(
		'heading'     => __( 'Taxonomy Roadmap' ),
		'description' => __( 'Terms shared across multiple taxonomies are now split into separate terms.' ),
	),
	array(
		'heading'     => __( 'Template Hierarchy' ),
		/* Translators: 1: singular.php; 2: single.php; 3:page.php */
		'description' => sprintf( __( 'Added %1$s as a fallback for %2$s and %3$s' ), '<code>singular.php</code>', '<code>single.php</code>', '<code>page.php</code>.' ),
	),
	array(
		'heading'     => '<code>WP_List_Table</code>',
		'description' => __( 'List tables can and should designate a primary column.' ),
	),
);

?>
	<div class="wrap about-wrap">
		<h1><?php printf( __( 'Welcome to WordPress&nbsp;%s' ), $display_version ); ?></h1>

		<div class="about-text"><?php printf( __( 'Thank you for updating! WordPress %s makes it even easier to format your content and customize your site.' ), $display_version ); ?></div>
		<div class="wp-badge"><?php printf( __( 'Version %s' ), $display_version ); ?></div>

		<h2 class="nav-tab-wrapper">
			<a href="about.php" class="nav-tab nav-tab-active"><?php _e( 'What&#8217;s New' ); ?></a>
			<a href="credits.php" class="nav-tab"><?php _e( 'Credits' ); ?></a>
			<a href="freedoms.php" class="nav-tab"><?php _e( 'Freedoms' ); ?></a>
		</h2>

		<div class="headline-feature feature-video">
			<iframe width="1050" height="591" src="<?php echo esc_url( $video_url ); ?>" frameborder="0" allowfullscreen></iframe>
			<script src="https://videopress.com/videopress-iframe.js"></script>
		</div>

		<hr/>

		<div class="feature-section two-col">
			<?php foreach ( $major_features as $feature ) : ?>
			<div class="col">
				<div class="media-container">
					<?php
					// Video.
					if ( is_array( $feature['src'] ) ) :
						echo wp_video_shortcode( array(
							'mp4'      => $feature['src']['mp4'],
							'ogv'      => $feature['src']['ogv'],
							'webm'     => $feature['src']['webm'],
							'loop'     => true,
							'autoplay' => true,
							'width'    => 500,
							'height'   => 284
						) );

					// Image.
					else:
					?>
					<img src="<?php echo esc_url( $feature['src'] ); ?>" />
					<?php endif; ?>
				</div>
				<h3><?php echo $feature['heading']; ?></h3>
				<p><?php echo $feature['description']; ?></p>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="feature-section three-col">
			<?php foreach ( $minor_features as $feature ) : ?>
			<div class="col">
				<div class="svg-container">
					<img src="<?php echo esc_attr( $feature['src'] ); ?>" />
				</div>
				<h3><?php echo $feature['heading']; ?></h3>
				<p><?php echo $feature['description']; ?></p>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="changelog">
			<h3><?php _e( 'Under the Hood' ); ?></h3>

			<div class="feature-section under-the-hood three-col">
				<?php foreach ( $tech_features as $feature ) : ?>
				<div class="col">
					<h4><?php echo $feature['heading']; ?></h4>
					<p><?php echo $feature['description']; ?></p>
				</div>
				<?php endforeach; ?>
			</div>

			<div class="return-to-dashboard">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? _e( 'Return to Updates' ) : _e( 'Return to Dashboard &rarr; Updates' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? _e( 'Go to Dashboard &rarr; Home' ) : _e( 'Go to Dashboard' ); ?></a>
			</div>

		</div>
	</div>
=======
?>
<div class="wrap about-wrap">

<h1><?php printf( __( 'Welcome to WordPress&nbsp;%s' ), $display_version ); ?></h1>

<div class="about-text"><?php printf( __( 'Thank you for updating! WordPress %s helps you communicate and share, globally.' ), $display_version ); ?></div>

<div class="wp-badge"><?php printf( __( 'Version %s' ), $display_version ); ?></div>

<h2 class="nav-tab-wrapper">
	<a href="about.php" class="nav-tab nav-tab-active">
		<?php _e( 'What&#8217;s New' ); ?>
	</a><a href="credits.php" class="nav-tab">
		<?php _e( 'Credits' ); ?>
	</a><a href="freedoms.php" class="nav-tab">
		<?php _e( 'Freedoms' ); ?>
	</a>
</h2>

<div class="changelog point-releases">
	<h3><?php echo _n( 'Maintenance and Security Release', 'Maintenance and Security Releases', 2 ); ?></h3>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.', 13 ), '4.2.2', number_format_i18n( 13 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'http://codex.wordpress.org/Version_4.2.2' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 1 ), '4.2.1' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'http://codex.wordpress.org/Version_4.2.1' ); ?>
 	</p>
</div>

<div class="headline-feature feature-video">
	<embed type="application/x-shockwave-flash" src="https://v0.wordpress.com/player.swf?v=1.04" width="1000" height="560" wmode="direct" seamlesstabbing="true" allowfullscreen="true" allowscriptaccess="always" overstretch="true" flashvars="guid=e9kH4FzP&amp;isDynamicSeeking=true"></embed>
</div>

<hr />

<div class="feature-section two-col">
	<div class="col">
		<h3><?php _e( 'An easier way to share content' ); ?></h3>
		<p><?php printf( __( 'Clip it, edit it, publish it. Get familiar with the new and improved Press This. From the <a href="%s">Tools</a> menu, add Press This to your browser bookmark bar or your mobile device home screen. Once installed you can share your content with lightning speed. Sharing your favorite videos, images, and content has never been this fast or this easy.' ), admin_url( 'tools.php' ) ); ?></p>
		<p><?php _e( 'Drag the bookmarklet below to your bookmarks bar. Then, when you&#8217;re on a page you want to share, simply &#8220;press&#8221; it.' ); ?></p>

		<p class="pressthis-bookmarklet-demo">
			<a class="pressthis-bookmarklet" onclick="return false;" href="<?php echo htmlspecialchars( get_shortcut_link() ); ?>"><span><?php _e( 'Press This' ); ?></span></a>
		</p>
	</div>

	<div class="col">
		<img src="//s.w.org/images/core/4.2/press-this.jpg" />
	</div>
</div>

<div class="feature-section two-col">
	<div class="col">
		<img src="//s.w.org/images/core/4.2/unicode.png" />
	</div>
	<div class="col">
		<h3><?php _e( 'Extended character support' ); ?></h3>
		<p><?php _e( 'Writing in WordPress, whatever your language, just got better. WordPress 4.2 supports a host of new characters out-of-the-box, including native Chinese, Japanese, and Korean characters, musical and mathematical symbols, and hieroglyphs.' ); ?></p>
		<p><?php
			/* translators: 1: heart emoji, 2: frog face emoji, 3, monkey emoji, 4: pizza emoji, 5: Emoji Codex link */
			printf( __( 'Don&#8217;t use any of those characters? You can still have fun &mdash; emoji are now available in WordPress! Get creative and decorate your content with %1$s, %2$s, %3$s, %4$s, and all the many other <a href="%5$s">emoji</a>.' ), '&#x1F499', '&#x1F438', '&#x1F412', '&#x1F355', __( 'https://codex.wordpress.org/Emoji' ) );
		?></p>
	</div>
</div>

<div class="changelog feature-section three-col">
	<div>
		<img src="//s.w.org/images/core/4.2/theme-switcher.png" />
		<h3><?php _e( 'Switch themes in the Customizer' ); ?></h3>
		<p><?php _e( 'Browse and preview your installed themes from the Customizer. Make sure the theme looks great with <em>your</em> content, before it debuts on your site. ' ); ?></p>
	</div>
	<div>
		<img src="//s.w.org/images/core/4.2/embeds.png" />
		<h3><?php _e( 'Even more embeds' ); ?></h3>
		<p><?php _e( 'Paste links from Tumblr.com and Kickstarter and watch them magically appear right in the editor. With every release, your publishing and editing experience get closer together.' ); ?></p>
	</div>
	<div class="last-feature">
		<img src="//s.w.org/images/core/4.2/plugins.png" />
		<h3><?php _e( 'Streamlined plugin updates' ); ?></h3>
		<p><?php _e( 'Goodbye boring loading screen, hello smooth and simple plugin updates. Click <em>Update&nbsp;Now</em> and watch the magic happen.' ); ?></p>
	</div>
</div>

<div class="changelog under-the-hood feature-list">
	<h3><?php _e( 'Under the Hood' ); ?></h3>

	<div class="feature-section col two-col">
		<div>
			<h4><?php _e( 'utf8mb4 support' ); ?></h4>
			<p><?php _e( 'Database character encoding has changed from utf8 to utf8mb4, which adds support for a whole range of new 4-byte characters.' ); ?></p>

			<h4><?php _e( 'JavaScript accessibility' ); ?></h4>
			<p><?php
				/* translators: %s wp.a11y.speak() */
				printf( __( 'You can now send audible notifications to screen readers in JavaScript with %s. Pass it a string, and an update will be sent to a dedicated ARIA live notifications area.' ), '<code>wp.a11y.speak()</code>' );
			?></p>
		</div>
		<div class="last-feature">
			<h4><?php _e( 'Shared term splitting' ); ?></h4>
			<p><?php
				/* translators: 1: Term splitting guide link */
				printf( __( 'Terms shared across multiple taxonomies will be split when one of them is updated. Find out more in the <a href="%1$s">Plugin Developer Handbook</a>.' ), 'https://developer.wordpress.org/plugins/taxonomy/working-with-split-terms-in-wp-4-2/' );
			?></p>

			<h4><?php _e( 'Complex query ordering' ); ?></h4>
			<p><?php
				/* translators: 1: WP_Query, 2: WP_Comment_Query, 3: WP_User_Query */
				printf( __( '%1$s, %2$s, and %3$s now support complex ordering with named meta query clauses.' ), '<code>WP_Query</code>', '<code>WP_Comment_Query</code>', '<code>WP_User_Query</code>' );
			?></p>
		</div>

	<hr />

	<div class="return-to-dashboard">
		<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
		<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>"><?php
			is_multisite() ? _e( 'Return to Updates' ) : _e( 'Return to Dashboard &rarr; Updates' );
		?></a> |
		<?php endif; ?>
		<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php
			is_blog_admin() ? _e( 'Go to Dashboard &rarr; Home' ) : _e( 'Go to Dashboard' ); ?></a>
	</div>
</div>

</div>
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
<?php

include( ABSPATH . 'wp-admin/admin-footer.php' );

// These are strings we may use to describe maintenance/security releases, where we aim for no new strings.
return;

_n_noop( 'Maintenance Release', 'Maintenance Releases' );
_n_noop( 'Security Release', 'Security Releases' );
_n_noop( 'Maintenance and Security Release', 'Maintenance and Security Releases' );

/* translators: 1: WordPress version number. */
_n_noop( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.' );

/* translators: 1: WordPress version number, 2: plural number of bugs. */
_n_noop( '<strong>Version %1$s</strong> addressed %2$s bug.',
         '<strong>Version %1$s</strong> addressed %2$s bugs.' );

/* translators: 1: WordPress version number, 2: plural number of bugs. Singular security issue. */
_n_noop( '<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bugs.' );

/* translators: 1: WordPress version number, 2: plural number of bugs. More than one security issue. */
_n_noop( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.' );

__( 'For more information, see <a href="%s">the release notes</a>.' );
