<?php

class verde_walker_nav_menu extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth=0, $args=Array()) {
		if($depth > 0) return;
		$output .= "\n".'<ul class="sub_menu">'."\n";
	}

	function start_el(&$output, $item, $depth=0, $args=Array(), $id=0) {
		$ver = isset($_GET['ver']) ? $_GET['ver'] : false;

		if($depth > 1) return;
		$output .= '<li>';
		switch ($item->object) {
			case "category":
			$cat = get_category($item->object_id);
			$slug = $cat->slug;
			global $archive_ID;
			if($cat->cat_ID == $archive_ID) {
				$item_output = '<a id="archivelink">';
			} else if($cat->parent == $archive_ID) {
				$item_output = "<a href=\"?ver=$slug\">";
			} else {
				$link = $ver ? "?ver=$ver&cat=$slug" : "?cat=$slug";
				$item_output = "<a class=\"navlink\" href=\"$link\" data-target=\"cat:$slug\""
										 . "id=\"{$slug}link\">";
			}
			break;
			case "page":
			$slug = get_post($item->object_id)->post_name;
			$link = $ver ? "?ver=$ver&page=$slug" : "?page=$slug";
			$item_output = "<a class=\"navlink\" href=\"$link\" data-target=\"page:$slug\""
										 . "id=\"{$slug}link\">";
			break;
			case "post":
			$slug = get_post($item->object_id)->post_name;
			$link = $ver ? "?ver=$ver&post=$slug" : "?post=$slug";
			$item_output = "<a class=\"navlink\" href=\"$link\" data-target=\"$slug\""
									 . "id=\"{$slug}link\">";
			break;
			case "custom":
			if($item->url == site_url()) {
				$item_output = '<a class="navlink" href="/" data-target="home"'
										 . "id=\"homelink\">";
				break;
			}
			default:
			error_log("Different object type: ".$item->object."\nWith url: ".$item->url);
			break;
		}
		$item_output .= $item->title;
		$item_output .= '</a>';
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

?>
