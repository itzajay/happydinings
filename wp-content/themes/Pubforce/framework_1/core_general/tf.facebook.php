<?php

function tf_enqueue_fb_code_in_footer() {
	global $_enqueue_fb_code_in_footer;
	
	if ( !empty( $_enqueue_fb_code_in_footer ) )
		return;
	
	$_enqueue_fb_code_in_footer = true;
	
	?>
	<div id="fb-root"></div>
    <script type="text/javascript">
    	(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
        	if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<?php
}
