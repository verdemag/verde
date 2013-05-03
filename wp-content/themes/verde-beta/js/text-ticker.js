jQuery(document).ready(function() {
    tickTicker();
    setInterval(tickTicker, 4000);
});

var CurrentTicker = -1; // Do this without a Global! Look for a fix!
function tickTicker() {

    var duration = 750;
    var tickerText = new Array();
    tickerText[0] = "Quote from a Paly Student";
    tickerText[1] = "Another interesting quote";
    tickerText[2] = "Quotes can be very large in size. You have this entire bar to work with. If need be, it can even be bigger.";
    tickerText[3] = "The Issuu widget causes some lag in scrolling. So here is the solution";
    tickerText[4] = "Solution to previous Ticker comment: Hide issuu widget and display only if switched to the news section";
    tickerText[5] = "This way when flying by the news section the issuu widget isn't rendered, which means less lag";
    tickerText[6] = "That, or the scrolling effect could be removed entirely, but it's nice (esp. how the entire verde is one page now)";

    //    jQuery.getJSON(url, function(data) {
    // fade out old ticker
    // fade in new ticker in data.msg
    //	});
    jQuery(".tickerText").fadeTo(duration / 2, 0, function () {
	jQuery(".tickerText").html(tickerText[CurrentTicker%7]);
    });
    jQuery(".tickerText").fadeTo(duration / 2, 1);
    CurrentTicker++;

    // Cutting duration in half because it is defined as duration of the animation.
    // Animation consists of two fadeTos (fade in, fade out) so each needs to be 1/2 length.
}
