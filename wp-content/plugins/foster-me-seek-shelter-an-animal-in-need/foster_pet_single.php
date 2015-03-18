<?php
/**
 * The Template for displaying all foster single posts.
 *
 * @package sparkling
 */

get_header(); ?>
<?php
////GRAB THE VARS////
global $pet_foster_options;
//show mustbe options?
$display_mustbeOps = $pet_foster_options['pfo_display_mustbeOps'];
if (!isset($display_mustbeOps)){$display_mustbeOps='on';}
//show special options?
$display_specialOps = $pet_foster_options['pfo_display_specialOps'];
if (!isset($display_specialOps)){$display_specialOps='on';}
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
		<?php ////POST VARS////
		$custom = get_post_custom($post->ID);//required
		$foster_urgency = get_post_meta($post->ID, 'foster_urgency', true);
		$foster_extra_image1 = $custom["foster_extra_image1"][0];
		$foster_extra_image2 = $custom["foster_extra_image2"][0];
		//tags
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
		$foster_trait_kid_friendly = get_post_meta($post->ID, 'foster_trait_kid_friendly', true);?>
        <?PHP //////START TAG ICONS////
		$icon_tags_list='';
/*SICK*/
if ($foster_special_sick == 'on' && $display_specialOps == 'on'){
	$foster_special_sick='Sick';$icon_tags_list .='<li class="pfo__span2"><span class="icoFoster-sick foster-icon-tag" title="Sick"></span><span class="textFoster-sick foster-tag-text">Sick</span></li>';}
	else{$foster_special_sick='';}
/*INJURED*/
if ($foster_special_injured == 'on' && $display_specialOps == 'on'){
	$foster_special_injured='Injured';$icon_tags_list .='<li class="pfo__span2"><span  class="icoFoster-hurt foster-icon-tag" title="Injured"></span><span class="textFoster-injured foster-tag-text">Injured</span></li>';}
	else{$foster_special_injured='';}
/*STRESSED*/
if ($foster_special_stressed == 'on' && $display_specialOps == 'on'){
	$foster_special_stressed='Stressed';$icon_tags_list .='<li class="pfo__span2"><span  class="icoFoster-stressed foster-icon-tag" title="Stressed"></span><span class="textFoster-stressed foster-tag-text">Stressed</span></li>';}
	else{$foster_special_stressed='';}
/*MATERNITY*/
if ($foster_special_maternity == 'on' && $display_specialOps == 'on'){
	$foster_special_maternity='Maternity';$icon_tags_list .='<li class="pfo__span2"><span  class="icoFoster-maternity foster-icon-tag" title="Maternity"></span><span class="textFoster-maternity foster-tag-text">Maternity</span></li>';}
	else{$foster_special_maternity='';}
/*DOG FRIENDLY*/
if ($foster_trait_dog_friendly == 'on' && $display_mustbeOps == 'on'){
	$foster_trait_dog_friendly = 'Dog Friendly';$icon_tags_list .='<li class="pfo__span2 foster-friendly-icon"><span  class="icoFoster-dog-friendly foster-icon-tag" title="Dog Friendly"></span><span class="textFoster-dog-friendly foster-tag-text">Dog Friendly</span></li>';}
	else{$foster_trait_dog_friendly='';}
/*CAT FRIENDLY*/
if ($foster_trait_cat_friendly == 'on' && $display_mustbeOps == 'on'){
	$foster_trait_cat_friendly = 'Cat Friendly';$icon_tags_list .='<li class="pfo__span2 foster-friendly-icon"><span  class="icoFoster-cat-friendly foster-icon-tag" title="Cat Friendly"></span><span class="textFoster-cat-friendly foster-tag-text">Cat Friendly</span></li>';}
	else {$foster_trait_cat_friendly='';}
/*KID FRIENDLY*/
if ($foster_trait_kid_friendly == 'on' && $display_mustbeOps == 'on'){
	$foster_trait_kid_friendly = 'Kid Friendly';$icon_tags_list .='<li class="pfo__span2 foster-friendly-icon"><span  class="icoFoster-kid-friendly foster-icon-tag" title="Kid Friendly"></span><span class="textFoster-kid-friendly foster-tag-text">Kid Friendly</span></li>';}
	else {$foster_trait_kid_friendly='';}
