<?php
/**
 * The template for displaying Foster Pets from Foster Plugin
 */
get_header(); ?><head>
<?php
/* =============================================================
	SCRIPTS & STYLES SPECIFIC TO PAGE
* ============================================================= */?>
	<?php echo'<script type="text/javascript" src="'.plugins_url( "js/modernizr.custom.min.js", __FILE__ ).'"></script>';?>
	<?php echo'<script type="text/javascript" src="' .plugins_url("js/jquery.shuffle.js", __FILE__ ).'"></script>';?>
<?php
/* =============================================================
	CREATE BUTTON LISTS
* ============================================================= */?>
<?php
global $pet_foster_options;
$display_mustbeOps = $pet_foster_options['pfo_display_mustbeOps'];
if (!isset($display_mustbeOps)){$display_mustbeOps='on';}
$display_specialOps = $pet_foster_options['pfo_display_specialOps'];
if (!isset($display_specialOps)){$display_specialOps='on';}
$pfo_pageuparrow_show = $pet_foster_options['pfo_pageuparrow_show'];
if (!isset($pfo_pageuparrow_show)){$pfo_pageuparrow_show='on';}
$fosterme_page_title = $pet_foster_options['fosterme_page_title'];
if (!isset($fosterme_page_title)){$fosterme_page_title='Foster a Pet';}
else{$fosterme_page_title = stripslashes($pet_foster_options['fosterme_page_title']);}
?>
    <?php 
	$types = '';
	$type_list = '';
	$ages = '';
	$age_list = '';
	$sizes = '';
	$size_list = '';
	$genders = '';
	$gender_list = '';
	$mustbes = '';
	$mustbe_list = '';
	$specials = '';
	$special_list = '';				
	$fosterpets_args = array( 'post_type' => 'fosters', 'posts_per_page' => -1 );
	$fosterpets_loop = new WP_Query( $fosterpets_args );
	while ( $fosterpets_loop->have_posts() ) : $fosterpets_loop->the_post();
		/*TYPES*/
		$types .= get_post_meta($post->ID, 'foster_type', true). "|";
		/*AGES*/
		$ages .= get_post_meta($post->ID, 'foster_age', true). "|";
		/*SIZES*/
		$sizes .= get_post_meta($post->ID, 'foster_size', true). "|";
		/*GENDERS*/
		$genders .= get_post_meta($post->ID, 'foster_gender', true). "|";
	endwhile; 
	// Remove duplicates, convert into an array
	$types = array_filter(array_unique(explode('|', $types)));
	$ages = array_filter(array_unique(explode('|', $ages)));
	$sizes = array_filter(array_unique(explode('|', $sizes)));
	$genders = array_filter(array_unique(explode('|', $genders)));
	// Alphabetize
	asort($types);
	asort($ages);
	asort($sizes);
	asort($genders);	
	//Create button lists
		// TYPE
		foreach( $types as $type ) {
			$type_list .= '<li class="btn" data-group='.fosterme_value_condensed($type).'><span class="pfo__hoverme">'.$type.'</span></li>';
		}
		// AGE
		foreach( $ages as $age ) {
			$age_list .= '<li class="btn" data-group='.fosterme_value_condensed($age).'><span class="pfo__hoverme">'.$age.'</span></li>';
		}
		// SIZE
		foreach( $sizes as $size ) {
			$size_list .= '<li class="btn" data-group='.fosterme_value_condensed($size).'><span class="pfo__hoverme">'.$size.'</span></li>';
		}
		// GENDER
		foreach( $genders as $gender ) {
			if ( $gender=="Female" || $gender=="Male"){//leave out Mixed
			$gender_list .= '<li class="btn" data-group='.fosterme_value_condensed($gender).'><span class="pfo__hoverme">'.$gender.'</span></li>';
			}
		}
		//(HARDWRITE MUSTBE'S, SPECIALS, AND STATUS LISTS
		/*MUST-BE'S*/
		$mustbe_list .= '<li class="btn btn-with-icon pfo__span4 trait-dog-friendly-btn" data-group="Dog-Friendly"><span class="pfo__hoverme"><div class="icoFoster-dog-friendly foster-icon"></div>Dogs</span></li>';
		$mustbe_list .= '<li class="btn btn-with-icon pfo__span4 trait-cat-friendly-btn" data-group="Cat-Friendly"><span class="pfo__hoverme"><div class="icoFoster-cat-friendly foster-icon"></div>Cats</span></li>';
		$mustbe_list .= '<li class="btn btn-with-icon pfo__span4 trait-kid-friendly-btn" data-group="Kid-Friendly"><span class="pfo__hoverme"><div class="icoFoster-kid-friendly foster-icon"></div>Kids</span></li>';
		/*SPECIALS*/
		$special_list .= '<li class="btn btn-with-icon pfo__span3 special-sick-btn" data-group="Sick"><span class="pfo__hoverme"><div class="icoFoster-sick foster-icon"></div>Sick</span></li>';
		$special_list .= '<li class="btn btn-with-icon pfo__span3 special-injured-btn" data-group="Injured"><span class="pfo__hoverme"><div class="icoFoster-hurt foster-icon"></div>Injured</span></li>';
		$special_list .= '<li class="btn btn-with-icon pfo__span3 special-stressed-btn" data-group="Stressed"><span class="pfo__hoverme"><div class="icoFoster-stressed foster-icon"></div>Stressed</span></li>';
		$special_list .= '<li class="btn btn-with-icon pfo__span3 special-maternity-btn" data-group="Maternity"><span class="pfo__hoverme"><div class="icoFoster-maternity foster-icon"></div>Maternity</span></li>';
						
	/* =============================================================
	PET VALUE CONDENSER
	Removes spacing and special characters from strings.
 * ============================================================= */

