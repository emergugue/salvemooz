<?php
/* ======================================================================

	Plugin Name: Foster Me: Seek & Shelter an Animal in Need
	Plugin URI: http://www.lendingapaw.org/plugins/foster-me-seek-shelter-an-animal-in-need/
	Description: Foster Me offers a filterable and searchable list of all animals that need a foster home at your shelter.
	Version: 1.02
	Author: Stephanie Chow
	Author URI: http://www.lendingapaw.org
	License: GPLv2 or later
*/
/*
Copyright 2014 Stephanie Chow (email : stephanie@lendingapaw.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Foster Me uses the Shuffle.js plugin v2.1.1 http://vestride.github.io/Shuffle/ By @Vestride.
*/
	
/* ====================================================================== */
 /* =============================================================
	FLUSH ON DEACTIVATION/ACTIVATION
 * ============================================================= */ 
 /** On activation, set flush option to true so you can execute once**/
function fosterme_activation() {
    add_option('fosterme_flush', 'true');
} 
register_activation_hook( __FILE__, 'fosterme_activation' );
/**On deactivation, we'll remove the option if it is still around. (It shouldn't be after we register our post type.)**/
function fosterme_deactivation() {
    delete_option('fosterme_flush');
} 
register_deactivation_hook( __FILE__, 'fosterme_deactivation' );
 /* =============================================================
	INCLUDE WP BUILT IN SCRIPTS
 * ============================================================= */ 
