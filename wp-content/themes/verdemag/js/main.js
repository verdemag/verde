var body, nav, navTop, footer, pages, selected, toSelect, mask, wrapper, zoomed, ver, History, jQuery, template_dir;

var $ = jQuery;

$(document).ready(function() {
	body = $('body');
	pages = $('.page');
	selected = pages.first();
	mask = $('#mask');
	nav = $('nav');
	navTop = nav.offset().top;
	wrapper = $('main');
	zoomed = false;

	$('#logo').click(function(event) {
		var state = { post: 'home' };
		var url = '/';
		History.pushState(state, 'Verde', url);
	});

	$('.navLink').click(navLinkClick);

	$(window).scroll(function(event) {
		if($(window).scrollTop() - body.offset().top >= navTop - 5) {
			$(".navBar").addClass("fixed");
		} else {
			$(".navBar").removeClass("fixed");
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
			wrapper.stop().animate({zoom:1}, 500);
			resizeMask();
			zoomed = false;
		}
	});

	selected = $('main > section');
	mask.css('min-height', $(window).height() - mask.offset().top);
});

$(window).load(function() {
	highlightItem($('#'+selected.attr('id')+'link'));
	resizeMask();

	socialLinks();

	$('#loader').hide();
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
	mask.animate({ height:selected.height() + 100 }, 50);
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
	var url;

	switch(type) {
	case 'home':
		wrapper.append('<section class="page loading" id="home"></section>');
		url = template_dir + '/home.php';
		break;
	case 'page':
		wrapper.append('<section class="page loading" id="'+name+'"></section>');
		url = template_dir + '/load-post.php?page=' + name;
		break;
	case 'cat':
		wrapper.append('<section class="category loading" id="'+name+'"></section>');
		url = template_dir + '/load-post.php?cat=' + name;
		break;
	case 'post':
	default:
		wrapper.append('<section class="post loading" id="'+name+'"></section>');
		url = template_dir + '/load-post.php?post=' + name;
		break;
	}

	var item = $('#' + name);

	$.ajax({
		url: url,
		success: function(data) {
			item.removeClass('loading');
			item.html(data);
			$('.navLink').click(navLinkClick);

			socialLinks();
		},
		error: function(data, status) {
			item.html("Error " + status + ":\n" + data);
		}
	});
}

function socialLinks() {
	$('.fblink').click(function(evt) {
		evt.preventDefault();
		var popup = window.open(evt.target.href,
		                        'Share Verde',
		                        'location=0,toolbar=0,status=0,resizable=1,width=626,height=436');
		if (window.focus) {popup.focus();}
	});
}
