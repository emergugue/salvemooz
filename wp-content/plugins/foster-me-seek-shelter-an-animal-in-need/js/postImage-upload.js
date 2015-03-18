/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
	//check to see if remove links are visible are not
	if ($(".foster_extra_image_src1").attr("src")!=""){
	$(".foster_delete_extra_image1").show();
	}
	if ($(".foster_extra_image_src2").attr("src")!=""){
	$(".foster_delete_extra_image2").show();
	}
	//if click on remove image
	$(".foster_delete_extra_image1").click(function(){
	$("#foster_extra_image1").val("");
	$(".foster_extra_image_src1").attr("src","");
	$(".foster_delete_extra_image1").hide();
});
$(".foster_delete_extra_image2").click(function(){
	$("#foster_extra_image2").val("");
	$(".foster_extra_image_src2").attr("src","");
	$(".foster_delete_extra_image2").hide();
});
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('.meta-button').click(function(e){
		window.currentImageMetaBtn=this;
		
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            //title: meta_image.title,
            //button: { text:  meta-image.button },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
			 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 			
            // Sends the attachment URL to our custom image input field.
            $(window.currentImageMetaBtn).parent().find("input:first").val(media_attachment.url);
			//console.log($(window.currentImageMetaBtn).prev());
			$(window.currentImageMetaBtn).parent().find("img").attr('src',media_attachment.url);
			//show delete img link
			$(window.currentImageMetaBtn).parent().find("a").show();
			
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
});