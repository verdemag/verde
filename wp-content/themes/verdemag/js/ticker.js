/*global ticker, tickerText, navlinkClick, jQuery, setInterval */

jQuery(document).ready(function() {
	ticker = jQuery('#ticker');
	ticker.count = 0;

	tickticker();
	setInterval(tickticker, 5000);
});

function tickticker() {
	var duration = 750;

	ticker.animate({ color: 'lightgrey' });
	ticker.children().fadeTo(duration / 2, 0, function() {
		ticker.children().html(tickerText[ticker.count]);
		ticker.find('.navlink').click(navlinkClick);
		ticker.children().fadeTo(duration / 2, 1);
	});

	ticker.count = (ticker.count + 1) % tickerText.length;
}
