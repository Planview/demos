$(document).ready(function(){ 
	$(window).on('resize', function(e) {
		$('.limelight-video-respond').each(function () {
			var $wrapper = $(this),
			$video = $(this).find('*[width]'),
			controlsHeight = $(this).data('controlsHeight') || 0,
			controlsWidth = $(this).data('controlsWidth') || 0,
			newHeight,
			newWidth;

			// See if we have the aspect ratio already
			if ( ! $wrapper.data('aspectRatio') ) {
				var aspectRatio = ( $video.attr('height') - controlsHeight ) / ( $video.attr('width') - controlsWidth );
				$wrapper.data('aspectRatio', aspectRatio );
			}

			newWidth = $wrapper.width();
			newHeight = (newWidth - controlsWidth) * $wrapper.data('aspectRatio') + controlsHeight;
	
			$video.attr('height', newHeight);
			$video.attr('width', newWidth)
		});
	});
	$(window).trigger('resize');
});