//////END TAG ICONS////?>
<?php echo '<style>
#fosterme_container #pet-info span{background-color: ' . $pet_foster_options['pfo_tags_popup'] . ';color:' . $pet_foster_options['pfo_textontags_popup'] . '}
#fosterme_container .entry-title{color: ' . $pet_foster_options['pfo_pettitle_popup'] . ';}
#fosterme_container .main-foster-color span{color: ' . $pet_foster_options['pfo_fosterbtntext_popup'] .'; background-color: ' . $pet_foster_options['pfo_fosterbtnbg_popup'] .';}
</style>';
?>
<article class="post hentry">
	<div class="fosterme_single_pet" id="fosterme_container">
    <div class="pfo__row-fluid">
    <div class="fosterme_single_left">
    		<!--PHOTOS-->
			<div id="pet-multiphotos">
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
            <!--PET DATA-->
            <div class="foster-popup-data">
      		
            <!--Date Added-->
    		<div id="pet-date-added"><strong>Added: </strong><?php echo the_time( get_option( 'date_format' ));?></div>
        	<!--Urgency-->
            <?php if($foster_urgency=="1-High Priority"){?>
    		<div id="pet-urgency">High Priority<span class="icoFoster-urgent"></span></div>
            <?php }?>
       		 </div>
             
               
            <?php //FOSTER ME BTN//?>
            <div id="pet-foster-btn" class="main-foster-color pfo__hoverme btn-med" style="margin-top:10px;"><span><span class="icoFoster-foster"></span>Foster me</span></div>
             <?php //VIEW ALL FOSTERS BTN//?>
        	<a id="fosterme_single_viewall" href="<?php echo get_post_type_archive_link('fosters'); ?>">View all fosters</a>
            </div><!--end span3-->
            <div class="fosterme_single_right">
        	<h1 class="entry-title" style="margin:0 0 5px 0;padding:0;"><?php the_title();?></h1>
            <p style="font-weight: bold;font-style: italic;margin:0 0 10px 0;">Needs a foster home</p>
            <div id="pet-info">
			<?php echo '<span>'.$foster_type.'</span>';?>
            <?php echo '<span>'.$foster_age.'</span>';?>
            <?php echo '<span>'.$foster_size.'</span>';?>
            <?php echo '<span>'.$foster_gender.'</span>';?>
            </div>
            	
               <div id="pet-icons">
				<?php echo $icon_tags_list;?>
            </div>
             <hr/>
     				<div class="fosterme_single_desc">
                    <strong>About <?php echo the_title();?></strong><br/>
                    <?php the_content(); ?>
                    </div>
               </div><!--span9-->
               
 
        <!--all popup bgs-->
        <div id="fosterme-popup-single" class="window-popup-single">
       <div id="indiepet-popup-topbtns" class="window-popup-topbtns">
     		<span class="icoFoster-close pfo__hoverme window-popup-close"></span>
   		</div>
               <div id="fosterme-popup-inner" class="pfo__row-fluid">
      	 <div class="fosterme-popup-left pfo__span6">
         	<h2>First time foster parent?</h2>
            <p>Welcome! You will need to fill out this application and be approved before you can foster <strong><span class="indiepet-popup-title"></span></strong>.</p>
            <a class="pfo__fosterformlink" href="<?php echo $pet_foster_options['pfo_fosterformpage_link'] . '?petname=' . get_the_title();?>">
            <div id="fosterformlink"  class="pfo__hoverme main-foster-color btn-lg">
            <span>Foster application</span>
            </div>
            </a>
       	 </div>
         <div class="fosterme-popup-right pfo__span6">
         	<h2>Fostered with us already?</h2>
             <p>Great! We appreciate your continued help.  Please let us know you are have an interest in fostering <strong><span class="indiepet-popup-title"></span></strong>.</p>
             <a class="pfo__fosterformlink" href="<?php echo $pet_foster_options['pfo_contactformpage_link'] . '?petname=' . get_the_title();?>">
             <div id="fostercontactlink"  class="pfo__hoverme main-foster-color btn-lg">
             <span>Contact us</span>
             </div>
             </a>
       	 </div>
         </div>
       </div>
       </div><!--end row-->
       </div><!--end foster pet-->
       </article>
		<?php endwhile; // end of the loop. ?>
       
         </div>

		</div><!-- #main -->
	</div><!-- #primary -->
    <script type="text/javascript">
	jQuery(window).load(function() {
	//CLICK ON FOSTER ME BTN IN POPUP
	  jQuery('#pet-foster-btn').click(function(){
		  jQuery("#fosterme-popup-single").show();
	  });
		//CLOSE   
    jQuery(".window-popup-close").click(function(){
      jQuery("#fosterme-popup-single").hide();  
    });
	});
	jQuery("#pet-icons .foster-friendly-icon:first").css("clear","both");
	/*FOR IMAGE SLIDER*/
	var ul;
var li_items;
var imageNumber;
var imageWidth;
var prev, next;
var currentPostion = 0;
var currentImage = 0;
function init(){
	ul = document.getElementById('image_slider');
	li_items = ul.children;
	imageNumber = li_items.length;
	imageWidth = li_items[0].children[0].clientWidth;
	ul.style.width = parseInt(imageWidth * imageNumber) + 'px';
	prev = document.getElementById("prev");
	next = document.getElementById("next");
	//.onclike = slide(-1) will be fired when onload;
	
	//hide arrows if only one image
	if (imageNumber<=1){
	jQuery("#prev").hide();
	jQuery("#next").hide();
	}
	else{
		jQuery("#prev").show();
	jQuery("#next").show();
		prev.onclick = function(){ onClickPrev();};
	next.onclick = function(){ onClickNext();};
	}
}

function animate(opts){
	var start = new Date;
	var id = setInterval(function(){
		var timePassed = new Date - start;
		var progress = timePassed / opts.duration;
		if (progress > 1){
			progress = 1;
		}
		var delta = opts.delta(progress);
		opts.step(delta);
		if (progress == 1){
			clearInterval(id);
			opts.callback();
		}
	}, opts.delay || 17);
	//return id;
}

function slideTo(imageToGo){
	var direction;
	var numOfImageToGo = Math.abs(imageToGo - currentImage);
	// slide toward left

	direction = currentImage > imageToGo ? 1 : -1;
	currentPostion = -1 * currentImage * imageWidth;
	var opts = {
		duration:200,
		delta:function(p){return p;},
		step:function(delta){
			ul.style.left = parseInt(currentPostion + direction * delta * imageWidth * numOfImageToGo) + 'px';
		},
		callback:function(){currentImage = imageToGo;}	
	};
	animate(opts);
}

function onClickPrev(){
	if (currentImage == 0){
		slideTo(imageNumber - 1);
	} 		
	else{
		slideTo(currentImage - 1);
	}		
}

function onClickNext(){
	if (currentImage == imageNumber - 1){
		slideTo(0);
	}		
	else{
		slideTo(currentImage + 1);
	}		
}
init();
/*END SLIDER*/
	</script>

<?php get_footer(); ?>