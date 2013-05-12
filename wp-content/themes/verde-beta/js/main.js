jQuery(document).ready(function() {
	window.footer = jQuery('#footer');
	footer.collapseHeight = footer.find('.row').first().height();
	footer.css('height','auto');
	footer.totalHeight = footer.height();
	footer.css('height', footer.collapseHeight);

	window.pages = jQuery('.page');
	window.selected = pages.first();
	window.mask = jQuery('#mask');
	window.wrapper = jQuery('#wrapper');
	window.zoomed= true;

	jQuery('#logo').click(function(event) {
		switchToItem('#home');
	});

	jQuery('.newsButton').click(function(event) {
		jQuery(event.target).parent().parent().animate({maxHeight: 300}, 1000);
		jQuery(event.target).parent().animate({height: 0}, 300);
		jQuery(event.target).fadeOut(700);
	});

	jQuery('.navLink').click(function(event) {
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
});

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