function fosterme_value_condensed($pet_value) {

	// Define characters to remove and remove them
	$condense_list = array('(' => '', ')' => '', '&' => '-', '/' => '-', '  ' => '-', ' ' => '-');
	$pet_value = strtr($pet_value, $condense_list);

	// Return condensed list
	return $pet_value;

}
			?>
</head>


<div id="content" class="site-content">
			<header class="page-header">
 <!-- =============================================================
	SET COLORS
	Pull is pet_foster vars from option pages to set colors.
 * ============================================================= -->
<?php echo '<style>
.entry-title{margin: 5px auto;}
/**STYLE OPTIONS SECTION**/
.pfo__header, #pfo__preloader{background-color: ' . $pet_foster_options['pfo_header_bg'] . ';border-bottom:1px solid ' . $pet_foster_options['pfo_options_bg'] . ';}
#fosterme_container #toggle-petOptions{color: ' . $pet_foster_options['pfo_show_hide'] . '; background-color: ' . $pet_foster_options['pfo_options_bg'] . ';}
.pfo__header .pfo__header-icon, .pfo__header .pfo__header-icon a, #pfo__preloader{color: ' . $pet_foster_options['pfo_header_links'] . ';}

#fosterme_container p.filter__label{color:' . $pet_foster_options['pfo_options_title_color'] . ';}
#fosterme_container #all-pet-options{background-color: ' . $pet_foster_options['pfo_options_bg'] . ';}
#fosterme_container .petOption-section{background-color:' . $pet_foster_options['pfo_optionssection_bg'] . '; border:1px solid ' . $pet_foster_options['pfo_options_text_color'] . ';}
.fosterme__btn-group .btn span{color:' . $pet_foster_options['pfo_options_text_color'] . ';}
#fosterme_container .petOption-section .btn-group .btn span{background-color:' . $pet_foster_options['pfo_optionssection_bg'] . ';color:' . $pet_foster_options['pfo_options_text_color'] . ';}
.fosterme__btn-group .btn.active span, .fosterme__btn-group .btn:hover span, .fosterme__btn-group .onlyOption span{background-color:' . $pet_foster_options['pfo_options_selected'] . '; color:' . $pet_foster_options['pfo_options_selected_text'] . ';}


/**STYLE GRID SECTION**/
.pfo_container-pets{background-color: ' . $pet_foster_options['pfo_petgrid_bg'] . ';}
#fosterme_container .picture-item .picture-item__title, #fosterme_container .window-popup-title{color: ' . $pet_foster_options['pfo_pettitle_grid'] . ';}
#fosterme_container .picture-item{ background-color: ' . $pet_foster_options['pfo_petdesc_grid'] . ';}
#fosterme_container .picture-item .picture-item__tags .item__info-tag li{color: ' . $pet_foster_options['pfo_pettags_grid_color'] . ';}
.pfo-pagetop-arrow{background-color: ' . $pet_foster_options['pfo_pageuparrow_grid_color'] . ';}

