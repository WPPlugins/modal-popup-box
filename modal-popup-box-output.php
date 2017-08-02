<?php
// get post details
$modal_popup_box_id = $post_id['id'];
$all_modal_popup_box = array(  'p' => $modal_popup_box_id, 'post_type' => 'modalpopupbox', 'orderby' => 'ASC');
$loop = new WP_Query( $all_modal_popup_box );
while ( $loop->have_posts() ) : $loop->the_post();
?>

	<div class="md-modal <?php if($mpb_show_modal == "onload") echo "md-show"; ?> <?php echo $mpb_animation_effect_open_btn; ?>" id="modal-<?php echo $modal_popup_box_id; ?>">
		<div class="md-content">
			<h3 class="mbox-title text-center"><?php if($modal_title = get_the_title()) echo $modal_title; else echo "Modal Tital Here"; ?></h3>
			<div>
				<div>
					<?php
					$modal_content = get_the_content(); 
					if(empty($modal_content)) {
						echo " <p style='font-weight: bold;' >Modal content is empty. This is sample content. You can change it anytime. Simply update your shortcode content to display here.</p>
						<ul>
						<li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
						</ul>";
					} else {
						//Modal content shortcode trick--> do_shortcode();
					echo do_shortcode( $modal_content );
					}
					?>
				</div>
				<div class="btn-default  btn-lg text-center md-close">Close me!</div>			
			</div>			
		</div>
	</div>
	
	<!--shortcode button-->
	<?php if($mpb_show_modal == "onclick") { ?>
	<div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 mpb-shotcode-buttons">	
		<div class="md-trigger md-setperspective btn-bg-<?php echo $modal_popup_box_id; ?> <?php echo $mpb_main_button_size; ?> text-center" style="margin:2px;" data-modal="modal-<?php echo $modal_popup_box_id; ?>"><?php echo $mpb_main_button_text; ?></div><br>
	</div>
	<?php } ?>
	
	<!-- the overlay element -->	
	<div class="md-overlay"></div>
<?php
endwhile;
wp_reset_query();
?>
<script>
/**
 * modalEffects.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
var ModalEffects = (function() {

	function init() {

		var overlay = document.querySelector( '.md-overlay' );

		[].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {

			var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
				close = modal.querySelector( '.md-close' );

			function removeModal( hasPerspective ) {
				classie.remove( modal, 'md-show' );

				if( hasPerspective ) {
					classie.remove( document.documentElement, 'md-perspective' );
				}
			}

			function removeModalHandler() {
				removeModal( classie.has( el, 'md-setperspective' ) ); 
			}

			el.addEventListener( 'click', function( ev ) {
				classie.add( modal, 'md-show' );
				overlay.removeEventListener( 'click', removeModalHandler );
				overlay.addEventListener( 'click', removeModalHandler );

				if( classie.has( el, 'md-setperspective' ) ) {
					setTimeout( function() {
						classie.add( document.documentElement, 'md-perspective' );
					}, 25 );
				}
			});

			close.addEventListener( 'click', function( ev ) {
				ev.stopPropagation();
				removeModalHandler();
			});

		} );

	}
	init();
})();

// on page load modal close script

// close modal when click on overlay
jQuery(".md-overlay").click(function() {
	jQuery(".md-modal").removeClass("md-show");
	jQuery("html").removeClass("md-perspective");
});

// close modal when click on modal close button
jQuery(".md-close").click(function() {
	jQuery(".md-modal").removeClass("md-show");
	jQuery("html").removeClass("md-perspective");
});
</script>