//color picker
add_action( 'admin_enqueue_scripts', 'fosterme_enqueue_color_picker' );
function fosterme_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('/js/my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
//jQuery
wp_enqueue_script('jquery');
//single & archive styles
wp_enqueue_style('fosterme_fitler_styles', plugins_url('css/pfo_filter_styles.css', __FILE__ ) );
wp_enqueue_style('fosterme_rows_styles', plugins_url('css/pfo_rows_styles.css', __FILE__ ) );
//widget style
wp_enqueue_style('fosterme_widget_styles', plugins_url('widget/pfo-widget-style.css', __FILE__ ) );
/* =============================================================
	DEFAULT VARS
	Used in option pages.
 * ============================================================= */
ini_set("allow_url_fopen", true);
ini_set("allow_url_include", true);
/* =============================================================
	INCLUDE WIDGETS
 * ============================================================= */
include( dirname(__FILE__) . '/widget/foster-me-image-widget.php' );
include( dirname(__FILE__) . '/widget/foster-me-recently-added-widget.php' );
/* =============================================================
	SETUP PLUGIN SETTINGS PAGE
 * ============================================================= */
add_option("foster-me", $pet_foster_options);
$pet_foster_options = get_option('foster-me');
add_action('admin_menu', 'pet_foster_admin_page');
/* =============================================================
	ADD FOSTER MENU TO ADMIN
* ============================================================= */ 
add_action( 'init', 'create_foster_post_types' );
function create_foster_post_types() {
	global $pet_foster_options; 
	if (trim($_POST['fosterme_url_slug'])!=''){
	$fosterme_url_slug_new = trim($_POST['fosterme_url_slug']);
	}
	else if ($pet_foster_options['fosterme_url_slug']!=''){
		$fosterme_url_slug_new = $pet_foster_options['fosterme_url_slug'];
	}
	else{
		$fosterme_url_slug_new = 'fosters';
	}
		register_post_type( 'fosters',
		array(
			'labels' => array(
				'name' => __( 'Fosters' ),
				'singular_name' => __( 'Foster' )
			),
		'public' => true,
		'exclude_from_search' => true,
		'has_archive' => true,
		'rewrite' => array('slug'=> $fosterme_url_slug_new),				 
		'supports' => array('title', 'editor', 'thumbnail')//for featured image
		)
	);
	/**remove flush option after its been used once**/
	if (get_option('fosterme_flush') == 'true') {
        flush_rewrite_rules(false);
        delete_option('fosterme_flush');
    }
}
/* =============================================================
	DEFAULT VARS
	Used in option pages.
 * ============================================================= */

$pet_foster_options = array(
  'pfo_optionssection_remove' => '',
  'pfo_hideoptionssection_default' => ''  
);
/* =============================================================
	ADD SETTINGS PAGE TO ADMIN MENU
 * ============================================================= */
function pet_foster_admin_page() {
add_submenu_page('edit.php?post_type=fosters', 'Foster Me Settings', 'Settings', 'manage_options', basename(__FILE__), 'pet_foster_options_page');
}
/* =============================================================
	WRITE SETTINGS PAGE
 * ============================================================= */
function pet_foster_options_page() {
   global $pet_foster_options;

if(isset($_POST['reset'])) {
//IF CHOSE RESET COLORS - USE DEFAULT VALUES
 $pet_foster_options['pfo_header_bg']  = '#426789';/*bluegrey*/
 $pet_foster_options['pfo_show_hide']  = '#426789';/*bluegrey*/
		$pet_foster_options['pfo_header_links']  = '#fff';
		$pet_foster_options['pfo_options_bg']  = '#fff';
		$pet_foster_options['pfo_optionssection_bg']  = '#fff';
		$pet_foster_options['pfo_options_title_color']  = '#555';
		$pet_foster_options['pfo_options_text_color']  = '#999';
		$pet_foster_options['pfo_options_selected_text']  = '#fff';
		$pet_foster_options['pfo_options_selected']  = '#9acd32';/*yellowgreen*/
		$pet_foster_options['pfo_petgrid_bg']  = '#fff';
		$pet_foster_options['pfo_pettitle_grid']  = '#426789';/*bluegrey*/
		$pet_foster_options['pfo_petdesc_grid']  = '#f8f8f8';
		$pet_foster_options['pfo_pettags_grid_color']  = '#333';
		$pet_foster_options['pfo_pageuparrow_grid_color'] = '#999';
		$pet_foster_options['pfo_pettitle_popup'] = '#426789';/*bluegrey*/
		$pet_foster_options['pfo_textontags_popup'] = '#555';
		$pet_foster_options['pfo_tags_popup'] = '#eee';
		$pet_foster_options['pfo_fosterbtnbg_popup'] = '#9acd32';/*yellowgreen*/
		$pet_foster_options['pfo_fosterbtntext_popup'] = '#fff';
  update_option('foster-me', $pet_foster_options);
  
echo "<div class=\"updated\">Colors have been reset to original default values</div>";
}

//IF CHOSE SAVE CHANGES, STORE NEW VALUES
    if(isset($_POST['save_changes'])) {
        check_admin_referer('foster-me-update_settings');	
		$pet_foster_options['fosterme_page_title']  = $_POST['fosterme_page_title'];	
		$pet_foster_options['fosterme_url_slug']  = trim($_POST['fosterme_url_slug']);
        $pet_foster_options['pfo_header_bg']  = trim($_POST['pfo_header_bg']);
		$pet_foster_options['pfo_show_hide']  = trim($_POST['pfo_show_hide']);
		$pet_foster_options['pfo_header_links']  = trim($_POST['pfo_header_links']);
		$pet_foster_options['pfo_options_bg']  = trim($_POST['pfo_options_bg']);
		$pet_foster_options['pfo_optionssection_bg']  = trim($_POST['pfo_optionssection_bg']);
		$pet_foster_options['pfo_options_title_color']  = trim($_POST['pfo_options_title_color']);
		$pet_foster_options['pfo_options_text_color']  = trim($_POST['pfo_options_text_color']);
		$pet_foster_options['pfo_options_selected_text']  = trim($_POST['pfo_options_selected_text']);
		$pet_foster_options['pfo_options_selected']  = trim($_POST['pfo_options_selected']);
		$pet_foster_options['pfo_petgrid_bg']  = trim($_POST['pfo_petgrid_bg']);
		$pet_foster_options['pfo_pettitle_grid']  = trim($_POST['pfo_pettitle_grid']);
		$pet_foster_options['pfo_petdesc_grid']  = trim($_POST['pfo_petdesc_grid']);
		$pet_foster_options['pfo_pettags_grid_color']  = trim($_POST['pfo_pettags_grid_color']);
		$pet_foster_options['pfo_pageuparrow_grid_color'] = trim($_POST['pfo_pageuparrow_grid_color']);
		$pet_foster_options['pfo_pettitle_popup'] = trim($_POST['pfo_pettitle_popup']);
		$pet_foster_options['pfo_textontags_popup'] = trim($_POST['pfo_textontags_popup']);
		$pet_foster_options['pfo_tags_popup'] = trim($_POST['pfo_tags_popup']);
			$pet_foster_options['pfo_fosterbtnbg_popup'] = trim($_POST['pfo_fosterbtnbg_popup']);
		$pet_foster_options['pfo_fosterbtntext_popup'] = trim($_POST['pfo_fosterbtntext_popup']);
		$pet_foster_options['pfo_pageuparrow_show'] = trim($_POST['pfo_pageuparrow_show']);
		$pet_foster_options['pfo_outlineicons_show'] = trim($_POST['pfo_outlineicons_show']);
		$pet_foster_options['pfo_fosterformpage_link'] = trim($_POST['pfo_fosterformpage_link']);
		$pet_foster_options['pfo_contactformpage_link'] = trim($_POST['pfo_contactformpage_link']);
		$pet_foster_options['pfo_display_mustbeOps'] = trim($_POST['pfo_display_mustbeOps']);
		$pet_foster_options['pfo_display_specialOps'] = trim($_POST['pfo_display_specialOps']);
		$pet_foster_options['pfo_optionssection_remove']= trim($_POST['pfo_optionssection_remove']);
		$pet_foster_options['pfo_hideoptionssection_default']= trim($_POST['pfo_hideoptionssection_default']);
		
		
		$pet_foster_options['pfo_shelter_info'] = stripslashes($_POST['pfo_shelter_info']);
		$pet_foster_options['pfo_shelter_info'] = wpautop($pet_foster_options['pfo_shelter_info']);
		
        update_option('foster-me', $pet_foster_options);	
		flush_rewrite_rules();
		
        echo "<div class=\"updated\">Your changes have been saved successfully!</div>";
    }
    ?>

  <!--LOAD SPANS/ROWS STYLES FOR SETTINGS PAGE-->   
     <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('css/pfo_rows_styles.css', __FILE__ );?>">
     
<!-- =============================================================
	FORM FOR SETTINGS PAGE
  ============================================================= -->
<div class="wrap" id="pfo__options-settings-form">
<h2 id="pfo__options-main-title">Foster Me Settings</h2>

<form name="pfo__the_form" action="<?php echo 'edit.php?post_type=fosters&page='.basename(__FILE__);?>" method="post">

    <?php
	
    if ( function_exists( 'wp_nonce_field' ) )
	    wp_nonce_field( 'foster-me-update_settings' );  ?>

	<div class="pfo__options-settings-instructions">
     	<div class="pfo__row-fluid">
        	<!--slug-->
            	
                <div class=" pfo__span4">
                <label>Fosters URL slug:</label>
        			<input style="margin:8px 0 0 8px;" type="text" name="fosterme_url_slug" value="<?php if($pet_foster_options['fosterme_url_slug']==''){echo'fosters';$pet_foster_options['fosterme_url_slug']='fosters';}else {echo $pet_foster_options['fosterme_url_slug'];} ?>" />
                 </div>
                 <!--page title-->
                <div class=" pfo__span4">
                <label>Page title:</label>
        			<input style="margin:8px 0 0 8px;" type="text" name="fosterme_page_title" value="<?php if($pet_foster_options['fosterme_page_title']==''){echo'Foster a Pet';$pet_foster_options['fosterme_page_title']='Foster a Pet';}else {echo stripslashes($pet_foster_options['fosterme_page_title']);} ?>" />
                 </div>
               </div><!--end row-->
                <div class="pfo__row-fluid">
                  <div class=" pfo__span12">
                  <p>The slug is used for building the fosters URL. Your current location to view your fosters is:
				  <?php echo '<a style="color:white;text-decoration:none;" href="'.get_post_type_archive_link( 'fosters' ).'">'.get_post_type_archive_link( 'fosters' ).'</a>';?>
                  </p>
                  <p>*Note you must have pretty permalinks set up to change the slug</p>
                  </div>
                 
         	</div>
		</div>
        
       <div class="pfo_style-options-section">
         <div class="pfo__row-fluid">
        <div class="pfo__span12"><h2>Header</h2></div>
        </div><!--end row-->
        
        <div class="pfo__row-fluid">
        
        	<div class="pfo__span4">
            <div class="pfo_options_title">Header <br/><em>Background Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_header_bg" value="
			<?php if (empty($pet_foster_options['pfo_header_bg'])){echo '#426789';/*bluegrey*/ }
			else {echo $pet_foster_options['pfo_header_bg'];} ?>" />
        	</div>
            
            <div class="pfo__span4">
            <div class="pfo_options_title">Show/Hide <br/><em>Text Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_show_hide" value="
            <?php if (empty($pet_foster_options['pfo_show_hide'])){echo '#426789';/*bluegrey*/ }
			else {echo $pet_foster_options['pfo_show_hide'];} ?>" />
        	</div>
            
            <div class="pfo__span4">
            <div class="pfo_options_title">Foster Form/Info <br/><em>Text & Icon Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_header_links" value="
			<?php if (empty($pet_foster_options['pfo_header_links'])){echo '#FFF'; }
			else {echo $pet_foster_options['pfo_header_links'];} ?>" />
        	</div>
            
          </div><!--end row-->
          </div><!--end options sections-->
          
           <div class="pfo_style-options-section">
          
           <div class="pfo__row-fluid">           
        		<div class="pfo__span12"><h2>Pet Options Section</h2></div>
             </div><!--end row-->
                   
                   <div class="pfo__row-fluid">
                   
                   <div class="pfo__span4">
            			<div class="pfo_options_title">Options <br/><em>Background Color</em></div>
        				<input type="text" class="my-color-field" name="pfo_options_bg" value="
                        <?php if (empty($pet_foster_options['pfo_options_bg'])){echo '#FFF'; }
						else {echo $pet_foster_options['pfo_options_bg'];} ?>" />
        			</div>
            
            	<div class="pfo__span4">
            		<div class="pfo_options_title">Option Section <br/><em>Background Color</em></div>
        			<input type="text" class="my-color-field" name="pfo_optionssection_bg" value="
                    <?php if (empty($pet_foster_options['pfo_optionssection_bg'])){echo '#FFF'; }
					else { echo $pet_foster_options['pfo_optionssection_bg'];} ?>" />
        		</div>
                
                   <div class="pfo__span4">
            	<div class="pfo_options_title">Options Titles <br/><em>Text Color</em></div>
        		<input type="text" class="my-color-field" name="pfo_options_title_color" value="
                <?php if (empty($pet_foster_options['pfo_options_title_color'])){echo '#555';}
				else {echo $pet_foster_options['pfo_options_title_color'];} ?>" />
        		</div>
            
            </div><!--end row-->
            
            <div class="pfo__row-fluid"> 
             <div class="pfo__span4">
            	<div class="pfo_options_title">All Options <br/><em>Text Color<br/></em></div>
        		<input type="text" class="my-color-field" name="pfo_options_text_color" value="
                <?php if (empty($pet_foster_options['pfo_options_text_color'])){echo '#999';}
				else  { echo $pet_foster_options['pfo_options_text_color'];} ?>" />
        		</div>
            
            
             <div class="pfo__span4">
            <div class="pfo_options_title">Option Selected Button <br/><em>Text Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_options_selected_text" value="
            <?php if (empty($pet_foster_options['pfo_options_selected_text'])){echo '#fff';}
			else {echo $pet_foster_options['pfo_options_selected_text'];} ?>" />
            </div>
            
            <div class="pfo__span4">
            <div class="pfo_options_title">Option Selected Button <br/><em>Background Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_options_selected" value="
            <?php if (empty($pet_foster_options['pfo_options_selected'])){echo '#9acd32';/*yellowgreen*/}
			else {echo $pet_foster_options['pfo_options_selected'];} ?>" />
        	</div>
        	
            </div><!--end row-->
            <br/>
            <!--SHOW OPTION SECTION CHECKBOXES-->
             <div class="pfo__row-fluid">
                <div class="pfo__span4">                
				<!--SHOW FRIENDLY WITH SECTION?-->
				<input type="checkbox" <?php
    			if (!isset($pet_foster_options['pfo_display_mustbeOps']) || $pet_foster_options['pfo_display_mustbeOps']=='on') {
        		echo "checked";$pet_foster_options['pfo_display_mustbeOps']='on';
    			} ?> 
    			name="pfo_display_mustbeOps" /> Show "Friendly With" section?
                </div>
                <div class="pfo__span4">
				<!--SHOW SPECIAL CARE SECTION?-->
				<input type="checkbox" <?php
    			if (!isset($pet_foster_options['pfo_display_specialOps']) || $pet_foster_options['pfo_display_specialOps']=='on') {
        		echo "checked";$pet_foster_options['pfo_display_specialOps']='on';
    			} ?>
                name="pfo_display_specialOps" /> Show "Special Care" section?
                </div>
             </div>
              <!--Hide options section by default?-->
            	<div class="pfo__row-fluid">
        			<div class="pfo__span4">
                		
          				<input type="checkbox" name="pfo_hideoptionssection_default" <?php 
          				if ($pet_foster_options['pfo_hideoptionssection_default']=='on') {
        				echo "checked";$pet_foster_options['pfo_hideoptionssection_default']='on';
    					}?> />Hide options section by default  
          			</div>
                <!--Remove options section?-->
                	<div class="pfo__span4">
                		
						<input type="checkbox" name="pfo_optionssection_remove" <?php 
          				if ($pet_foster_options['pfo_optionssection_remove']=='on'){
        				echo "checked";$pet_foster_options['pfo_optionssection_remove']='on';
    					}?> />  Remove options section completely         		
                    </div>
        	</div>
            
           </div>  <!--end section-->      
          
          <div class="pfo_style-options-section">
          
           <div class="pfo__row-fluid">
        		<div class="pfo__span12"><h2>Pet Grid Section</h2></div>
        	</div><!--end row-->
        
          <div class="pfo__row-fluid">
          
           <div class="pfo__span4">           
            <div class="pfo_options_title">Pet Grid <br/><em>Background Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_petgrid_bg" value="
            <?php if (empty($pet_foster_options['pfo_petgrid_bg'])){echo '#fff';}
			else {echo $pet_foster_options['pfo_petgrid_bg'];} ?>" />
        	</div>
            
               <div class="pfo__span4">
            <div class="pfo_options_title">Pet Title <br/><em>Text Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_pettitle_grid" value="
            <?php if (empty($pet_foster_options['pfo_pettitle_grid'])){echo '#426789';/*bluegrey*/}
			else {echo $pet_foster_options['pfo_pettitle_grid'];} ?>" />
            </div> 
           
            <div class="pfo__span4">
            <div class="pfo_options_title">Pet Description <br/><em>Background Color</em></div>
       		<input type="text" class="my-color-field" name="pfo_petdesc_grid" value="
            <?php if (empty($pet_foster_options['pfo_petdesc_grid'])){echo '#f8f8f8';}
			else {echo $pet_foster_options['pfo_petdesc_grid'];} ?>" />
       		</div>   
        	
        	</div><!--end row-->
            <div class="pfo__row-fluid">
            
                 <div class="pfo__span4">
            <div class="pfo_options_title">Pet Tags <br/><em>Text Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_pettags_grid_color" value="
            <?php if (empty($pet_foster_options['pfo_pettags_grid_color'])){echo '#333';}
			else {echo $pet_foster_options['pfo_pettags_grid_color'];} ?>" />
        	</div>
            
               <div class="pfo__span4">
            <div class="pfo_options_title">"Back to Top" Arrow <br/><em>Background Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_pageuparrow_grid_color" value="
            <?php if (empty($pet_foster_options['pfo_pageuparrow_grid_color'])){echo '#999';}
			else {echo $pet_foster_options['pfo_pageuparrow_grid_color'];} ?>" />
        	</div>
            
            </div><!--end row-->
            
            <div class="pfo__row-fluid">
            <!--show white border around icons? (default is false-->
        	<div class="pfo__span4">
            <input type="checkbox" <?php
    		if ($pet_foster_options['pfo_outlineicons_show']=='on' ) {
        	echo "checked";$pet_foster_options['pfo_outlineicons_show']=='on';
    		} ?>
            name="pfo_outlineicons_show" /> Show drop shadow around icons?
          	</div>
            
            
             <!--show up arrow?-->
        	<div class="pfo__span4">
            <input type="checkbox" <?php
    		if (!isset($pet_foster_options['pfo_pageuparrow_show']) || $pet_foster_options['pfo_pageuparrow_show']=='on' ) {
        	echo "checked";$pet_foster_options['pfo_pageuparrow_show']=='on';
    		} ?>
            name="pfo_pageuparrow_show" /> Show arrow to scroll back to top?
          	</div>
            
            
            
            </div><!--end row-->
        	
         </div><!--end section-->
           
         
          <div class="pfo_style-options-section">
          
           <div class="pfo__row-fluid">
        		<div class="pfo__span12"><h2>Pet Pop-Up Section</h2></div>
        	</div><!--end row-->
            
             <div class="pfo__row-fluid">
                <div class="pfo__span4">
                
            <div class="pfo_options_title">Pet Title<br/><em>Text Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_pettitle_popup" value="
            <?php if (empty($pet_foster_options['pfo_pettitle_popup'])){echo '#426789';/*bluegrey*/}
			else { echo $pet_foster_options['pfo_pettitle_popup'];} ?>" />
        	</div>
             
             <div class="pfo__span4">
            <div class="pfo_options_title">Tags <br/><em>Text Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_textontags_popup" value="
			<?php if (empty($pet_foster_options['pfo_textontags_popup'])){echo '#555';}
			else {echo $pet_foster_options['pfo_textontags_popup'];} ?>" />
        	</div>
            
             <div class="pfo__span4">
            <div class="pfo_options_title">Tags <br/><em>Background Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_tags_popup" value="
            <?php if (empty($pet_foster_options['pfo_tags_popup'])){echo '#eee';}
			else { echo $pet_foster_options['pfo_tags_popup'];} ?>" />
        	</div>
            
            </div><!--end row-->
            <div class="pfo__row-fluid">
            
            <div class="pfo__span4">
            <div class="pfo_options_title">Foster Me & Form Buttons <br/><em>Background Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_fosterbtnbg_popup" value="
            <?php if (empty($pet_foster_options['pfo_fosterbtnbg_popup'])){echo '#9acd32';/*yellowgreen*/}
			else { echo $pet_foster_options['pfo_fosterbtnbg_popup'];} ?>" />
        	</div>
             
             <div class="pfo__span4">
            <div class="pfo_options_title">Foster Me & Form Buttons<br/><em>Text Color</em></div>
        	<input type="text" class="my-color-field" name="pfo_fosterbtntext_popup" value="
            <?php if (empty($pet_foster_options['pfo_fosterbtntext_popup'])){echo '#fff';}
			else { echo $pet_foster_options['pfo_fosterbtntext_popup'];} ?>" />
        	</div>
          
            
          </div><!--end row-->
          </div><!--end section-->
   
           
            <div class="pfo_style-options-section">
              <div class="pfo__row-fluid">
                      
              	<div class="pfo__span6">
                	<h3>Link to Foster Application <span>(For first time foster parents)</span></h3>
        			<div class="pfo_options_title"> Please type in the full link <br/><em> Example: http://www.mysite.com/foster-form/</em></div>
                    <input class="input-large" type="text" name="pfo_fosterformpage_link" value="<?php echo $pet_foster_options['pfo_fosterformpage_link']; ?>" />        
        		</div>
                
                <div class="pfo__span6">
                	<h3>Link to Contact Form <span>(For those who have fostered before)</span></h3>
                	<div class="pfo_options_title"> Please type in the full link <br/><em> Example: http://www.mysite.com/contact/</em></div>
                    <input class="input-large" type="text" name="pfo_contactformpage_link" value="<?php echo $pet_foster_options['pfo_contactformpage_link']; ?>" />        
        		</div>
             
             </div>
           </div>
        
         <div class="pfo_style-options-section">
         
         <!--THE TEXT FIELD FOR ENTERING FOSTER INFORMATION-->
             <div class="pfo__row-fluid">
        <div class="pfo__span12"><h2>Foster Information</h2></div>
        </div>
        <div class="pfo__row-fluid">
        	<div class="pfo__span12">
            <div class="pfo_options_title">Here you can list any information about how fostering works</div>
                    <?php

					$content = '';
					$editor_id = 'pfo_shelter_info';
					$args = array("textarea_name" => "pfo_shelter_info");
					$args = array("textarea_value" => "$pet_foster_options[pfo_shelter_info]");
					//wp_editor( $content, $editor_id );
					wp_editor( $pet_foster_options['pfo_shelter_info'], "pfo_shelter_info", $args);

					?>
        	</div>
        </div>
      </div>
   
    <p class="submit">
    <input type="hidden" name="save_changes" value="1" />
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>

<h2>Reset Defaults</h2>
<form method="post" action="">
 <p class="submit">
 Reset colors to original settings: <input name="reset" class="button button-secondary" type="submit" value="Reset colors">
 <input type="hidden" name="action" value="reset"  />
 </p>
</form>

</div>

<?php 
}    
// END WRITTEN SETTINGS PAGE/////////////////////////////////
/* =============================================================
	CREATE FOSTER PAGE TEMPLATES
* ============================================================= */
/* ========== SINGLE TEMPLATE ========== */
if( !function_exists('get_fosters_single_template') ):
 function get_fosters_single_template($single_template) {
    global $wp_query, $post;
    if ($post->post_type == 'fosters'){
        $single_template = plugin_dir_path(__FILE__) . 'foster_pet_single.php';
    }//end if fosters
    return $single_template;
}//end if function
endif;
add_filter( 'single_template', 'get_fosters_single_template' ) ;
/* ========== ARCHIVE TEMPLATE ========== */
if( !function_exists('get_fosters_archive_template') ):
 function get_fosters_archive_template($archive_template) {
    global $wp_query, $post;
     if ( is_post_type_archive ( 'fosters' ) ) {
        $archive_template = plugin_dir_path(__FILE__) . 'foster_pet_archive.php';
    }//end if foster types
    return $archive_template;
}//end if function
endif; 
add_filter( 'archive_template', 'get_fosters_archive_template' ) ;
/* =============================================================
	META BOXES
* ============================================================= */
add_theme_support( 'post-thumbnails' ); // Add it for posts
add_action('add_meta_boxes', 'foster_add_meta_boxes');
add_action('save_post', 'save_foster_info');
function foster_add_meta_boxes(){
  add_meta_box("foster_posts_meta", "Foster Info", "foster_posts_custom_boxes", "fosters", "normal", "low");
  add_meta_box("foster_extra_images_meta", "Extra Images (Optional)", "foster_posts_extra_images", "fosters", "side", "low");
}
function foster_posts_custom_boxes() {?>
<!---------------------------//////////THE VARS///////------------------------------------->
<?php global $post;
$foster_type = get_post_meta($post->ID, 'foster_type', true);
$foster_age = get_post_meta($post->ID, 'foster_age', true);
$foster_size = get_post_meta($post->ID, 'foster_size', true);
$foster_gender = get_post_meta($post->ID, 'foster_gender', true);
$foster_special_sick = get_post_meta($post->ID, 'foster_special_sick', true);
$foster_special_injured = get_post_meta($post->ID, 'foster_special_injured', true);
$foster_special_stressed = get_post_meta($post->ID, 'foster_special_stressed', true);
$foster_special_maternity = get_post_meta($post->ID, 'foster_special_maternity', true);
$foster_trait_dog_friendly = get_post_meta($post->ID, 'foster_trait_dog_friendly', true);
$foster_trait_cat_friendly = get_post_meta($post->ID, 'foster_trait_cat_friendly', true);
$foster_trait_kid_friendly = get_post_meta($post->ID, 'foster_trait_kid_friendly', true);
$foster_urgency = get_post_meta($post->ID, 'foster_urgency', true);
?>
<!---------------------------//////////DROPDOWNS///////------------------------------------->
<!---------TYPE------------->
<div class="pfo__row-fluid" style="padding: 25px;margin: 5px 0;">
<div class="pfo__span2">
Type:<br/>
    <select name="foster_type">
        <option value="Cat" <?php
        if ($foster_type == "Cat") {
            echo "selected";
        }
        ?>>Cat</option>
        <option value="Dog" <?php
        if ($foster_type == "Dog") {
            echo "selected";
        }
        ?>>Dog</option>
        <option value="Small & Furry" <?php
        if ($foster_type == "Small & Furry") {
            echo "selected";
        }
        ?>>Small & Furry</option>
        <option value="Barnyard" <?php
        if ($foster_type == "Barnyard") {
            echo "selected";
        }
        ?>>Barnyard</option>
        <option value="Horse" <?php
        if ($foster_type == "Horse") {
            echo "selected";
        }
        ?>>Horse</option>
        <option value="Pig" <?php
        if ($foster_type == "Pig") {
            echo "selected";
        }
        ?>>Pig</option>
        <option value="Rabbit" <?php
        if ($foster_type == "Rabbit") {
            echo "selected";
        }
        ?>>Rabbit</option>
        <option value="Reptile" <?php
        if ($foster_type == "Reptile") {
            echo "selected";
        }
        ?>>Reptile</option>
    </select>
</div>
<div class="pfo__span2">
<!---------AGE------------->
Age:<br/>
    <select name="foster_age">
        <option value="Baby" <?php
        if ($foster_age == "Baby") {
            echo "selected";
        }
        ?>>Baby</option>
        <option value="Young" <?php
        if ($foster_age == "Young") {
            echo "selected";
        }
        ?>>Young</option>
        <option value="Adult" <?php
        if ($foster_age == "Adult") {
            echo "selected";
        }
        ?>>Adult</option>
        <option value="Senior" <?php
        if ($foster_age == "Senior") {
            echo "selected";
        }
        ?>>Senior</option>
    </select>
</div>
<div class="pfo__span2">
<!---------SIZE------------->
Size:<br/>
    <select name="foster_size">
        <option value="Small" <?php
        if ($foster_size == "Small") {
            echo "selected";
        }
        ?>>Small</option>
        <option value="Medium" <?php
        if ($foster_size == "Medium") {
            echo "selected";
        }
        ?>>Medium</option>
        <option value="Large" <?php
        if ($foster_size == "Large") {
            echo "selected";
        }
        ?>>Large</option>
        <option value="Extra Large" <?php
        if ($foster_size == "Extra Large") {
            echo "selected";
        }
        ?>>Extra Large</option>
    </select>
</div>
<div class="pfo__span2">
<!---------GENDER------------->
Gender:<br/>
    <select name="foster_gender">
        <option value="Female" <?php
        if ($foster_gender == "Female") {
            echo "selected";
        }
        ?>>Female</option>
        <option value="Male" <?php
        if ($foster_gender == "Male") {
            echo "selected";
        }
        ?>>Male</option>
        <option value="Mixed" <?php
        if ($foster_gender == "Mixed") {
            echo "selected";
        }
        ?>>Mixed (Litter)</option>
    </select>
</div>
<div class="pfo__span2">
<!---------URGENCY------------->
Urgency:<br/>
    <select name="foster_urgency">
        <option value="3-Low Priority" <?php
        if ($foster_urgency == "3-Low Priority") {
            echo "selected";
        }
        ?>>Low Priority</option>
        <option value="2-Medium Priority" <?php
        if ($foster_urgency == "2-Medium Priority") {
            echo "selected";
        }
        ?>>Medium Priority</option>
        <option value="1-High Priority" <?php
        if ($foster_urgency == "1-High Priority") {
            echo "selected";
        }
        ?>>High Priority</option>
    </select>
</div>
</div><!--end dropdown row-->
<div class="pfo__row-fluid" style="border-top: 1px solid #ccc;padding: 25px;margin: 5px 0;">
<div class="pfo__span3">
<?php /*---------------------------//////////CHECKBOXES///////-------------------------------------*/?>
<!---------SPECIAL NEEDS------------->
<!--SICK?-->
	<input type="checkbox" <?php
    if ($foster_special_sick == "on") {
        echo "checked";
    } ?> 
    name="foster_special_sick" /> Sick? 
    </div>
    <div class="pfo__span3">
<!--INJURED?-->
	<input type="checkbox" <?php
    if ($foster_special_injured == "on") {
        echo "checked";
    } ?> 
    name="foster_special_injured" /> Injured? 
    </div>
    <div class="pfo__span3">
<!--STRESSED?-->
	<input type="checkbox" <?php
    if ($foster_special_stressed == "on") {
        echo "checked";
    } ?> 
    name="foster_special_stressed" /> Stressed?
    </div>
    <div class="pfo__span3">
<!--MATERNITY?-->
	<input type="checkbox" <?php
    if ($foster_special_maternity == "on") {
        echo "checked";
    } ?> 
    name="foster_special_maternity" /> Pregnant/With Litter? 
    </div>
    </div>
    <div class="pfo__row-fluid" style="border-top: 1px solid #ccc;padding: 25px;margin: 5px 0;">
    <div class="pfo__span3">
<!---------TRAITS------------->
<!--DOG-FRIENDLY?-->
	<input type="checkbox" <?php
    if ($foster_trait_dog_friendly == "on") {
        echo "checked";
    } ?> 
    name="foster_trait_dog_friendly" /> Dog-friendly? 
    </div>
    <div class="pfo__span3">
<!--CAT-FRIENDLY?-->
	<input type="checkbox" <?php
    if ($foster_trait_cat_friendly == "on") {
        echo "checked";
    } ?> 
    name="foster_trait_cat_friendly" /> Cat-friendly? 
    </div>
    <div class="pfo__span3">
<!--KID-FRIENDLY?-->
	<input type="checkbox" <?php
    if ($foster_trait_kid_friendly == "on") {
        echo "checked";
    } ?> 
    name="foster_trait_kid_friendly" /> Kid-friendly? 
    </div>
    </div>
<?php }//END METABOXES FUNCTION 
/*---------////////////////URGENT?/////////////-------------*/
function foster_posts_extra_images (){
global $post;//required
$custom = get_post_custom($post->ID);//required
$foster_extra_image1 = $custom["foster_extra_image1"][0];
$foster_extra_image2 = $custom["foster_extra_image2"][0];?>
  	<div class="meta-image-holder" style="text-align:center">
	<!--IMAGE 1-->
    <label for="meta-image" class="prfx-row-title"><?php _e( 'Image 1:', 'prfx-textdomain' )?></label><br/>
	<?php echo '<img class="foster_extra_image_src1" src="'.$foster_extra_image1.'" width="120"/><br/>';?>
    <input type="text" name="foster_extra_image1" id="foster_extra_image1" value="<?php echo $foster_extra_image1; ?>" /><br/>
    <input type="button" id="foster-image-button1" class="button meta-button" value="<?php _e( 'Select Image', 'prfx-textdomain' )?>" />
    <br/>
    <a class="foster_delete_extra_image1" style="display:none;cursor:pointer;">Remove Image</a>
     </div>
     <hr />
     <div class="meta-image-holder" style="text-align:center">
    <!--IMAGE 2-->
     <label for="meta-image" class="prfx-row-title"><?php _e( 'Image 2:', 'prfx-textdomain' )?></label><br/>
     
	<?php echo '<img class="foster_extra_image_src2" src="'.$foster_extra_image2.'" width="120"/><br/>';?>
	
    <input type="text" name="foster_extra_image2" id="foster_extra_image2" value="<?php echo $foster_extra_image2; ?>" /><br/>
    <input type="button" id="foster-image-button2" class="button meta-button" value="<?php _e( 'Select Image', 'prfx-textdomain' )?>" />
    <br/>
    <a class="foster_delete_extra_image2" style="display:none;cursor:pointer;">Remove Image</a>
    </div>
<?php }
/** Loads the image management javascript*/
function fosterme_uploadimage_enqueue() {
    global $typenow;
    if( $typenow == 'fosters' ) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', plugins_url('js/postImage-upload.js', __FILE__), array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
                'button' => __( 'Use this image', 'prfx-textdomain' ),
            )
        );
        wp_enqueue_script( 'meta-box-image' );
    }
	
}
add_action( 'admin_enqueue_scripts', 'fosterme_uploadimage_enqueue' );
/*---------------------------//////////SAVE VARS///////-------------------------------------*/
function save_foster_info($post_id){
global $post; 
$foster_type = get_post_meta($post->ID, 'foster_type', true);
$foster_age = get_post_meta($post->ID, 'foster_age', true);
$foster_size = get_post_meta($post->ID, 'foster_size', true);
$foster_gender = get_post_meta($post->ID, 'foster_gender', true);
$foster_special_sick = get_post_meta($post->ID, 'foster_special_sick', true);
$foster_special_injured = get_post_meta($post->ID, 'foster_special_injured', true);
$foster_special_stressed = get_post_meta($post->ID, 'foster_special_stressed', true);
$foster_special_maternity = get_post_meta($post->ID, 'foster_special_maternity', true);
$foster_trait_dog_friendly = get_post_meta($post->ID, 'foster_trait_dog_friendly', true);
$foster_trait_cat_friendly = get_post_meta($post->ID, 'foster_trait_cat_friendly', true);
$foster_trait_kid_friendly = get_post_meta($post->ID, 'foster_trait_kid_friendly', true);
$foster_urgency = get_post_meta($post->ID, 'foster_urgency', true);
update_post_meta($post->ID, 'foster_type', $_POST['foster_type'], $foster_type);
update_post_meta($post->ID, 'foster_age', $_POST['foster_age'], $foster_age);
update_post_meta($post->ID, 'foster_size', $_POST['foster_size'], $foster_size);
update_post_meta($post->ID, 'foster_gender', $_POST['foster_gender'], $foster_gender);
update_post_meta($post->ID, 'foster_special_sick', $_POST['foster_special_sick'], $foster_special_sick);
update_post_meta($post->ID, 'foster_special_injured', $_POST['foster_special_injured'], $foster_special_injured);
update_post_meta($post->ID, 'foster_special_stressed', $_POST['foster_special_stressed'], $foster_special_stressed);
update_post_meta($post->ID, 'foster_special_maternity', $_POST['foster_special_maternity'], $foster_special_maternity);
update_post_meta($post->ID, 'foster_trait_dog_friendly', $_POST['foster_trait_dog_friendly'], $foster_trait_dog_friendly);
update_post_meta($post->ID, 'foster_trait_cat_friendly', $_POST['foster_trait_cat_friendly'], $foster_trait_cat_friendly);
update_post_meta($post->ID, 'foster_trait_kid_friendly', $_POST['foster_trait_kid_friendly'], $foster_trait_kid_friendly);
update_post_meta($post->ID, 'foster_urgency', $_POST['foster_urgency'], $foster_urgency);
update_post_meta($post->ID, 'foster_extra_image1', $_POST['foster_extra_image1'], $foster_extra_image1);
update_post_meta($post->ID, 'foster_extra_image2', $_POST['foster_extra_image2'], $foster_extra_image2);
}
//END SAVE INFO FUNCTION?>