/**STYLE POP-UP SECTION**/
#fosterme_container .window-popup #pet-info span{background-color: ' . $pet_foster_options['pfo_tags_popup'] . ';color:' . $pet_foster_options['pfo_textontags_popup'] . '}
#fosterme_container .window-popup .window-popup-title{color: ' . $pet_foster_options['pfo_pettitle_popup'] . ';}
#fosterme_container .main-foster-color span{color: ' . $pet_foster_options['pfo_fosterbtntext_popup'] .'; background-color: ' . $pet_foster_options['pfo_fosterbtnbg_popup'] .';}';
if ($pet_foster_options['pfo_outlineicons_show'] == 'on'){
	echo '.fosterme__btn-group .btn.btn-with-icon > span, .item__icon-tag .foster-icon-tag{-webkit-box-shadow: 0px 0px 8px #222;-moz-box-shadow: 0px 0px 8px #222;box-shadow: 0px 0px 8px #222;}';
}
echo '</style>';?>            
				<h1 class="entry-title"><?php echo $fosterme_page_title;?></h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->
<!-------------------START FOSTER ME!------------------------->
<div id="container">
	<div id="content" role="main">
<div id="fosterme_container" class="fostermearchive">
		<!--PRELOADER-->
	<div id="pfo__preloader">
  			Loading our fosters
    		<div id="preloader-icon"></div>
	</div>
<!-- pagetop arrow -->
 <?php // see if arrow is hidden
if ($pfo_pageuparrow_show == 'on'){?>
<div class="pfo__hoverme pfo-pagetop-arrow"><span class="icoFoster-up"></span></div>
 <?php } ?>
  
