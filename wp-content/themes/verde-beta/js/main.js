jQuery(document).ready(function() {
	window.ticker = jQuery('.ticker');
	ticker.count = -1;
	window.footer = jQuery('footer');
	window.pages = jQuery('.page');
	window.selected = pages.first();
	window.mask = jQuery('#mask');
	window.wrapper = jQuery('main');
	window.zoomed= true;

	jQuery('#logo').click(function(event) {
		switchToItem('#home');
	});

	jQuery('.navLink').click(function(event) {
		event.preventDefault();
		var id = event.target.id;
		var targetID = id.substring(0, id.length - 4);

		switchToItem(targetID);
	});

	jQuery(window).scroll(function(event) {
		if(jQuery(window).scrollTop() - jQuery("body").offset().top >= 130) {
			jQuery(".navBar").addClass("fixed");
		} else {
			jQuery(".navBar").removeClass("fixed");
		}
	});

	footer.hover(function(){
		footer.stop().animate({height:footer.totalHeight}, 500);
	},function(){
		footer.stop().animate({height:footer.collapseHeight}, 500);
	});

	jQuery('#zoombutton').click(function(event) {
		if(zoomed) {
			wrapper.stop().animate({zoom:1/6}, 500);
			window.mask.stop().animate({height:window.wrapper.height()}, 500);
			zoomed = false;
		} else {
			wrapper.stop().animate({zoom:1}, 500);
			resizeMask();
			zoomed = true;
		}
	});

	resizeMask();

	tickTicker();
	setInterval(tickTicker, 5000);

	footer.collapseHeight = footer.find('.row').first().height();
	footer.css('height','auto');
	footer.totalHeight = footer.height();
	footer.css('height', footer.collapseHeight);

	var toSelect = jQuery('.select');
	if(toSelect.length != 0) {
		console.log(toSelect.attr('ID'));
		jQuery('.navLink.selected').removeClass('selected');
		selected = toSelect;
		selected.removeClass('select');
		wrapper.css({top:-toSelect.position().top, left:-toSelect.position().left+10});
		setTimeout(function(){mask.height(toSelect.height() + 50);}, 200);
	}
});


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
	ticker.animate({ color: 'lightgrey' });
	ticker.children().fadeTo(duration / 2, 0, function() {
		ticker.children().html(tickerText[ticker.count%7]);
		ticker.children().fadeTo(duration / 2, 1);
	});

	ticker.count++;

	// Cutting duration in half because it is defined as duration of the animation.
	// Animation consists of two fadeTos (fade in, fade out) so each needs to be 1/2 length.
}

function highlightItem(item) {
	jQuery('.navLink.selected').removeClass('selected');
	item.addClass('selected');
}

function resizeMask() {
	window.mask.animate({ height:window.selected.height() + 50 }, 50);
}

function switchToItem(name) {
	var linkID = name + 'link';
	highlightItem(jQuery('#' + linkID));

	if(jQuery('#' + name).length == 0) {
		getItem(name);
	}
	window.selected = jQuery('#' + name);

	window.wrapper.stop().animate({top:-selected.position().top, left:-selected.position().left}, 500);
	resizeMask();
}

function getItem(name) {
	window.wrapper.width(window.wrapper.width() + 960);
	window.wrapper.append('<div class="container_12 page" id="' + name + '"></div>');

	var ajax = getRequest();
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			jQuery('#' + name).html(ajax.responseText);
			resizeMask();
		}
	};
	ajax.open("GET", template_dir + "/load-post.php?post=" + name, true);
	ajax.send(null);
}

function getRequest() {
	var req = false;
	try{
		// most browsers
		req = new XMLHttpRequest();
	} catch (e){
		// IE
		try{
			req = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			// try an older version
			try{
				req = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				return false;
			}
		}
	}
	return req;
}
