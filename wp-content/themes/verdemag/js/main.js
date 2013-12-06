var body, nav, navTop, footer, pages, selected, toSelect, mask, wrapper, zoomed, ver, History, jQuery, template_dir;

var LOADER = '<h1>Loading</h1><div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div>';

var $ = jQuery;

$(document).ready(function() {
	body = $('body');
	pages = $('.page');
	selected = pages.first();
	mask = $('#mask');
	nav = $('nav');
	navTop = nav.offset().top;
	wrapper = $('main');
	zoomed = true;

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

	toSelect = $('.select');
	if(toSelect.length != 0) {
		selected = toSelect;
		selected.removeClass('select');
	} else {
		selected = $('#home');
	}

	mask.css('min-height', $(window).height() - mask.offset().top);
});

$(window).load(function() {
	var navLink = $('nav .navLink[data-target="'+selected.attr('id')+'"]');
	if(navLink.length > 0)
		highlightItem(navLink);
	selected.show();
	resizeMask();

	socialLinks();

	$('#loader').hide();
});

$(window).on('statechange', function() {
	var stateData = History.getState().data;
	if (!$.isEmptyObject(stateData)) {
		switchToItem(stateData.post);
	} else {
		switchToItem('home');
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
		var state = { post: targetID };
		url = ver ? '/?ver='+ver+'&' : '?';
		if(targetID == 'home')
			url = ver ? '/?ver='+ver : '/';
		else if(targetID == 'about')
			url += 'page=about';
		else if($('#'+targetID).hasClass('category'))
			url += 'page=' + targetID;
		else
			url += 'post=' + targetID;

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

function switchToItem(name) {
	highlightItem($('nav .navLink[data-target="'+name+'"]'));

	var old = $(selected);

	if($('#' + name).length == 0) {
		getItem(name);
	}
	selected = $('#' + name);
	if(selected.length == 0) {
		selected = old;
		return;
	}
	selected.show();
	wrapper.css('left', -old.position().left);

	wrapper.stop().animate({top:-selected.position().top, left:-selected.position().left},
	                       500, 'swing', function() {
		                       resizeMask();
		                       old.hide();
		                       wrapper.css('left', -selected.position().left);
	                       });
}

function getItem(name) {
	wrapper.width(wrapper.width() + 960);
	wrapper.append('<section class="post loading" id="'+name+'"></section>');
	var item = $('#' + name);
	item.html(LOADER);

	var url = template_dir + '/load-post.php?post=' + name;
	$.ajax({
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
	$('.fblink').click(function(evt) {
		evt.preventDefault();
		var popup = open(evt.target.href,
		                    'Share Verde',
		                    'location=0,toolbar=0,status=0,resizable=1,width=626,height=436');
		if (window.focus) {popup.focus();}
	});
}