<!--all popup bgs-->
<div class="popup-bg"></div>
<!--POPUP - CLICKED ON PET-->
<div id="indiepet-popup" class="window-popup">
<div id="indiepet-popup-info">
<div id="indiepet-popup-topbtns" class="window-popup-topbtns">
    <span class="icoFoster-left pfo__hoverme" id="indiepet-popup-previous"></span>
    <span class="icoFoster-right pfo__hoverme" id="indiepet-popup-next"></span>
     <span class="icoFoster-close pfo__hoverme window-popup-close"></span>
   </div>
    	<!--Photos-->
      	<div id="pet-multiphotos"></div>
        <!--Foster Data-->
        <div class="foster-popup-data">
      		<!--Foster Btn-->
     		<div id="pet-foster-btn" class="main-foster-color pfo__hoverme btn-med">
            	<span><span class="icoFoster-foster"></span>Foster Me</span>
         	</div>
            <!--Date Added-->
    		<div id="pet-date-added"></div>
        	<!--Urgency-->
    		<div id="pet-urgency"></div>
        </div>
        <div class="my-petInfoAll">    
    		<!--Pet Name-->
    		<div class="indiepet-popup-title window-popup-title"></div>
    		<!--Pet Attributes-->
    		<div id="pet-info"></div>
        	<!--Pet Icons-->
            <div id="pet-icons"></div>            
            <!--Pet Status-->
    		<div id="pet-status"></div>
      		<!--Description-->
      		<div id="pet-description"><pre class="pf-description"></pre></div>
          </div>
        </div>
       <div id="fosterme-popup">
       <div id="fosterme-popup-backbtn">Back</div>
               <div id="fosterme-popup-inner" class="pfo__row-fluid">
      	 <div class="fosterme-popup-left pfo__span6">
         	<h2>First time foster parent?</h2>
            <p>Welcome! You will need to fill out this application and be approved before you can foster <strong><span class="indiepet-popup-title"></span></strong>.
            <div id="fosterformlink"  class="pfo__hoverme main-foster-color btn-lg" data-group="<?php echo $pet_foster_options['pfo_fosterformpage_link'];?>"></div>
       	 </div>
         <div class="fosterme-popup-right pfo__span6">
         	<h2>Fostered with us already?</h2>
             <p>Great! We appreciate your continued help.  Please let us know you are have an interest in fostering <strong><span class="indiepet-popup-title"></span></strong>.</p>
             <div id="fostercontactlink"  class="pfo__hoverme main-foster-color btn-lg" data-group="<?php echo $pet_foster_options['pfo_contactformpage_link'];?>"></div>
       	 </div>
         </div>
       </div>
  </div>
  <!--END PET POPUP-->
  
  <!--FOSTER INFO POPUP-->  
  <div id="fosterinfo-popup" class="window-popup">
  <div class="window-popup-title">Information on fostering</div>
  		<div id="indiepet-popup-topbtns" class="window-popup-topbtns">
     		<span class="icoFoster-close pfo__hoverme window-popup-close"></span>
   		</div>
   		<pre id="fosterinfo-popup-inner" class="window-popup-inner"><?php echo $pet_foster_options['pfo_shelter_info'];?></pre>
   </div>
            <!--SEARCH HEADER CONTAINER-->
              <div class="pfo__header">
    <div class="pfo__row-fluid">
     <?php add_option("foster-me", $pet_foster_options);
	$pet_foster_options = get_option('foster-me');?>
    <?php if ($pet_foster_options['pfo_optionssection_remove']!='on'){?>
      <!--show options-->
      <div class="pfo__span4" id="toggle-petOptions-holder">
      	<div id="toggle-petOptions" class="pfo__hoverme toggle-petOptions">
        <?php if ($pet_foster_options['pfo_hideoptionssection_default']=='on'){?>
        <span class="toggle-petOptions-text">Show Options</span>
        <span class="icoFoster-show"></span></div>  
        <?php } else {?>
        <span class="toggle-petOptions-text">Hide Options</span>
        <span class="icoFoster-hide"></span></div>   
        <?php }?>
      </div> 
      <?php } else{ ?>
      <div class="pfo__span4"></div>
      <?php }?>
     
      <!--search bar-->
      <div class="pfo__span4" id="pfo__search-icon-container">
      <span id="pfo__search-icon"><span class="icoFoster-search"></span></span>
        <input class="filter__search js-shuffle-search" type="text" placeholder="Search pet name...">       
      </div>     
      
          <!--petOptions headline-->
      <div class="pfo__span4">
      
      	<div class="pfo__header-icon pfo__hoverme" id="pfo__fosterform-btn" title="Foster Form">
        	<a href="<?php echo $pet_foster_options['pfo_fosterformpage_link'];?>"><span class="icoFoster-application"></span><span class="pfo__header-title">Foster Form</span></a>
         </div> 
      
       <div class="pfo__header-icon pfo__hoverme" id="pfo__fosterinfo-btn" title="Fostering Information">
        	<span class="icoFoster-info"></span>
         </div>
                
      </div><!--end SPAN-->

    </div><!--end top row-->
  </div><!--end header--> 

