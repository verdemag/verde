var ticker;

jQuery(document).ready(function() {
	ticker = jQuery('.ticker');
	ticker.count = -1;

	tickerTop = ticker.offset().top;
	ticker.css('top', tickerTop);
	ticker.css('position', 'absolute');

	tickticker();
	setInterval(tickticker, 5000);
});

function tickticker() {
	var duration = 750;

	//    jQuery.getJSON(url, function(data) {
	// fade out old ticker
	// fade in new ticker in data.msg
	//	});
	ticker.animate({ color: 'lightgrey' });
	ticker.children().fadeTo(duration / 2, 0, function() {
		ticker.children().html(tickerText[ticker.count%7]);
		ticker.children().fadeTo(duration / 2, 1);
	});

	ticker.count++;

	// Cutting duration in half because it is defined as duration of the animation.
	// Animation consists of two fadeTos (fade in, fade out) so each needs to be 1/2 length.
}
