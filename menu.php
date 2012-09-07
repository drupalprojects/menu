<?php

chdir ('../../../../');
require_once 'includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo('<dropdown>
		<settings
			menuColor = "0x'.variable_get('menu_background_color', 'F2F2F2').'"
			menuFontColor = "0x'.variable_get('menu_text_color', '525A66').'"
			menuFontGlowColor = "0x'.variable_get('menu_hover_color', '7FBFFF').'"
			subMenuFontColor = "0x'.variable_get('submenu_text_color', '525A66').'"
			subMenuFontGlowColor = "0x'.variable_get('submenu_hover_color', '7FBFFF').'"
			>	
		</settings>');
	
	$menu_type = variable_get('folder_menu_menu_parent', 'primary-links');	
	$menus = menu_tree_all_data($menu_type);
	
	foreach($menus as $menu) {
		$menuLink = $menu['link'];
		if(strstr($menuLink['link_path'],'http'))
			echo '<menu cap="'.$menuLink['title'].'" url = "'.$menuLink['link_path'].'" window = "_self">';
		else
			echo '<menu cap="'.$menuLink['title'].'" url = "?q='.$menuLink['link_path'].'" window = "_self">';
		
		$submenus = $menu['below'];
		if ($submenus != false) {
			foreach ($submenus as $submenu) {
				$submenuLink = $submenu['link'];
				if(strstr($submenuLink['link_path'],'http'))
					echo '<submenu cap="'.$submenuLink['title'].'" url = "'.$submenuLink['link_path'].'" window = "_self"></submenu>';
				else
					echo '<submenu cap="'.$submenuLink['title'].'" url = "?q='.$submenuLink['link_path'].'" window = "_self"></submenu>';
			}
		}
		echo '</menu>';
	}
	echo '</dropdown>';

?>