<!--BTNS FOR CATEGORIES-->
  <div class="pfo_container-pets">
	<!--all pet options-->
    <?php add_option("foster-me", $pet_foster_options);
	$pet_foster_options = get_option('foster-me');?>
    <?php if ($pet_foster_options['pfo_optionssection_remove']=='on' || $pet_foster_options['pfo_hideoptionssection_default']=='on'){?>
    <div id="all-pet-options" style="display:none;">
    <?php } else {?>
    <div id="all-pet-options">
    <?php }?>
        <div class="pfo__row-fluid">
        <!--TYPE-->
        	<div class="pfo__span3 petOption-section">
            	<p class="filter__label">Type</p>
            	<ul class="filter-options fosterme__btn-group OR-fosterme__btn-group">
                	<?php echo $type_list;?>
					<li class="btn  allbtn" data-group="all"><span class="pfo__hoverme">Any Type</span></li>
				</ul><!--end btn-group-->
			</div><!--end span-->
  		<!--SIZE-->
  			<div class="pfo__span3 petOption-section">
            	<p class="filter__label">Size</p>
            	<ul class="filter-options fosterme__btn-group">
					<?php echo $size_list;?>
					<li class="btn  allbtn" data-group="all"><span class="pfo__hoverme">Any Size</span></li>
				</ul><!--end btn-group-->
			</div><!--end span-->
  		<!--AGE-->
  			<div class="pfo__span3 petOption-section">
            	<p class="filter__label">Age</p>
            	<ul class="filter-options fosterme__btn-group">
					<?php echo $age_list;?>
					<li class="btn  allbtn" data-group="all"><span class="pfo__hoverme">Any Age</span></li>
				</ul><!--end btn-group-->
			</div><!--end span-->
   		<!--GENDER-->
  			<div class="pfo__span3 petOption-section">
            	<p class="filter__label">Gender</p>
            	<ul class="filter-options fosterme__btn-group OR-fosterme__btn-group">
					<?php echo $gender_list;?>
					<li class="btn allbtn" data-group="all"><span class="pfo__hoverme">Both</span></li>
				</ul><!--end btn-group-->
			</div><!--end span-->
	</div><!--end row-->
    <div class="pfo__row-fluid">
  		<!--MUST BE-->
        <?php if($display_mustbeOps == 'on'){ //only show friendly section if box is checked?>
        	<div class="pfo__span4 petOption-section friendlyWith-section">
            	<p class="filter__label">Friendly with...</p>
            	<ul class="filter-options fosterme__btn-group lookingFor-optionGroup">
				<?php echo $mustbe_list;?>
					<!--<li class="btn allbtn" data-group="all"><span class="pfo__hoverme">All</span></li>-->
				</ul><!--end btn-group-->
			</div><!--end span-->
          <?php }?>
            <!--SPECIAL OPTIONS-->
         <?php if($display_specialOps == 'on'){ //only show special care section if box is checked?>
        	<div class="pfo__span5 petOption-section specialOps-section">
            	<p class="filter__label">Special Care</p>
            	<ul class="filter-options fosterme__btn-group OR-fosterme__btn-group">
				<?php echo $special_list;?>
					<!--<li class="btn allbtn" data-group="all"><span class="pfo__hoverme">All</span></li>-->
				</ul><!--end btn-group-->
			</div><!--end span-->
         <?php }?>
                     
        <!--RESET-->
        <?php if($display_mustbeOps == 'on' || $display_specialOps == 'on'){?>
            <div class="pfo__span2 pfo__resetbutton" style="margin:0;width:auto;">
				<ul class="filter-options fosterme__btn-group">
					<li class="btn  viewallbtn" data-group="all"><span class="pfo__hoverme">Reset</span></li>
				</ul>
			</div><!--end span-->
           <?php }
		   else{?>
            <div class="pfo__span2 pfo__resetbutton" style="float:right">
				<ul class="filter-options fosterme__btn-group">
					<li class="btn  viewallbtn" data-group="all"  style="margin:0;"><span class="pfo__hoverme">Reset</span></li>
				</ul>
			</div><!--end span-->
            <?php }?>
           
		</div><!--end row-->
       </div><!--end pet options-->
 
  <div class="container-icons">
      <!--sorting-->
      <div class="pfo__row-fluid">
         <div class="pfo__span3 pull-right" id="icon-sorting">
          <p class="filter__label">Sort:</p>
          <select class="sort-options">
            <option value="">Newest First</option>
            <option value="urgency">Priority First</option>
            <option value="title">Name</option>
          </select>
      </div> 
      </div>
        <div id="noPetsCriteria-msg" class="noPetsFound-msg">Sorry, no pets were found with your search criteria.  Keep looking :)</div>
		<div id="noPetsName-msg" class="noPetsFound-msg">Sorry, no pets were found with that name.  Keep looking :)</div>
<div id="fosterme__grid" class="pfo__row-fluid m-row shuffle--container shuffle--fluid shuffle" style="transition: height 250ms ease-out; -webkit-transition: height 250ms ease-out; height: 1220px;">
<?php /* Start the Loop */ ?>
<?php while ( $fosterpets_loop->have_posts() ) : $fosterpets_loop->the_post(); ?>
<?php
//grab vars
$icon_tags_list='';
$foster_type = get_post_meta($post->ID, 'foster_type', true);
$foster_age = get_post_meta($post->ID, 'foster_age', true);
$foster_size = get_post_meta($post->ID, 'foster_size', true);
$foster_gender = get_post_meta($post->ID, 'foster_gender', true);
$foster_urgency = get_post_meta($post->ID, 'foster_urgency', true);
$foster_special_sick = get_post_meta($post->ID, 'foster_special_sick', true);
$foster_special_injured = get_post_meta($post->ID, 'foster_special_injured', true);
$foster_special_stressed = get_post_meta($post->ID, 'foster_special_stressed', true);
$foster_special_maternity = get_post_meta($post->ID, 'foster_special_maternity', true);
$foster_trait_dog_friendly = get_post_meta($post->ID, 'foster_trait_dog_friendly', true);
$foster_trait_cat_friendly = get_post_meta($post->ID, 'foster_trait_cat_friendly', true);
$foster_trait_kid_friendly = get_post_meta($post->ID, 'foster_trait_kid_friendly', true);
//////START TAG ICONS////
/*SICK*/
if ($foster_special_sick == 'on' && $display_specialOps == 'on'){
	$foster_special_sick='Sick';$icon_tags_list .='<li><span class="icoFoster-sick foster-icon-tag" title="Sick"></span><span class="textFoster-sick foster-tag-text">Sick</span></li>';}
	else{$foster_special_sick='';}
