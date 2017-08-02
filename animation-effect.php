<div class="container-fluid">
	<p class="bg-title text-center"><?php _e('Loading Animation Effect Demo Preview', MPB_TXTDM); ?></p><br>
					
	<div class="col-md-12" >
		<div class="md-modal md-effect-1" id="modal-1">
			<div class="md-content">
				<h2 style="font-weight: bolder;" class="text-center" >Modal Dialog</h2>
				<div>
					<p style="font-weight: bolder;" >This is a modal window. You can do the following things with it:</p>
					<ul>
						<li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
						<li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
						<li><strong>Close:</strong> click on the button below to close the modal.</li>
					</ul>
					
					<div class="btn-default  btn-lg text-center md-close">Close me!</div>
				</div>
			</div>
		</div>
		
		<div class="md-modal md-effect-2" id="modal-2">
			<div class="md-content">
				<h2 style="font-weight: bolder;" class="text-center" >Modal Dialog</h2>
				<div>
					<p style="font-weight: bolder;" >This is a modal window. You can do the following things with it:</p>
					<ul>
						<li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
						<li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
						<li><strong>Close:</strong> click on the button below to close the modal.</li>
					</ul>
					<div class="btn-default  btn-lg text-center md-close">Close me!</div>
				</div>
			</div>
		</div>
		
			<div class="col-md-5 md-trigger my_btn btn-default btn-lg text-center"  data-modal="modal-1">Fade in &amp; Scale</div>
			<div class="col-md-5 md-trigger my_btn btn-default btn-lg text-center"  data-modal="modal-2">Slide in (right)</div>
			
		<div class="md-overlay"></div><!-- the overlay element -->
	</div>	
</div><!-- /container -->
<style>
.col-md-5 {
    margin: 50px !important;
}
.my_btn{
	background-color:#0073AA !important;
	color:#FFFFFF !important;
}
#poststuff .stuffbox > h3, #poststuff h2, #poststuff h3.hndle {
	font-size : 30px;
}
.container-fluid {
    padding-left: 0px !important;
    padding-right: 0px !important;
	padding-bottom: 10px !important;
}
.btn-default{
	cursor:pointer !important;
}
</style>