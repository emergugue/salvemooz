<?php
class Foster_Me_Recently_Added_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'pfo_ra', // Base ID
			'Foster Me: Recently Added', // Name
			array( 'description' => __( 'A list of your most recent fosters' ), ) // Args
		);
	}
    ///START WIDGET
    function widget($args, $foster_instance) {		
		?>
<!-- =============================================================
	DISPLAY THE WIDGET
* ============================================================= -->
          <!--start container-->
        <aside id="foster_me_recently_added_widget" class="widget">
				<!--FOSTER PAGE LINK-->    
                <?php if( $foster_instance['pfo_widget_recentTitle'] != "" ){
                  echo '<h3>' . $foster_instance['pfo_widget_recentTitle'] . '</h3>';?>	
               <?php }?>
               <!--LIST OF PETS-->
               
               <?php
			   $recentfoster_args = array('numberposts' => $foster_instance['pfo_widget_numOfRecent'],'post_type' => 'fosters');
			   $recentfoster_thumbnails = get_posts( $recentfoster_args );
				foreach ($recentfoster_thumbnails as $recentfoster_thumbnail) {
					//if ( has_post_thumbnail($recentfoster_thumbnail->ID)) {//uncomment to only show pets with thumbnails
						echo '<a class="pfo_widget_recentlink" href="' . get_permalink( $recentfoster_thumbnail->ID ) . '" title="' . esc_attr( $recentfoster_thumbnail->post_title ) . '">';
						echo '<div class="pfo_widget_recentthumbnail">'.get_the_post_thumbnail($recentfoster_thumbnail->ID, 'thumbnail').'</div>';
						echo '<div class="pfo_widget_recent_petinfo">';
						echo '<div class="pfo_widget_recentname">'.get_the_title($recentfoster_thumbnail->ID).'</div>';
						//date
						if( $foster_instance['pfo_widget_recent_showdate'] == "on" ){
                  			echo '<p class="pfo-widget-recent-showdate"><strong>Added: </strong>';
							echo get_the_time( get_option( 'date_format' ), $recentfoster_thumbnail->ID );
							echo '</p>';
              			 }
						 echo '</div>';
						 echo '</a>';
					//}
					
				}
				?> 
       </aside>
   <?php
        echo $after_widget;
    }	
/*=============================================================
	END THE WIDGET
* ============================================================= */

    //UPDATE VARS FROM FORM
    function update( $new_instance, $old_instance ) {

	 $foster_instance = $old_instance;
		$foster_instance['pfo_widget_numOfRecent']      = strip_tags( $new_instance['pfo_widget_numOfRecent'] );
		$foster_instance['pfo_widget_recentTitle']      = strip_tags( $new_instance['pfo_widget_recentTitle'] );
		$foster_instance['pfo_widget_recent_showdate']      = strip_tags( $new_instance['pfo_widget_recent_showdate'] );
		return $foster_instance;
    }
    function form( $foster_instance ) {
        // Default vars in form
		$foster_instance = wp_parse_args( (array) $foster_instance, array(
			'pfo_widget_numOfRecent' => 5,
			'pfo_widget_recentTitle' => 'Recently Added Fosters',
			'pfo_widget_recent_showdate' => ''
		));

     $pfo_widget_numOfRecent = esc_attr($foster_instance['pfo_widget_numOfRecent']);
		$pfo_widget_recentTitle = esc_attr($foster_instance['pfo_widget_recentTitle']);
		$pfo_widget_recent_showdate = esc_attr($foster_instance['pfo_widget_recent_showdate']);
		?>
         <p>
          <label for="<?php echo $this->get_field_id('pfo_widget_recentTitle'); ?>"><?php _e('Title:'); ?></label><br/>
          <input id="<?php echo $this->get_field_id('pfo_widget_recentTitle'); ?>" name="<?php echo $this->get_field_name('pfo_widget_recentTitle'); ?>" type="text" value="<?php echo $pfo_widget_recentTitle; ?>" />
        </p>
             <p>
          <label for="<?php echo $this->get_field_id('pfo_widget_numOfRecent'); ?>"><?php _e('Number of fosters to show:'); ?></label>
          <input size="3" id="<?php echo $this->get_field_id('pfo_widget_numOfRecent'); ?>" name="<?php echo $this->get_field_name('pfo_widget_numOfRecent'); ?>" type="text" value="<?php echo $pfo_widget_numOfRecent; ?>" />
        </p>
        <p>
        <input type="checkbox" for="<?php echo $this->get_field_id('pfo_widget_recent_showdate'); ?>" 
        name="<?php echo $this->get_field_name('pfo_widget_recent_showdate');?>" 	
        id="<?php echo $this->get_field_id('pfo_widget_recent_showdate'); ?>"
    	<?php if ($pfo_widget_recent_showdate == "on") {
        echo "checked";
    	} ?> /> Show dates added?
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Foster_Me_Recently_Added_Widget");'));