var body, nav, navTop, footer, pages, selected, toSelect, mask, wrapper, zoomed, ver, History, jQuery, template_dir;

var LOADER = '<h1>Loading</h1><div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div>';

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

	jQuery('.navLink').click(navLinkClick);

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

	toSelect = jQuery('.select');
	if(toSelect.length != 0) {
		selected = toSelect;
		selected.removeClass('select');
	} else {
		selected = jQuery('#home');
	}

	mask.css('min-height', jQuery(window).height() - mask.offset().top);
});

jQuery(window).load(function() {
	var navLink = jQuery('nav .navLink[data-target="'+selected.attr('id')+'"]');
	if(navLink.length > 0)
		highlightItem(navLink);
	wrapper.css({top:-selected.position().top, left:-selected.position().left});
	resizeMask();

	socialLinks();

	jQuery('#loader').hide();
});

jQuery(window).on('statechange', function() {
	var stateData = History.getState().data;
	if (!jQuery.isEmptyObject(stateData)) {
		switchToItem(stateData.post);
	} else {
		switchToItem('home');
	}
});

function navLinkClick(event) {
	event.preventDefault();
	var element = jQuery(event.currentTarget);
	var targetID = element.data('target');
	var url;

	if(!element.hasClass('disabled')) {
		jQuery('.navLink.disabled').removeClass('disabled');
		jQuery('.navLink[data-target="' + targetID + '"]').addClass('disabled');
		var state = { post: targetID };
		url = ver ? '/?ver='+ver+'&' : '?';
		if(targetID == 'home')
			url = ver ? '/?ver='+ver : '/';
		else if(targetID == 'about')
			url += 'page=about';
		else if(jQuery('#'+targetID).hasClass('category'))
			url += 'page=' + targetID;
		else
			url += 'post=' + targetID;

		History.pushState(state, 'Verde', url);

		switchToItem(targetID);
	}
}

function highlightItem(item) {
	jQuery('.navLink.selected').removeClass('selected');
	item.addClass('selected');
}

function resizeMask() {
	mask.animate({ height:selected.height() + 100 }, 50);
}

function switchToItem(name) {
	highlightItem(jQuery('nav .navLink[data-target="'+name+'"]'));

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

	var url = template_dir + '/load-post.php?post=' + name;
	jQuery.ajax({
		url: url,
		success: function(data) {
			item.html(data);
			socialLinks();
		},
		error: function(data, status) {
			item.html("error " + status + "\n" + data);
		}
	});
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
