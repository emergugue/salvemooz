<?php
class Foster_Me_Image_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'pfo_iw', // Base ID
			'Foster Me: Image Widget', // Name
			array( 'description' => __( 'Advertise your foster page' ), ) // Args
		);
	}
    ///START WIDGET
    function widget($args, $foster_instance) {		
/* =============================================================
	DISPLAY THE WIDGET
* =============================================================*/?>
        <!--load custom style for btn-->          
          <style>.pfo__fosterbtn_widget span{background-color:<?php  echo $foster_instance["pfo_widget_buttoncolor"];?>	}</style>
          <!--start container-->
        <aside id="foster_me_image_widget" class="widget">
         <?php
			$foster_args = array('orderby' => 'rand', 'post_type' => 'fosters');
			$foster_thumbnails = get_posts( $foster_args );
			foreach ($foster_thumbnails as $foster_thumbnail) {
			if ( has_post_thumbnail($foster_thumbnail->ID)) {//if has thumbnail, show the one and exit?>
				<!--FOSTER PAGE LINK--> 
                <?php if( $foster_instance['pfo_image_widget_link'] != "link_none" ){ ?>
                	<?php if( $foster_instance['pfo_image_widget_link'] == "link_pet_page" ){
						echo '<a href="' . get_permalink( $foster_thumbnail->ID ) . '" title="' . esc_attr( $foster_thumbnail->post_title ) . '">';
					  }
					else if( $foster_instance['pfo_image_widget_link'] == "link_fosters_page" ){
						echo '<a href="' .  get_post_type_archive_link( 'fosters' ) . '">';
					}?>				
                	<!--WIDGET BTN-->
              		<div class='pfo__fosterbtn_widget'>
                	<?php if($foster_instance["pfo_widget_buttontext"]!=''){?>
                		<span><?php  echo $foster_instance["pfo_widget_buttontext"];?></span>
                    <?php } 
					else{?>
                   		<span>Foster Me!</span>
					<?php }?>
                	</div>
               <?php }
               //RANDOM PET IMG & TITLE
			   		if ($foster_instance["pfo_image_widget_link_showname"] == "on") {
						echo '<div class="pfo__fostername_widget">'.get_the_title($foster_thumbnail->ID).'</div>';
			   		}
						echo '<div class="pfo__random-img_widget">'.get_the_post_thumbnail($foster_thumbnail->ID, 'medium').'</div>';
						break 1;
					}
				}
				?>
    
                        <?php 
			//end link
			if( $foster_instance['pfo_image_widget_link'] != "link_none" ){
				echo "</a>";
			}
		?>  <!--end link -->
       </aside>
   <?php
        echo $after_widget;
    }	
/*=============================================================
	END THE WIDGET
* ============================================================= */

    //UPDATE VARS FROM FORM
    function update( $new_foster_instance, $old_foster_instance ) {

	 $foster_instance = $old_foster_instance;
		$foster_instance['pfo_widget_buttontext']      = strip_tags( $new_foster_instance['pfo_widget_buttontext'] );
		$foster_instance['pfo_widget_buttoncolor']      = strip_tags( $new_foster_instance['pfo_widget_buttoncolor'] );
		$foster_instance['pfo_image_widget_link']      = strip_tags( $new_foster_instance['pfo_image_widget_link'] );	
		$foster_instance['pfo_image_widget_link_showname']      = strip_tags( $new_foster_instance['pfo_image_widget_link_showname'] );		
		return $foster_instance;
    }
    function form( $foster_instance ) {
        // Default vars in form
		$foster_instance = wp_parse_args( (array) $foster_instance, array(
			'pfo_widget_buttontext' => 'Foster Me!',
			'pfo_widget_buttoncolor' => '',
			'pfo_image_widget_link' => 'link_none',
			'pfo_image_widget_link_showname' => ''
		));

     $pfo_widget_buttontext = esc_attr($foster_instance['pfo_widget_buttontext']);
		$pfo_widget_buttoncolor = esc_attr($foster_instance['pfo_widget_buttoncolor']);
        $pfo_image_widget_link = esc_attr($foster_instance['pfo_image_widget_link']);
		$pfo_image_widget_link_showname = esc_attr($foster_instance['pfo_image_widget_link_showname']);
		?>
         <p>
        <input type="checkbox" for="<?php echo $this->get_field_id('pfo_image_widget_link_showname'); ?>" 
        name="<?php echo $this->get_field_name('pfo_image_widget_link_showname');?>" 	
        id="<?php echo $this->get_field_id('pfo_image_widget_link_showname'); ?>"
    	<?php if ($pfo_image_widget_link_showname == "on") {
        echo "checked";
    	} ?> /> Show pet names?
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('pfo_widget_buttoncolor'); ?>"><?php _e('Button Color:'); ?></label><br/>
          <input class="my-color-field" id="<?php echo $this->get_field_id('pfo_widget_buttoncolor'); ?>" name="<?php echo $this->get_field_name('pfo_widget_buttoncolor'); ?>" type="text" value="<?php if (empty($pfo_widget_buttoncolor)){echo '#9acd32';/*yellowgreen*/}else{ echo $pfo_widget_buttoncolor;} ?>" />
        </p>
             <p>
          <label for="<?php echo $this->get_field_id('pfo_widget_buttontext'); ?>"><?php _e('Button Text:'); ?></label>
          <input id="<?php echo $this->get_field_id('pfo_widget_buttontext'); ?>" name="<?php echo $this->get_field_name('pfo_widget_buttontext'); ?>" type="text" value="<?php echo $pfo_widget_buttontext; ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('pfo_image_widget_link'); ?>"><?php _e('Link:'); ?></label>
        <select for="<?php echo $this->get_field_id('pfo_image_widget_link'); ?>" name="<?php echo $this->get_field_name('pfo_image_widget_link'); ?>">
        <option value="link_none" <?php
        if ($pfo_image_widget_link == "link_none") {
            echo "selected";
        }
        ?>>None</option>
        <option value="link_pet_page" <?php
        if ($pfo_image_widget_link == "link_pet_page") {
            echo "selected";
        }
        ?>>Link to pet's page</option>
        <option value="link_fosters_page" <?php
        if ($pfo_image_widget_link == "link_fosters_page") {
            echo "selected";
        }
        ?>>Link to all fosters page</option>
        </select>
        </p>
         
<script>jQuery(document).ready(function($){
    $('#widgets-right .my-color-field').wpColorPicker();
	    
});   
</script>        
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Foster_Me_Image_Widget");'));