/*INJURED*/
if ($foster_special_injured == 'on' && $display_specialOps == 'on'){
	$foster_special_injured='Injured';$icon_tags_list .='<li><span  class="icoFoster-hurt foster-icon-tag" title="Injured"></span><span class="textFoster-injured foster-tag-text">Injured</span></li>';}
	else{$foster_special_injured='';}
/*STRESSED*/
if ($foster_special_stressed == 'on' && $display_specialOps == 'on'){
	$foster_special_stressed='Stressed';$icon_tags_list .='<li><span  class="icoFoster-stressed foster-icon-tag" title="Stressed"></span><span class="textFoster-stressed foster-tag-text">Stressed</span></li>';}
	else{$foster_special_stressed='';}
/*MATERNITY*/
if ($foster_special_maternity == 'on' && $display_specialOps == 'on'){
	$foster_special_maternity='Maternity';$icon_tags_list .='<li><span  class="icoFoster-maternity foster-icon-tag" title="Maternity"></span><span class="textFoster-maternity foster-tag-text">Maternity</span></li>';}
	else{$foster_special_maternity='';}
/*DOG FRIENDLY*/
if ($foster_trait_dog_friendly == 'on' && $display_mustbeOps == 'on'){
	$foster_trait_dog_friendly = 'Dog Friendly';$icon_tags_list .='<li class="foster-friendly-icon"><span  class="icoFoster-dog-friendly foster-icon-tag" title="Dog Friendly"></span><span class="textFoster-dog-friendly foster-tag-text">Dog Friendly</span></li>';}
	else{$foster_trait_dog_friendly='';}
/*CAT FRIENDLY*/
if ($foster_trait_cat_friendly == 'on' && $display_mustbeOps == 'on'){
	$foster_trait_cat_friendly = 'Cat Friendly';$icon_tags_list .='<li class="foster-friendly-icon"><span  class="icoFoster-cat-friendly foster-icon-tag" title="Cat Friendly"></span><span class="textFoster-cat-friendly foster-tag-text">Cat Friendly</span></li>';}
	else {$foster_trait_cat_friendly='';}
/*KID FRIENDLY*/
if ($foster_trait_kid_friendly == 'on' && $display_mustbeOps == 'on'){
	$foster_trait_kid_friendly = 'Kid Friendly';$icon_tags_list .='<li class="foster-friendly-icon"><span  class="icoFoster-kid-friendly foster-icon-tag" title="Kid Friendly"></span><span class="textFoster-kid-friendly foster-tag-text">Kid Friendly</span></li>';}
	else {$foster_trait_kid_friendly='';}
