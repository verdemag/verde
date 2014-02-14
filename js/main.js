/*global ver, History, jQuery, template_dir */
var body, nav, navTop, footer, pages, selected, toSelect, mask, wrapper, navnames, navitems, pageWrap, ticker;

var $ = jQuery;

$(document).ready(function() {
	body = $('body');
	pages = $('.page');
	selected = pages.first();
	mask = $('#mask');
	nav = $('nav');
	navTop = nav.offset().top;
	wrapper = $('main');
	pageWrap = $('#wrapper');

	$('.navlink').click(navlinkClick);

	$(window).scroll(function(event) {
		if($(window).scrollTop() - body.offset().top >= navTop - 5) {
			$("#nav-placeholder").show();
			$("nav").addClass("fixed");
		} else {
			$("#nav-placeholder").hide();
			$("nav").removeClass("fixed");
		}
	});

	selected = $('main > section');
});

$(window).load(function() {
	navnames = [];
	navitems = {};
	$('nav >>> .navlink').each(function() {
		var itemname = this.id.slice(0, -4);
		var i = navnames.push(itemname) - 1;
		if(selected.attr('id') == itemname) {
			navitems[i] = selected;
		}
	});

	highlightItem($('#'+selected.attr('id')+'link'));

	socialLinks();

	$('body > .loader').remove();
});

$(window).on('statechange', function(evt) {
	evt.preventDefault();
	var stateData = History.getState().data;
	if (!$.isEmptyObject(stateData)) {
		switchToItem(stateData.url, stateData.post, stateData.type);
	} else {
		switchToItem('/', 'home', 'home');
	}
});

function navlinkClick(event) {
	event.preventDefault();
	var element = $(event.currentTarget);
	var targetID = element.data('target');
	var url = element.attr('href');

	if(!element.hasClass('disabled')) {
		$('.navlink.disabled').removeClass('disabled');
		$('.navlink[data-target="' + targetID + '"]').addClass('disabled');

		var name = targetID;
		var type = 'post';
		if(name == 'home') type = 'home';
		else {
			name = name.split(':');
			type = name[0];
			name = name[1];
		}

		var state = { url: url, post: name, type: type };

		History.pushState(state, 'Verde', url);
	}
}

function highlightItem(item) {
	$('.navlink.selected').removeClass('selected');
	item.addClass('selected');
}

function resizeMask() {
	mask.height(selected.height());
	pageWrap.height(mask.height() + 327);
	pageWrap.css('min-height', '100%');
}

function switchToItem(url, name, type) {
	mask.height(wrapper.height());
	pageWrap.height(mask.height() + 327);
	pageWrap.css('min-height', '100%');

	highlightItem($('#'+name+'link'));

	var old = $(selected);

	if($('#' + name).length == 0) getItem(url, name, type);

	selected = $('#' + name);
	if(selected.length == 0) {
		selected = old;
		return;
	}
	selected.show();
	wrapper.css('left', -old.position().left);

	$('html, body').stop().animate({scrollTop:0},{duration:500, queue:false});
	wrapper.stop().animate({left:-selected.position().left},
	                       {duration:500, queue:false,
	                        complete: function() {
		                        resizeMask();
		                        wrapper.css('left', -selected.position().left);
	                        }
	                       });
}

function getItem(url, name, type) {
	wrapper.width(wrapper.width() + 960);

	var item;
	switch(type) {
	case 'home':
		item = $('<section class="page" id="home"></section>');
		break;
	case 'page':
		item = $('<section class="page" id="'+name+'"></section>');
		break;
	case 'cat':
		item = $('<section class="category" id="'+name+'"></section>');
		break;
	case 'post':
	default:
		item = $('<section class="post" id="'+name+'"></section>');
		break;
	}
	item.html('<div class="loader"></div>');
	var loc = navnames.indexOf(name);
	if(loc != -1) {
		var beforeItem;
		for(var i = loc; i >= 0; i--) {
			if(navitems[i]) {
				beforeItem = navitems[i];
				break;
			}
		}
		if(beforeItem) {
			beforeItem.after(item);
		} else {
			wrapper.prepend(item);
		}
		navitems[loc] = item;
	} else {
		wrapper.append(item);
	}

	item.load(url, {ver: ver}, function() {
		$('.navlink').click(navlinkClick);
		socialLinks();
		item.children('img').load(resizeMask);
	});
}

function socialLinks() {
	$('.social').click(function(evt) {
		evt.preventDefault();
		window.open(evt.target.href, 'Share on FB', 'width=700,height=325');
	});
}
