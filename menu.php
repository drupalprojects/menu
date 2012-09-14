<?php
/**
 * @file
 * menu.php
 */

chdir('../../../../');
require_once 'includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo ('<dropdown>
    <settings
    menuColor = "0x' . variable_get('menu_background_color', 'F2F2F2') . '"
    menuFontColor = "0x' . variable_get('menu_text_color', '525A66') . '"
    menuFontGlowColor = "0x' . variable_get('menu_hover_color', '7FBFFF') . '"
    subMenuFontColor = "0x' . variable_get('submenu_text_color', '525A66') . '"
    subMenuFontGlowColor = "0x' . variable_get('submenu_hover_color', '7FBFFF') . '"
    >
    </settings>');
$menu_type = variable_get('folder_menu_menu_parent', 'primary-links');
$menus = menu_tree_all_data($menu_type);

foreach ($menus as $menu) {
  $menulink = $menu['link'];
  if (strstr($menulink['link_path'], 'http')) {
    echo '<menu cap="' . $menulink['title'] . '" url = "' . $menulink['link_path'] . '" window = "_self">';
  }
  else {
    echo '<menu cap="' . $menulink['title'] . '" url = "?q=' . $menulink['link_path'] . '" window = "_self">';
  }

  $submenus = $menu['below'];
  if ($submenus != FALSE) {
    foreach ($submenus as $submenu) {
      $submenulink = $submenu['link'];
      if(strstr($submenulink['link_path'], 'http')) {
        echo '<submenu cap="' . $submenulink['title'] . '" url = "' . $submenulink['link_path'] . '" window = "_self"></submenu>';
      }
      else {
        echo '<submenu cap="' . $submenulink['title'] . '" url = "?q=' . $submenulink['link_path'] . '" window = "_self"></submenu>';
      }
    }
  }
  echo '</menu>';
}
echo '</dropdown>';