//////END TAG ICONS////
//images
$custom = get_post_custom($post->ID);//required
$foster_extra_image1 = $custom["foster_extra_image1"][0];
$foster_extra_image2 = $custom["foster_extra_image2"][0];
?>
		<div class="pfo__span2 picture-item shuffle-item filtered <?php echo fosterme_value_condensed($foster_gender).' '.fosterme_value_condensed($foster_size).' '.fosterme_value_condensed($foster_type).' '.fosterme_value_condensed($foster_age).' '.fosterme_value_condensed($foster_special_sick).' '.fosterme_value_condensed($foster_special_injured).' '.fosterme_value_condensed($foster_special_stressed).' '.fosterme_value_condensed($foster_special_maternity).' '.fosterme_value_condensed($foster_trait_dog_friendly).' '.fosterme_value_condensed($foster_trait_cat_friendly).' '.fosterme_value_condensed($foster_trait_kid_friendly);?>" data-groups="[<?php echo '&quot;'.fosterme_value_condensed($foster_gender).'&quot;,&quot;'.fosterme_value_condensed($foster_size).'&quot;,&quot;'.fosterme_value_condensed($foster_type).'&quot;,&quot;'.fosterme_value_condensed($foster_age).'&quot;,&quot;'.fosterme_value_condensed($foster_special_sick).'&quot;,&quot;'.fosterme_value_condensed($foster_special_injured).'&quot;,&quot;'.fosterme_value_condensed($foster_special_stressed).'&quot;,&quot;'.fosterme_value_condensed($foster_special_maternity).'&quot;,&quot;'.fosterme_value_condensed($foster_trait_dog_friendly).'&quot;,&quot;'.fosterme_value_condensed($foster_trait_cat_friendly).'&quot;,&quot;'.fosterme_value_condensed($foster_trait_kid_friendly).'&quot;';?>]" data-title="<?php  the_title(); ?>" data-urgency="<?php echo $foster_urgency; ?>" date-created="<?php echo  the_time( get_option( 'date_format' ) ); ?>">
              <div class="picture-item__inner">
    			<div class="picture-item__glyph"><?php  the_post_thumbnail('medium'); ?></div>
				<div class="picture-item__details clearfix">
      				<div class="picture-item__title"><?php  the_title(); ?></div>
	  					<div class="picture-item__tags">
                        <ul class="item__info-tag">
	 						<?php echo '<li>'.$foster_type.'</li>';?>
	 						<?php echo '<li>'.$foster_age.'</li>';?>
     						<?php echo '<li>'.$foster_gender.'</li>';?>
     						<?php echo '<li>'.$foster_size.'</li>';?> 
                        </ul>
                        <ul class="item__icon-tag pfo__row-fluid">
                        <?php echo $icon_tags_list;?>
                        </ul>
     				</div>
     			</div><!--end details-->
	  <!--hidden pet information-->
	  <div class="picture-item__more-details" style="display:none">

			<div class="my-pet-info-tags">
			<?php echo '<span>'.$foster_type.'</span>';?>
            <?php echo '<span>'.$foster_age.'</span>';?>
            <?php echo '<span>'.$foster_size.'</span>';?>
            <?php echo '<span>'.$foster_gender.'</span>';?>
            </div>
            <div class="my-pet-icon-tags">
				<?php echo $icon_tags_list;?>
            </div>
			<div class="my-pet-description"><?php the_content();?></div>
				<div class="my-pet-photos">
                <?php if ($foster_extra_image1=='' && $foster_extra_image2==''){//if no extra images were uploaded, just use main image
					echo the_post_thumbnail('medium');
					  }
					 else{ 
            		//if both extra images exists, get attachment ids for all attachments images to post and display//?>
                     <ul id="image_slider">
                             <?php
							$fosterme_attachments = get_attached_media( 'image', $post->ID );
							foreach($fosterme_attachments as $fosterme_attachment) {
    						//$fosterme_img_full = wp_get_attachment_url($fosterme_attachment->ID);
    						$fosterme_img = wp_get_attachment_image_src($fosterme_attachment->ID, 'medium');
    						if($fosterme_img !== false) {
							?>
						<li><img src="<?php echo $fosterme_img[0]; ?>" /></li>
						<?php
   							}
						}
						?>
             		</ul>
                	<span class="nvgt icoFoster-previous" id="prev"></span>
					<span class="nvgt icoFoster-next" id="next"></span>
					<?php } ?>
                </div>
			</div>
            </div><!--end inner-->
            </div><!--end picture item-->
	
			<?php endwhile; ?>
            <div class="pfo__span1 pfo__m-span1 shuffle__sizer"></div>
    </div><!--end grid-->
          </div><!--end container icons-->
  </div><!--end container icons-->
</div><!--end fosterme container-->
</div><!--end main content-->
</div><!--end main container-->
    <!-------------------END FOSTER ME!------------------------->
     </div><!--end page-->
     <?php echo'<script type="text/javascript" src="' .plugins_url("js/homepage.js", __FILE__ ).'"></script>';?>

<?php get_footer(); ?>