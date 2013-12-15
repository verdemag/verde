/*global ver, History, jQuery, template_dir */
var body, nav, navTop, footer, pages, selected, toSelect, mask, wrapper, zoomed, navnames, navitems, pageWrap;

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
	zoomed = false;

	$('#logo').click(function(event) {
		var state = { post: 'home', type: 'home' };
		var url = '/';
		History.pushState(state, 'Verde', url);
	});

	$('.navLink').click(navLinkClick);

	$(window).scroll(function(event) {
		if($(window).scrollTop() - body.offset().top >= navTop - 5) {
			$(".navBar, .ticker").addClass("fixed");
		} else {
			$(".navBar, .ticker").removeClass("fixed");
		}
	});

	$('#zoombutton').click(function(event) {
		console.log('zoomed called....');
		if(!zoomed) {
			$('main > section').show();
			wrapper.stop().animate({zoom:1/6}, 500);
			mask.stop().animate({height:wrapper.height()}, 500);
			zoomed = true;
		} else {
			$('main > section').hide();
			selected.show();
			wrapper.stop().animate({left: -selected.position().left}, {
				duration: 500,
				queue: false
			});
			wrapper.animate({zoom:1}, {
				duration: 500,
				complete: function() {
				wrapper.css('left', -selected.position().left);
				resizeMask();
				},
				queue: false
			});
			zoomed = false;
		}
	});

	selected = $('main > section');
});

$(window).load(function() {
	navnames = [];
	navitems = {};
	$('nav >>> .navLink').each(function() {
		var itemname = this.id.slice(0, -4);
		var i = navnames.push(itemname) - 1;
		if(selected.attr('id') == itemname) {
			navitems[i] = selected;
		}
	});

	highlightItem($('#'+selected.attr('id')+'link'));

	resizeMask();

	socialLinks();

	$('body > .loader').remove();
});

$(window).on('statechange', function(evt) {
	evt.preventDefault();
	var stateData = History.getState().data;
	if (!$.isEmptyObject(stateData)) {
		switchToItem(stateData.post, stateData.type);
	} else {
		switchToItem('home', 'home');
	}
});

function navLinkClick(event) {
	event.preventDefault();
	var element = $(event.currentTarget);
	var targetID = element.data('target');
	var url;

	if(!element.hasClass('disabled')) {
		$('.navLink.disabled').removeClass('disabled');
		$('.navLink[data-target="' + targetID + '"]').addClass('disabled');

		var name = targetID.split(':');
		var type = 'post';
		if(name.length > 1) {
			type = name[0];
			name = name[1];
		} else {
			if(name == 'home') type = 'home';
			name = name[0];
		}

		var state = { post: name, type: type };
		url = ver ? '/?ver='+ver+'&' : '/?';
		switch(type) {
		case 'home':
			url = ver ? '/?ver='+ver : '/';
			break;
		case 'page':
			url += 'page='+name;
			break;
		case 'cat':
			url += 'cat=' + name;
			break;
		case 'post':
		default:
			url += 'post=' + targetID;
			break;
		}

		History.pushState(state, 'Verde', url);
	}
}

function highlightItem(item) {
	$('.navLink.selected').removeClass('selected');
	item.addClass('selected');
}

function resizeMask() {
	mask.height(selected.height());
	pageWrap.height(mask.height() + 327);
	pageWrap.css('min-height', '100%');
}

function switchToItem(name, type) {
	var linkSel = '#'+name+'link';
	highlightItem($(linkSel));

	var old = $(selected);

	if($('#' + name).length == 0) getItem(name, type);

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
		                 if(!zoomed) old.hide();
		                 wrapper.css('left', -selected.position().left);
	                 }
	                });
}

function getItem(name, type) {
	wrapper.width(wrapper.width() + 960);

	var url = template_dir + '/templates';
	var item;
	switch(type) {
	case 'home':
		item = $('<section class="page" id="home"></section>');
		url += '/home.php?ver=' + ver;
		break;
	case 'page':
		item = $('<section class="page" id="'+name+'"></section>');
		url += '/page.php?ver=' + ver + '&page=' + name;
		break;
	case 'cat':
		item = $('<section class="category" id="'+name+'"></section>');
		url += '/category.php?ver=' + ver + '&cat=' + name;
		break;
	case 'post':
	default:
		item = $('<section class="post" id="'+name+'"></section>');
		url += '/post.php?ver=' + ver + '&post=' + name;
		break;
	}
	item.html('<div class="loader"></div>');
	var loc = navnames.indexOf(name);
	console.log(loc);
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

	item.load(url, function() {
		$('.navLink').click(navLinkClick);
		socialLinks();
		item.children('img, script, frame, iframe').load(resizeMask);
	});
}

function socialLinks() {
	$('.social.icon-fb').click(function(evt) {
		evt.preventDefault();
		window.open(evt.target.href, 'Share on FB', 'width=618,height=325');
	});
	$('.social.icon-twitter').click(function(evt) {
		evt.preventDefault();
		window.open(evt.target.href, 'Share on Twitter', 'width=465,height=275');
	});
	$('.social.icon-gplus').click(function(evt) {
		evt.preventDefault();
		window.open(evt.target.href, 'Share on GPlus', 'width=500,height=375');
	});
}
