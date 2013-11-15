var LOADER = '<h1>Loading</h1><div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div>';

var body, footer, pages, selected, mask, wrapper, zoomed;

jQuery(document).ready(function() {
	body = jQuery('body');
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
		History.pushState(state, 'Verde', url);

		switchToItem('home');
	});

	jQuery('.navLink').click(function(event) {
		event.preventDefault();
		var element = jQuery(event.currentTarget);
		var targetID = element.data('target');
		var url;

		if(!element.hasClass('disabled')) {
			jQuery('.navLink.disabled').removeClass('disabled');
			jQuery('.navLink[data-target="' + targetID + '"]').addClass('disabled');
			var state = { post: targetID };
			if(targetID == 'home')
				url = '/';
			else if(jQuery('#'+targetID).hasClass('category'))
				url = '?page=' + targetID;
			else
				url = '?post=' + targetID;

			History.pushState(state, 'Verde', url);

			switchToItem(targetID);
		}
	});

	jQuery(window).scroll(function(event) {
		if(jQuery(window).scrollTop() - body.offset().top >= navTop - 5) {
			jQuery(".navBar").addClass("fixed");
		} else {
			jQuery(".navBar").removeClass("fixed");
		}
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

	window.toSelect = jQuery('.select');
	if(toSelect.length != 0) {
		selected = toSelect;
		selected.removeClass('select');
	}

	mask.css('min-height', jQuery(window).height() - mask.offset().top);
});

jQuery(window).load(function() {
	var navLink = jQuery('#' + selected.attr('id') + 'link');
	if(navLink.length > 0)
		highlightItem(navLink);
	wrapper.css({top:-selected.position().top, left:-selected.position().left});
	resizeMask();

	socialLinks();

	jQuery('#loader').hide();
});

jQuery(window).on('statechange', function() {
	stateData = History.getState().data;
	if (!jQuery.isEmptyObject(stateData)) {
		switchToItem(stateData.post);
	} else {
		switchToItem('home');
	}
});

function highlightItem(item) {
	jQuery('.navLink.selected').removeClass('selected');
	item.addClass('selected');
}

function resizeMask() {
	mask.animate({ height:selected.height() + 100 }, 50);
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
	wrapper.append('<section class="post loading" id="'+name+'"></section>');
	var item = jQuery('#' + name);
	item.html(LOADER);

	var ajax = getRequest();
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			item.removeClass('loading');
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

