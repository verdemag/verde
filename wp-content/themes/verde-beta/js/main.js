var LOADER = '<div id="loader"><h1>Loading</h1><div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div></div>';

var ticker, body, footer, pages, selected, mask, wrapper, zoomed;

jQuery(document).ready(function() {
	ticker = jQuery('.ticker');
	ticker.count = -1;
	body = jQuery('body');
	footer = jQuery('footer');
	pages = jQuery('.page');
	selected = pages.first();
	mask = jQuery('#mask');
	nav = jQuery('nav');
	navTop = nav.offset().top;
	wrapper = jQuery('main');
	zoomed = true;

	jQuery('#logo').click(function(event) {
		var state = { post: 'home' };
		var url = '/';
		console.log('pushing state name: home')
		History.pushState(state, null, url);

		switchToItem('home');
	});

	jQuery('.navLink').click(function(event) {
		event.preventDefault();
		var id = event.target.id;
		var targetID = id.substring(0, id.length - 4);

		var state = { post: targetID };
		if(jQuery('#'+targetID).hasClass('category'))
			var url = '?page=' + targetID;
		else
			var url = '?post=' + targetID;
		console.log('pushing state name: ' + targetID)
		History.pushState(state, null, url);

		switchToItem(targetID);
	});

	jQuery(window).scroll(function(event) {
		if(jQuery(window).scrollTop() - body.offset().top >= navTop - 5) {
			jQuery(".navBar").addClass("fixed");
		} else {
			jQuery(".navBar").removeClass("fixed");
		}
	});

	tickerTop = ticker.offset().top;
	ticker.css('top', tickerTop);
	ticker.css('position', 'absolute');

	footer.hover(function(){
		footer.stop().animate({height:footer.totalHeight}, 500);
	},function(){
		footer.stop().animate({height:footer.collapseHeight}, 500);
	});

	jQuery('#zoombutton').click(function(event) {
		if(zoomed) {
			wrapper.stop().animate({zoom:1/6}, 500);
			mask.stop().animate({height:wrapper.height()}, 500);
			zoomed = false;
		} else {
			wrapper.stop().animate({zoom:1}, 500);
			resizeMask();
			zoomed = true;
		}
	});

	tickticker();
	setInterval(tickticker, 5000);

	footer.collapseHeight = footer.find('.row').first().height();
	footer.css('height','auto');
	footer.totalHeight = footer.height();
	footer.css('height', footer.collapseHeight);

	window.toSelect = jQuery('.select');
	if(toSelect.length != 0) {
		selected = toSelect;
		selected.removeClass('select');
	}
});

jQuery(window).load(function() {
	highlightItem(jQuery('#' + selected.attr('id') + 'link'));
	wrapper.css({top:-selected.position().top, left:-selected.position().left});

	socialLinks();

	jQuery('#loader').hide();
});

jQuery(window).on('statechange', function() {
	state = History.getState();
	console.log('loading ' + state.post);
	if (state != null) {
		switchToItem(state.post);
	}
});

function tickticker() {

	var duration = 750;
	var tickerText = new Array();
	tickerText[0] = "Quote from a Paly Student";
	tickerText[1] = "Another interesting quote";
	tickerText[2] = "Quotes can be very large in size. You have this entire bar to work with. If need be, it can even be bigger.";
	tickerText[3] = "The Issuu widget causes some lag in scrolling. So here is the solution";
	tickerText[4] = "Solution to previous ticker comment: Hide issuu widget and display only if switched to the news section";
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
	mask.animate({ height:selected.height() + 50 }, 50);
}

function switchToItem(name) {
	var linkID = name + 'link';
	highlightItem(jQuery('#' + linkID));

	if(jQuery('#' + name).length == 0) {
		getItem(name);
	}
	selected = jQuery('#' + name);

	wrapper.stop().animate({top:-selected.position().top, left:-selected.position().left}, 500);
	resizeMask();
}

function getItem(name) {
	wrapper.width(wrapper.width() + 960);
	wrapper.append('<section class="post" id="' + name + '"></section>');
	var item = jQuery('#' + name);
	item.html(LOADER);

	var ajax = getRequest();
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			if(ajax.status == 200) {
				item.html(ajax.responseText);
				socialLinks();
			} else {
				item.html("error " + ajax.status + "\n" + ajax.responseText);
			}
			resizeMask();
		}
	};
	ajax.open("GET", template_dir + "/load-post.php?post=" + name, true);
	ajax.send(null);
}

function socialLinks() {
	jQuery('.fblink').click(function(evt) {
		evt.preventDefault();
		var popup = open(evt.target.href,
		                    'Share Verde',
		                    'location=0,toolbar=0,status=0,resizable=1,width=626,height=436');
		if (window.focus) {popup.focus();}
	});
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

